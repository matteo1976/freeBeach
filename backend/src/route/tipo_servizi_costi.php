<?php

use \Psr\Http\Message\ServerRequestInterface;
use \Psr\Http\Message\ResponseInterface;
use \Propel\Runtime\ActiveQuery\Criteria;

require_once 'src/swagger/CostoServizio.php';

/**
 * GET tipoServiziIdTipoServizioCostiServizoGet
 * Summary:
 * Notes: Restituisce il costo del tipo servizi. ad una tipologia di servizio si possono associare diversi costi in base la periodo, alla data, un lettino ad agosto potrebbe costare di piu che a maggio
 * Output-Formats: [application/json]
 */
$app->GET('/tipiServizio/{idTipoServizio}/costiServizio',
    function(ServerRequestInterface $request, ResponseInterface $response, $args) {
    try {
        //verifico che il parametro sia un numerico
        $idTipoServizio = $args['idTipoServizio'];
        if (!is_numeric($idTipoServizio)) {
            return Web::error400('idTipoServizio', $response);
        }

        $query = CostiServizioQuery::create()
            ->filterByIdTipoServizio($idTipoServizio);

        $queryParams = $request->getQueryParams();

        if (Web::assertParam($queryParams, 'inizioPeriodo')) {
            if (!Web::isData($queryParams['inizioPeriodo'])) {
                return Web::error400('inizioPeriodo', $response);
            }

            $query = $query->filterByFinePeriodo($queryParams['inizioPeriodo'],
                Criteria::GREATER_EQUAL);
        }

        if (Web::assertParam($queryParams, 'finePeriodo')) {
            if (!Web::isData($queryParams['finePeriodo'])) {
                return Web::error400('finePeriodo', $response);
            }
// TODO: @mat Ma così non prende anche quelli che iniziavano prima dell'intervallo di interesse?
// Secondo me ci va un between. Idem sopra
            $query = $query->filterByInizioPeriodo($queryParams['finePeriodo'], Criteria::LESS_EQUAL);
        }

        if (Web::assertParam($queryParams, 'attivoDa')) {
            if (!Web::isData($queryParams['attivoDa'])) {
                return Web::error400('attivoDa', $response);
            }

            $query = $query->filterByFinePeriodo($queryParams['attivoDa'], Criteria::GREATER_EQUAL);
        }

        $costi = $query->orderByInizioPeriodo()->find();
        $results = [];

        foreach ($costi as $costo) {
            $results[] = $costo->ToSwagger();
        }

        return Web::responseOk($response, json_encode($results));
    } catch (Exception $e) {
        return Web::error500($e, $response);
    }
});

/**
 * POST tipoServiziIdTipoServizioCostiServizoPost
 * Summary:
 * Notes: Aggiunge un costo alla tipologia di servizio
 * Output-Formats: [application/json]
 */
$app->POST('/tipiServizio/{idTipoServizio}/costiServizio',
    function(ServerRequestInterface $request, ResponseInterface $response, $args) {
    $myResponse = Web::setupResponseHeaders($response);

    try {
        //verifico che il parametro sia un numerico
        $idTipoServizio = $args['idTipoServizio'];

        if (!is_numeric($idTipoServizio)) {
            return Web::error400('idTipoServizio', $response);
        }

        $tipoServizio = TipiServizioQuery::create()
            ->filterByIdTipoServizio($idTipoServizio)
            ->count();

        if ($tipoServizio === 0) {
            return Web::error404($response);
        }

        $body = $request->getParsedBody();

        if (web::assertParam($body, 'inizioPeriodo')) {
            $inizioPeriodo = Web::toDateTime($body['inizioPeriodo'], 'inizioPeriodo');
            $inizioPeriodo->setTime(0, 0, 0);
        } else {
            $inizioPeriodo = null;
        }

        if (web::assertParam($body, 'finePeriodo')) {
            $finePeriodo = Web::toDateTime($body['finePeriodo'], 'finePeriodo');
            $finePeriodo->setTime(23, 59, 59);
        } else {
            $finePeriodo = null;
        }

        $costo = $body['costo'];
        if (!is_numeric($costo)) {
            return Web::error400('costo', $response);
        }

        $costi_free= CostiServizioQuery::create()
            ->filterByIdTipoServizio($idTipoServizio)
            ->filterByFinePeriodo($inizioPeriodo, Criteria::GREATER_EQUAL)
            ->_and()
            ->filterByInizioPeriodo($finePeriodo, Criteria::LESS_EQUAL)
            ->find()
            ->toArray();
        if (count($costi_free)!==0) {
            $myResponse->getBody()->write(json_encode([$costi_free]));
            return Web::error400('intervallo di date non valido', $response);
        }

        $costiServizi = new CostiServizio();
        $costiServizi->setIdTipoServizio($idTipoServizio);
        $costiServizi->setCosto($costo);
        $costiServizi->setInizioPeriodo($inizioPeriodo);
        $costiServizi->setFinePeriodo($finePeriodo);
        $costiServizi->save();
        $costiServizi->getIdCosto();

        return Web::responseOk($response, json_encode([
            'idCosto' => $costiServizi->getIdCosto()
        ]));
    } catch (Exception $e) {
        return Web::error500($e, $response);
    }
});

/**
 * OPTIONS tipoServiziIdTipoServizioCostiServizoOptions
 * Summary:
 * Notes:
 * Output-Formats: [application/json]
 */
$app->OPTIONS('/tipiServizio/{idTipoServizio}/costiServizio',
    function(ServerRequestInterface $request, ResponseInterface $response) {
    return Web::setupResponseHeaders($response);
});

/**
 * DELETE tipoServiziIdTipoServizioCostiServizoIdCostoServizioDelete
 * Summary:
 * Notes: Cancella il costo della tipologia di un servizio
 * Output-Formats: [application/json]
 */
$app->DELETE('/tipiServizio/{idTipoServizio}/costiServizio/{idCostoServizio}',
    function(ServerRequestInterface $request, ResponseInterface $response, $args) {
    try {
        //verifico che il parametro sia un numerico
        $idTipoServizio = $args['idTipoServizio'];
        $idCostoServizio = $args['idCostoServizio'];

        if (!is_numeric($idTipoServizio)) {
            return Web::error400('idTipoServizio', $response);
        }
        if (!is_numeric($idCostoServizio)) {
            return Web::error400('idCostoServizio', $response);
        }

        $costoServizio = CostiServizioQuery::create()
            ->filterByIdTipoServizio($idTipoServizio)
            ->filterByIdCosto($idCostoServizio)
            ->find();
        if (count($costoServizio) == 0) {
            return Web::error404($response);
        }
        if ($costoServizio === null) {
            $costoServizio = [];
        }

        $results = [];
        foreach ($costoServizio as $costoServ) {
            $results[] = $costoServ->ToSwagger();
        }

        CostiServizioQuery::create()
            ->filterByIdTipoServizio($idTipoServizio)
            ->filterByIdCosto($idCostoServizio)
            ->delete();

        return Web::responseOk($response, json_encode($results));
    } catch (Exception $e) {
        return Web::error500($e, $response);
    }
});


/**
 * GET tipoServiziIdTipoServizioCostiServizoIdCostoServizioGet
 * Summary:
 * Notes: Restituisce il costo di una tipologia di servizi
 * Output-Formats: [application/json]
 */
$app->GET('/tipiServizio/{idTipoServizio}/costiServizio/{idCostoServizio}',
    function(ServerRequestInterface $request, ResponseInterface $response, $args) {
    try {
        $idTipoServizio = $args['idTipoServizio'];
        $idCostoServizio = $args['idCostoServizio'];

        if (!is_numeric($idTipoServizio)) {
            return Web::error400('idTipoServizio', $response);
        }
        if (!is_numeric($idCostoServizio)) {
            return Web::error400('idCostoServizio', $response);
        }

        $costoServizio = CostiServizioQuery::create()
            ->filterByIdTipoServizio($idTipoServizio)
            ->filterByIdCosto($idCostoServizio)
            ->find();

        $results = [];

        foreach ($costoServizio as $costoServ) {
            $results[] = $costoServ->ToSwagger();
        }

        return Web::responseOk($response, json_encode($results));
    } catch (Exception $e) {
        return Web::error500($e, $response);
    }
});


/**
 * PUT tipoServiziIdTipoServizioCostiServizoIdCostoServizioPut
 * Summary:
 * Notes: Aggiorna il costodella tipologia di un servizio
 * Output-Formats: [application/json]
 */
$app->PUT('/tipiServizio/{idTipoServizio}/costiServizio/{idCostoServizio}',
    function(ServerRequestInterface $request, ResponseInterface $response, $args) {
    define(ID_COSTO_SERVIZIO, 'idCostoServizio');
    $myResponse = Web::setupResponseHeaders($response);
    try {
        //verifico che il parametro sia un numerico
        $idTipoServizio = $args['idTipoServizio'];
        $idCostoServizio = $args['idCostoServizio'];

        if (!is_numeric($idTipoServizio)) {
            return Web::error400('idTipoServizio', $response);
        }
        if (!is_numeric($idCostoServizio)) {
            return Web::error400('idCostoServizio', $response);
        }

        $body = $request->getParsedBody();

        if (web::assertParam($body, 'inizioPeriodo')) {
            $inizioPeriodo = Web::toDateTime($body['inizioPeriodo'], 'inizioPeriodo');
            $inizioPeriodo->setTime(0, 0, 0);
        } else {
            $inizioPeriodo = null;
        }

        if (web::assertParam($body, 'finePeriodo')) {
            $finePeriodo = Web::toDateTime($body['finePeriodo'], 'finePeriodo');
            $finePeriodo->setTime(23, 59, 59);
        } else {
            $finePeriodo = null;
        }

        $costi_free= CostiServizioQuery::create()
            ->filterByIdTipoServizio($idTipoServizio)
            ->filterByFinePeriodo($inizioPeriodo, Criteria::GREATER_EQUAL)
            ->_and()
            ->filterByInizioPeriodo($finePeriodo, Criteria::LESS_EQUAL)
            ->find()
            ->toArray();
        if (count($costi_free)!==0) {
            $myResponse->getBody()->write(json_encode([$costi_free]));
            return Web::error400('intervallo di date non valido', $response);
        }
        
        $costo = $body['costo'];
        if (!is_numeric($costo)) {
            return Web::error400('costo', $response);
        }
        
        $costoServizio = CostiServizioQuery::create()->findOneByIdCosto($idCostoServizio);
        $costoServizio->setIdTipoServizio($idTipoServizio);
        $costoServizio->setCosto($costo);
        $costoServizio->setInizioPeriodo($inizioPeriodo);
        $costoServizio->setFinePeriodo($finePeriodo);
        $costoServizio->save();

        return Web::responseOk($response, json_encode([ID_COSTO_SERVIZIO => $costoServizio->getIdCosto()]));
    } catch (Exception $e) {
        return Web::error500($e, $response);
    }
});


/**
 * OPTIONS tipoServiziIdTipoServizioCostiServizoIdCostoServizioOptions
 * Summary:
 * Notes:
 * Output-Formats: [application/json]
 */
$app->OPTIONS('/tipiServizio/{idTipoServizio}/costiServizio/{idCostoServizio}',
    function(ServerRequestInterface $request, ResponseInterface $response) {
    return Web::setupResponseHeaders($response);
});

