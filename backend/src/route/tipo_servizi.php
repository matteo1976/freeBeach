<?php

use \Psr\Http\Message\ServerRequestInterface;
use \Psr\Http\Message\ResponseInterface;
use \Propel\Runtime\ActiveQuery\Criteria;

require_once 'src/swagger/CostoServizio.php';

/**
 * GET tipoServiziGet
 * Summary:
 * Notes: Restituisce il tipo servizi.
 * Output-Formats: [application/json]
 */
$app->GET('/tipiServizio',
    function(ServerRequestInterface $request, ResponseInterface $response, $args) {
    try {
        $queryParams = $request->getQueryParams();
        $filtro = '%';
        $filtroDati = null;

        if (Web::assertParam($queryParams, 'filtro')) {
            $filtro = '%' . $queryParams['filtro'] . '%';
        }

        if (Web::assertParam($queryParams, 'filtroDati')) {
            $filtroDati = Web::toDateTime($queryParams['filtroDati'], 'filtroDati');
        }

        $tipoServizi = TipiServizioQuery::create()
            ->filterByDescrizione($filtro, Criteria::LIKE)
            ->orderByDescrizione()
            ->find();

        $results = [];
        foreach ($tipoServizi as $tipo) {
            $results[] = $tipo->ToSwagger($filtroDati);
        }

        return Web::responseOk($response, json_encode($results));
    } catch (BadRequestException $bre) {
        return Web::error400($bre->fieldName, $response);
    } catch (Exception $e) {
        return Web::error500($e, $response);
    }
});


/**
 * POST tipoServiziPost
 * Summary:
 * Notes: Aggiunge una tipologia di servizio
 * Output-Formats: [application/json]
 */
$app->POST('/tipiServizio',
    function(ServerRequestInterface $request, ResponseInterface $response, $args) {

    try {
        $body = $request->getParsedBody();

        // prendo i dati dal body e li pulisco di eventuali caratteri speciali
        $body['descrizione'] = web::PulisciStr($body['descrizione']);
        if ($body['descrizione'] == "") {
            return Web::error400('descrizione', $response);
        }

        // TODO: Allineare i nomi delle entità e utilizzare la importFrom
        // come nell'esempio invece dei metodi custom ToSwagger()
        // $book->importFrom('JSON', '{"Id":9012,"Title":"Don Juan","ISBN":"0140422161","Price":12.99,"PublisherId":1234,"AuthorId":5678}');
        // VECCHIO CODICE. Salva solo i dati del tipo servizio, non i costi
        // $tipiServizio = new TipiServizio();
        // $tipiServizio->setDescrizione($descrizione);

        $tipiServizio = new TipiServizio();
        $tipiServizio->FromSwagger($body);
        $tipiServizio->save();

        return Web::responseOk($response,
                json_encode([
                'idTipoServizio' => $tipiServizio->getIdTipoServizio()
        ]));
    } catch (Exception $e) {
        return Web::error500($e, $response);
    }
});

/**
 * OPTIONS tipoServiziOptions
 * Summary:
 * Notes:
 * Output-Formats: [application/json]
 */
$app->OPTIONS('/tipiServizio',
    function(ServerRequestInterface $request, ResponseInterface $response) {
    return Web::setupResponseHeaders($response);
});


/**
 * GET tipoServiziIdTipoServizioGet
 * Summary:
 * Notes: Restituisce una tipologia di servizi
 * Output-Formats: [application/json]
 */
$app->GET('/tipiServizio/{idTipoServizio}',
    function(ServerRequestInterface $request, ResponseInterface $response, $args) {
    try {

        $idTipoServizio = $args['idTipoServizio'];

        //verifico che il parametro sia un numerico
        if (!is_numeric($idTipoServizio)) {
            return Web::error400('idTipoServizio', $response);
        }

// VECCHIO CODICE
//        $tipoServizi = TipiServizioQuery::create()
//            ->filterByPrimaryKey($args['idTipoServizio'])
//            ->find();
//
//        //echo $conn->getLastExecutedQuery();
//        if ($tipoServizi === null) {
//            $tipoServizi = [];
//        }
//
//        $results = [];
//        // senza foreach da errore!!!
//        foreach ($tipoServizi as $tipo) {
//            $results[] = $tipo->ToSwagger();
//        }
//        //var_dump($results);
//
//        $myResponse = Web::setupResponseHeaders($response);
//        $myResponse->getBody()->write(json_encode($results));

        $tipoServizio = TipiServizioQuery::create()
            ->findPk($idTipoServizio);

        if ($tipoServizio === null) {
            return Web::error404($response);
        } else {
            $queryParams = $request->getQueryParams();
            if (Web::assertParam($queryParams, 'filtroDati')) {
                $filtroDati = Web::toDateTime($queryParams['filtroDati'], 'filtroDati');
            }

            return Web::responseOk($response, json_encode($tipoServizio->ToSwagger($filtroDati)));
        }
    } catch (BadRequestException $bre) {
        return Web::error400($bre->fieldName, $response);
    } catch (Exception $e) {
        return Web::error500($e, $response);
    }
});


/**
 * PUT tipoServiziIdTipoServizioPut
 * Summary:
 * Notes: Aggiorna la tipologia di un servizio
 * Output-Formats: [application/json]
 */
$app->PUT('/tipiServizio/{idTipoServizio}',
    function(ServerRequestInterface $request, ResponseInterface $response, $args) {
    define(ID_TIPO_SERVIZIO, 'idTipoServizio');
    $con = null;

    try {
        $con = web::getConnection();

        //verifico che il parametro sia un numerico
        $idTipoServizio = $args[ID_TIPO_SERVIZIO];
        if (!is_numeric($idTipoServizio)) {
            return Web::error400(ID_TIPO_SERVIZIO, $response);
        }

// VECCHIO CODICE
//        $tipoServizio = TipiServizioQuery::create()
//            ->findByIdTipoServizio($idTipoServizio)
//            ->count();
//
//        if ($tipoServizio === 0) {
//            return Web::error404($response);
//        }
//        $body = $request->getParsedBody();
//
//        // prendo i dati dal body e li pulisco di eventuali caratteri speciali
//        $descrizione = web::PulisciStr($body['descrizione']);
//
//        if ($descrizione === "") {
//            return Web::error400('descrizione', $response);
//        }
//        //inserisco i dati
//        $tipiServizio = TipiServizioQuery::create()->findOneByIdTipoServizio($idTipoServizio);
//        $tipiServizio->setDescrizione($descrizione);
//        $tipiServizio->save();
//        $tipiServizio->getIdTipoServizio();

        $tipoServizio = TipiServizioQuery::create()
            ->findPk($idTipoServizio, $con);

        if ($tipoServizio === null) {
            return Web::error404($response);
        } else {
            // Se il parametro tipo servizio non contiene l'array costo
            // lasciamo i costi invariati. Se invece l'array costo è dichiarato,
            // anche vuoto, i vecchi costi vengono sostituiti dai nuovi.

            $con->beginTransaction();

//            CostiServizioQuery::create()
//                ->filterByPrimaryKey($idTipoServizio)
//                ->delete($con);

            $tipoServizio->FromSwagger($request->getParsedBody());
            $tipoServizio->setIdTipoServizio($idTipoServizio);
            $tipoServizio->save($con);

            $con->commit();

            return Web::responseOk($response, null);
        }
    } catch (Exception $e) {
        $con->rollBack();
        return Web::error500($e, $response);
    }
});

/**
 * DELETE tipoServiziIdTipoServizioDelete
 * Summary:
 * Notes: Cancella la tipologia di un servizio
 * Output-Formats: [application/json]
 */
$app->DELETE('/tipiServizio/{idTipoServizio}',
    function(ServerRequestInterface $request, ResponseInterface $response, $args) {
    $con = null;

    try {
        $con = web::getConnection();
        $idTipoServizio = $args['idTipoServizio'];

        //verifico che il parametro sia un numerico
        if (!is_numeric($idTipoServizio)) {
            return Web::error400('idTipoServizio', $response);
        }

//        $tipoServizi = TipiServizioQuery::create()
//            ->filterByPrimaryKey($idTipoServizio)
//            ->find();
//        if (count($tipoServizi) === 0) {
//            return Web::error404($response);
//        }
//        if ($tipoServizi === null) {
//            $tipoServizi = [];
//        }
//
//        foreach ($tipoServizi as $tipo) {
//            $results[] = $tipo->ToSwagger();
//        }
//        $con->beginTransaction();
//
//        CostiServizioQuery::create()
//            ->filterByIdTipoServizio($idTipoServizio)
//            ->delete();
//        TipiServizioQuery::create()
//            ->filterByPrimaryKey($idTipoServizio)
//            ->delete();
//
//        $con->commit();
//        $con->rollBack();
//
//        $myResponse = Web::setupResponseHeaders($response);
//        $myResponse->getBody()->write(json_encode($results));

        $tipoServizio = TipiServizioQuery::create()
            ->findPk($idTipoServizio);

        if ($tipoServizio === null) {
            return Web::error404($response);
        } else {
            $result = $tipoServizio->ToSwagger();

            $con->beginTransaction();

            // TODO: va in errore perché non cancella i costi
            CostiServizioQuery::create()
                ->filterByPrimaryKey($idTipoServizio)
                ->delete($con);

            $tipoServizio->delete($con);

            $con->commit();

            return Web::responseOk($response, json_encode($result));
        }
    } catch (Exception $e) {
        // TODO: la rollback potrebbe andare in errore se la transazione non esiste
        // Implementare una funzione statica che esegue il rollback, intercetta
        // eventuali eccezioni e le ignora.
        $con->rollBack();
        return Web::error500($e, $response);
    }
});

/**
 * OPTIONS tipoServiziIdTipoServizioOptions
 * Summary:
 * Notes:
 * Output-Formats: [application/json]
 */
$app->OPTIONS('/tipiServizio/{idTipoServizio}',
    function(ServerRequestInterface $request, ResponseInterface $response) {
    return Web::setupResponseHeaders($response);
});
