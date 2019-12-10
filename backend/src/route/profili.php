<?php

// vim: set ts=4 sw=4 expandtab:

use \Psr\Http\Message\ServerRequestInterface;
use \Psr\Http\Message\ResponseInterface;
use \Propel\Runtime\ActiveQuery\Criteria;

//*********************************************************** /PROFILI
/**
 * GET profiliGet
 * Summary:
 * Notes: Restituisce la lista degli oggetti &#x60;Profilo&#x60; definiti
 * Output-Formats: [application/json]
 */
$app->GET('/profili',
    function(ServerRequestInterface $request, ResponseInterface $response, $args) {
    try {
        $queryParams = $request->getQueryParams();

        //verifico se ci sono criteri di ricerca se ci sono imposto la ricerca
        if (array_key_exists('filtro', $queryParams)) {
            $varfiltro = '%' . $queryParams['filtro'] . '%';
        } else {
            $varfiltro = '%';
        }

//        $profili = ProfiliQuery::create()
//            ->filterByDescrizione($varfiltro, Criteria::LIKE);
//        $profili = ProfiliQuery::joinProfili_Privilegi($profili, Criteria::LEFT_JOIN);
//        $profili = $profili
//            ->find()
//            ->toArray();

        $profili = ProfiliQuery::create()
            ->filterByDescrizione($varfiltro, Criteria::LIKE)
            ->find()
            ->toArray();

        // Creo la risposta aggiungendo gli headers necessari
        $myResponse = Web::setupResponseHeaders($response);

        // Carica i dati nel body della risposta
        $myResponse->getBody()
            ->write(json_encode($profili));

        return $myResponse;
    } catch (Exception $e) {
        return Web::error500($e, $response);
    }
});

/**
 * POST profiliPost
 * Summary:
 * Notes: Crea un nuovo &#x60;Profilo&#x60;
 * Output-Formats: [application/json]
 */
$app->POST('/profili',
    function(ServerRequestInterface $request, ResponseInterface $response, $args) {
    $con = web::getConnection();

    try {
        // prendo i dati dal body e li pulisco di eventuali caratteri speciali
        $body = $request->getParsedBody();

        $descrizione = web::PulisciStr($body['descrizione']);

        if ($descrizione == "") {
            return Web::error400('descrizione', $response);
        }

        // i privilegi sono pre inseriti nel db
        // ho bisogno del'id per creare il collegamento privilegi_profilo
        $idPrivilegio = $body['id_privilegio'];
        if (!is_numeric($idPrivilegio)) {
            return Web::error400('id_privilegio', $response);
        }

        $privilegi = PrivilegiQuery::create()
            ->filterByIdPrivilegio($idPrivilegio)
            ->find();

        //inserisco i dati
        $con->beginTransaction();

        $profili = new Profili();
        $profili->setDescrizione($descrizione);
        $profili->setPrivilegis($privilegi);
        $profili->save();
        $profili->getIdProfilo();

        $con->commit();

        $myResponse = Web::setupResponseHeaders($response);
        $myResponse->getBody()
            ->write(json_encode($profili->toArray()));

        return $myResponse;
    } catch (Exception $e) {
        $con->rollBack();
        return Web::error500($e, $response);
    }
});


/**
 * OPTIONS profiliOptions
 * Summary:
 * Notes:
 * Output-Formats: [application/json]
 */
$app->OPTIONS('/profili',
    function(ServerRequestInterface $request, ResponseInterface $response) {
    $myResponse = Web::setupResponseHeaders($response);
    return $myResponse;
});
//*********************************************************** /PROFILI/IDPROFILO


/**
 * GET profiliIdProfiloGet
 * Summary:
 * Notes: Restituisce l&#39;anagrafica del &#x60;Profilo&#x60;
 * Output-Formats: [application/json]
 */
$app->GET('/profili/{idProfilo}',
    function(ServerRequestInterface $request, ResponseInterface $response, $args) {
    try {
        //verifico che il parametro sia un numerico
        if (!is_numeric($args['idProfilo'])) {
            return Web::error400('idProfilo', $response);
        }

        $profili = ProfiliQuery::create()
            ->filterByIdProfilo($args['idProfilo']);
        $profili = ProfiliQuery::joinProfili_Privilegi($profili);
        $profili = $profili
            ->find()
            ->toArray();

        if ((count($profili) == 0)) {
            $tmpError = Web::error404();
            $response->getBody()->write($tmpError);
            return $response->withStatus(404);
        }

        $myResponse = Web::setupResponseHeaders($response);
        $myResponse->getBody()
            ->write(json_encode($profili));

        return $myResponse;
    } catch (Exception $e) {
        Web::error500($e, $response);
    }
});

/**
 * PUT profiliIdProfiloPut
 * Summary:
 * Notes: Aggiorna il &#x60;Profilo&#x60;. L&#39;id fornito sulla rotta sovrascrive quello possibilmente dichiarato nel body
 * Output-Formats: [application/json]
 */
$app->PUT('/profili/{idProfilo}',
    function(ServerRequestInterface $request, ResponseInterface $response, $args) {
    $con = web::getConnection();

    try {
        $body = $request->getParsedBody();

        // prendo i dati dal body e li pulisco di eventuali caratteri speciali
        $descrizione = web::PulisciStr($body['descrizione']);
        if ($descrizione == "") {
            return Web::error400('descrizione', $response);
        }

        // i privilegi sono pre inseriti nel db
        // ho bisogno del'id per creare il collegamento privilegi_profilo
        $idPrivilegio = $body['id_privilegio'];
        if (!is_numeric($idPrivilegio)) {
            return Web::error400('id_privilegio', $response);
        }

        $privilegi = PrivilegiQuery::create()
            ->filterByIdPrivilegio($idPrivilegio)
            ->find();

        $con->beginTransaction();

        $profilo = ProfiliQuery::create()
            ->findOneByIdProfilo($args['idProfilo']);
        $profilo->setDescrizione($descrizione);
        $profilo->setPrivilegis($privilegi);
        $profilo->save();

        $con->commit();

        $myResponse = Web::setupResponseHeaders($response);
        $myResponse->getBody()
            ->write(json_encode($profilo->toArray()));

        return $myResponse;
    } catch (Exception $e) {
        $con->rollBack();
        return Web::error500($e, $response);
    }
});


/**
 * DELETE profiliIdProfiloDelete
 * Summary:
 * Notes: Cancella un &#x60;Profilo&#x60;
 * Output-Formats: [application/json]
 */
$app->DELETE('/profili/{idProfilo}',
    function(ServerRequestInterface $request, ResponseInterface $response, $args) {
    $con = web::getConnection();

    try {
        //verifico che il parametro sia un numerico
        if (!is_numeric($args['idProfilo'])) {
            return Web::error400('idProfilo', $response);
        }

        $profili = ProfiliQuery::create()
            ->filterByIdProfilo($args['idProfilo']);
        $profili = ProfiliQuery::joinProfili_Privilegi($profili);
        $profili = $profili
            ->find()
            ->toArray();
        // se non trovo corrispondenze do un 404
        if ((count($profili) == 0)) {
            $tmpError = Web::error404('idProfilo');
            $response->getBody()->write($tmpError);
            return $response->withStatus(404);
        }

        $con->beginTransaction();
        ProfiliQuery::DeleteProfili($args['idProfilo']);
        $con->commit();

        $myResponse = Web::setupResponseHeaders($response);
        $myResponse->getBody()
            ->write(json_encode($profili));

        return $myResponse;
    } catch (Exception $e) {
        $con->rollBack();
        return Web::error500($e, $response);
    }
});

/**
 * OPTIONS profiliIdProfiloOptions
 * Summary:
 * Notes:
 * Output-Formats: [application/json]
 */
$app->OPTIONS('/profili/{idProfilo}',
    function(ServerRequestInterface $request, ResponseInterface $response) {
    $myResponse = Web::setupResponseHeaders($response);
    return $myResponse;
});
