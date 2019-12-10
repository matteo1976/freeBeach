<?php

use \Psr\Http\Message\ServerRequestInterface;
use \Psr\Http\Message\ResponseInterface;
use \Propel\Runtime\ActiveQuery\Criteria;

/**
 * GET postazioniGet
 * Summary:
 * Notes: Restituisce la lista delle postazioni che soddisfano i criteri di ricerca
 * Output-Formats: [application/json]
 */
$app->GET('/postazioni',
    function(ServerRequestInterface $request, ResponseInterface $response, $args) {
    $con = web::getConnection();
    $myResponse = Web::setupResponseHeaders($response);

    try {
        $params = $request->getQueryParams();
        $query = PostazioniQuery::create();

        // Ricerca assegnamenti mappa
        if (Web::assertParam($params, 'settore')) {
            $query = $query->filterBySettore($params['settore']);
        }
        if (Web::assertParam($params, 'fila')) {
            $query = $query->filterByFila($params['fila']);
        }
        if (Web::assertParam($params, 'colonna')) {
            $query = $query->filterByColonna($params['colonna'] . '%', Criteria::LIKE);
        }

        /* vado a vedere se ho messo una data di inizio
         * per la ricerca intervallo se non l'ho messa assegno la data odierna
         * non visualizzo mai assegnamenti finiti
         */
        if (Web::assertParam($params, 'assegn_inizio')) {

            $dataInizio = $params['assegn_inizio'];
            if (!Web::isData($dataInizio)) {
                return Web::error400('assegn_inizio', $response);
            }
        } else {
            $dataInizio = new DateTime();
        }

        //  $postazioni = $query->findByDisponibilita(new DateTime($params['assegn_inizio']),
        //  new DateTime($params['assegn_fine']));

// TODO: correggere la gestione date e verificare se funziona dopo aver allineato i nomi dei parametri
        $filtro = new Criteria();
        $filtro->add(Map\AssegnamentiPostazioneTableMap::COL_DATA_FINE, $dataInizio,
            Criteria::GREATER_EQUAL);

        //se inserisco il parametro assegn_fine la aggiungo al filtro
        if (Web::assertParam($params, 'assegn_fine')) {

            $dataFine = $params['assegn_fine'];

            if (!Web::isData($dataFine)) {
                return Web::error400('assegn_fine', $response);
            }

            $filtro->addAnd(Map\AssegnamentiPostazioneTableMap::COL_DATA_FINE, $dataFine,
                Criteria::LESS_EQUAL);
        }

        $postazioni = $query
            ->orderByY()
            ->orderByX()
            ->find();

        $results = [];

        foreach ($postazioni as $postazione) {
            //$results[] = $postazione->toSwagger($filtro);
            $results[] = $postazione->toSwaggerOne($filtro); //carico solo l'assegnamento corrente o il prossimo
        }

        $myResponse->getBody()
            ->write(json_encode($results));

        return $myResponse;
    } catch (Exception $e) {
        return Web::error500($e, $response);
    }
});

/**
 * POST postazioniPost
 * Summary:
 * Notes: Crea una postazione
 * Output-Formats: [application/json]
 */
$app->POST('/postazioni',
    function(ServerRequestInterface $request, ResponseInterface $response, $args) {
    $myResponse = Web::setupResponseHeaders($response);
    try {
        // prendo i dati dal body e li pulisco di eventuali caratteri speciali
        $body = $request->getParsedBody();

        $settore = null;
        if (web::assertParam($body, 'settore')) {
            $settore = web::PulisciStr($body['settore']);
        }

        //NB. non si puo' numerare fila o colonna partendo da 0
        if (!web::assertParam($body, 'fila')) {
            return Web::error400('fila', $response);
        }

        $fila = web::PulisciStr($body['fila']);
        if ($fila == "") {
            return Web::error400('fila', $response);
        }

        if (!web::assertParam($body, 'colonna')) {
            return Web::error400('colonna', $response);
        }

        $colonna = web::PulisciStr($body['colonna']);
        if ($colonna == "") {
            return Web::error400('colonna', $response);
        }

        if (!web::assertParam($body, 'x')) {
            return Web::error400('cordinata asse xx', $response);
        }

        $cordinataX = web::PulisciStr($body['x']);
        if ($fila == "") {
            return Web::error400('coordinata asse x', $response);
        }

        if (!web::assertParam($body, 'y')) {
            return Web::error400('coordinata asse y', $response);
        }

        $cordinataY = web::PulisciStr($body['y']);
        if ($fila == "") {
            return Web::error400('coordinata asse y', $response);
        }

        $note = web::PulisciStr($body['note']);

        //inserisco i dati
        $postazioni = new Postazioni();
        $postazioni->setSettore($settore);
        $postazioni->setFila($fila);
        $postazioni->setColonna($colonna);
        $postazioni->setX($cordinataX);
        $postazioni->setY($cordinataY);
        $postazioni->setNote($note);
        $postazioni->save();
        $postazioni->getIdPostazione();

        return Web::responseOk($response, json_encode([
            'idPostazione' => $postazioni->getIdPostazione()
        ]));
    } catch (Exception $e) {
        return Web::error500($e, $response);
    }
});


/**
 * OPTIONS postazioniOptions
 * Summary:
 * Notes:
 * Output-Formats: [application/json]
 */
$app->OPTIONS('/postazioni',
    function(ServerRequestInterface $request, ResponseInterface $response) {
    $myResponse = Web::setupResponseHeaders($response);
    return $myResponse;
});

//*******************************************************/postazioni/{idPostazione}

/**
 * GET postazioniIdPostazioneGet***********
 * Summary:
 * Notes: Restituisce l&#39;anagrafica della &#x60;Postazione&#x60;
 * Output-Formats: [application/json]
 */
$app->GET('/postazioni/{idPostazione}',
    function(ServerRequestInterface $request, ResponseInterface $response, $args) {
    $myResponse = Web::setupResponseHeaders($response);
    try {
        // 404 gestito in verificoPostazioneById
        $response = VerificoPostazioneById($response, $args);
        $params = $request->getQueryParams();

        if ($response->getStatusCode() >= 400) {
            return $response;
        }

        if (web::assertParam($params, 'assegn_inizio')) {
            $dataInizio = Web::toDateTime($params['assegn_inizio'], 'assegn_inizio');
        } else {
            $dataInizio = new DateTime();
        }

        $dataInizio->setTime(0, 0, 0);

        $filtro = new Criteria();
        $filtro->add(Map\AssegnamentiPostazioneTableMap::COL_DATA_FINE, $dataInizio,
            Criteria::GREATER_EQUAL);

        if (web::assertParam($params, 'assegn_fine')) {
            $dataFine = Web::toDateTime($params['assegn_fine'], 'assegn_fine');
            $dataFine->setTime(23, 59, 59);

            $filtro->addAnd(Map\AssegnamentiPostazioneTableMap::COL_DATA_FINE, $dataFine,
                Criteria::LESS_EQUAL);
        }

        $postazione = PostazioniQuery::create()
            ->findPk($args['idPostazione']);

        $result = $postazione->toSwagger($filtro);

        return Web::responseOk($response, json_encode($result));
    } catch (BadRequestException $bre) {
        return Web::error400($bre->fieldName, $response);
    } catch (Exception $e) {
        return Web::error500($e, $response);
    }
});

/**
 * PUT postazioniIdPostazionePut
 * Summary:
 * Notes: Aggiorna la &#x60;Postazione&#x60;
 * Output-Formats: [application/json]
 */
$app->PUT('/postazioni/{idPostazione}',
    function(ServerRequestInterface $request, ResponseInterface $response, $args) {
    $con = web::getConnection();

    try {
        $response = VerificoPostazioneById($response, $args);
        if ($response->getStatusCode() >= 400) {
            return $response;
        }

        // prendo i dati dal body e li pulisco di eventuali caratteri speciali
        $body = $request->getParsedBody();

        if (web::assertParam($body, 'settore')) {
            $settore = web::PulisciStr($body['settore']);
        } else {
            $settore = null;
        }

        //NB. non si puo' numerare fila o colonna partendo da 0
        if (!web::assertParam($body, 'fila')) {
            return Web::error400('fila', $response);
        }

        $fila = web::PulisciStr($body['fila']);
        if ($fila == "") {
            return Web::error400('fila', $response);
        }

        if (!web::assertParam($body, 'colonna')) {
            return Web::error400('colonna', $response);
        }

        $colonna = web::PulisciStr($body['colonna']);
        if ($colonna == "") {
            return Web::error400('colonna', $response);
        }

        $note = web::PulisciStr($body['note']);

        //TODO: dovrebbe essere sufficiente istanziare un oggetto Postazioni di propel invece di fare una query
        $postazioni = PostazioniQuery::create()->findPk($args['idPostazione']);
        $postazioni->setSettore($settore);
        $postazioni->setFila($fila);
        $postazioni->setColonna($colonna);
        $postazioni->setNote($note);
        $postazioni->save();

//        $myResponse->getBody()
//            ->write(json_encode($postazioni->toArray()));

        return Web::responseOk($response, null);
    } catch (Exception $e) {
        return Web::error500($e, $response);
    }
});

/**
 * DELETE postazioniIdPostazioneDelete
 * Summary:
 * Notes: Elimina la &#x60;Postazione&#x60;
 * Output-Formats: [application/json]
 */
$app->DELETE('/postazioni/{idPostazione}',
    function(ServerRequestInterface $request, ResponseInterface $response, $args) {
    $myResponse = Web::setupResponseHeaders($response);

    try {
        $con = web::getConnection();

        $response = VerificoPostazioneById($response, $args);
        if ($response->getStatusCode() >= 400) {
            return $response;
        }

        $idPostazione = $args['idPostazione'];
        $postazione = PostazioniQuery::create()
            ->findPk($idPostazione);

        if ($postazione === null) {
            return Web::error404($response);
        }

        // prendo gli le pk di assegnamento postazione
        $assegnamento = AssegnamentiPostazioneQuery::getPKFromIdPostazione($idPostazione);

        // prendo gli le pk di disponibilita postazione
        $disponibilita = DisponibilitaPostazioneQuery::getPKFromIdAssegnamento($assegnamento);


        // prendo gli le pk di subaffitti_postazione
        $subaffitti = SubaffittiPostazioneQuery::getPKFromIdDisponibilita($disponibilita);

        // Cancello le entità correlate alla postazione
        $con->beginTransaction();

        ServiziQuery::DeleteServiziByIdPostazioni($idPostazione);
        SubaffittiPostazioneQuery::deleteSubaffittiById($subaffitti);
        DisponibilitaPostazioneQuery::deleteDisponibilitaById($disponibilita);
        AssegnamentiPostazioneQuery::deleteAssegnamentiById($assegnamento);

        PostazioniQuery::create()
            ->filterByIdPostazione($idPostazione)
            ->delete();

        $con->commit();

        $myResponse->getBody()
            ->write(json_encode($postazione->toSwagger()));

        return $myResponse;
    } catch (Exception $e) {
        $con->rollBack();
        return Web::error500($e, $response);
    }
});

/**
 * OPTIONS postazioniIdPostazioneOptions
 * Summary:
 * Notes:
 * Output-Formats: [application/json]
 */
$app->OPTIONS('/postazioni/{idPostazione}',
    function(ServerRequestInterface $request, ResponseInterface $response) {
    return Web::setupResponseHeaders($response);
});

