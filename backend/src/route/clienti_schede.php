<?php

use \Psr\Http\Message\ServerRequestInterface;
use \Psr\Http\Message\ResponseInterface;


/**
 * Restituisce la lista delle schede del cliente
 * Output-Formats: [application/json]
 */
$app->GET('/clienti/{idCliente}/schede',
    function(ServerRequestInterface $request, ResponseInterface $response, $args) {
    try {
        $response = VerificoClienteById($response, $args);
        if ($response->getStatusCode() >= 400) {
            return $response;
        }

        $schede = SchedeQuery::create()
            ->filterByIdCliente($args['idCliente'])
            ->find();

        $results = [];
        foreach ($schede as $scheda) {
            $results[] = swagger\Scheda::LoadScheda($scheda);
        }

        $myResponse = Web::setupResponseHeaders($response);
        $myResponse->getBody()->write(json_encode($results));

        return $myResponse;
    } catch (Exception $e) {
        return Web::error500($e, $response);
    }
});

/**
 * Crea una nuova Scheda cliente
 * Output-Formats: [application/json]
 */
$app->POST('/clienti/{idCliente}/schede',
    function(ServerRequestInterface $request, ResponseInterface $response, $args) {
    try {
        $response = VerificoClienteById($response, $args);
        if ($response->getStatusCode() >= 400) {
            return $response;
        }

        // prendo i dati dal body e li pulisco di eventuali caratteri speciali
        $body = $request->getParsedBody();
        $codice = web::PulisciStr($body['codice']);
        if ($codice == "") {
            return Web::error400('codice', $response);
        }

        $importo = $body['importo'];
        if (!is_numeric($importo)) {
            return Web::error400('importo', $response);
        }

        $dataRilascio = $body['dataRilascio'];
        if (!Web::isData($dataRilascio)) {
            return Web::error400('dataRilascio', $response);
        }

        //inserisco i dati
        $scheda = new Schede();
        $scheda->setIdCliente($args['idCliente']);
        $scheda->setCodiceScheda($codice);
        $scheda->setImportoScheda($importo);
        $scheda->setDataRilascio($dataRilascio);
        $scheda->save();
        $scheda->getIdScheda();

        $myResponse = Web::setupResponseHeaders($response);
        $myResponse->write(json_encode($scheda->toArray()));

        return $myResponse;
    } catch (Exception $e) {
        return Web::error500($e, $response);
    }
});


/**
 * OPTIONS clientiIdClienteSchedeOptions
 * Summary:
 * Notes:
 * Output-Formats: [application/json]
 */
$app->OPTIONS('/clienti/{idCliente}/schede',
    function(ServerRequestInterface $request, ResponseInterface $response) {
    $myResponse = Web::setupResponseHeaders($response);
    return $myResponse;
});

/**
 * GET clientiIdClienteSchedeIdSchedaGet
 * Summary:
 * Notes: Restituisce l&#39;anagrafica della &#x60;Scheda&#x60; cliente
 * Output-Formats: [application/json]
 */
$app->GET('/clienti/{idCliente}/schede/{idScheda}',
    function(ServerRequestInterface $request, ResponseInterface $response, $args) {
    try {
        $response = VerificoClienteById($response, $args);
        if ($response->getStatusCode() >= 400) {
            return $response;
        }

        $idCliente = $args['idCliente'];
        $idScheda = $args['idScheda'];

        //verifico che il parametro sia un numerico
        if (!is_numeric($idScheda)) {
            return Web::error400('idScheda', $response);
        }

        $scheda = SchedeQuery::create()
            ->filterByIdCliente($idCliente)
            ->filterByIdScheda($idScheda)
            ->findOne();

        // se non trovo corrispondenze do un 404
        if ($scheda === null) {
            return $response->withStatus(404);
        }

        $result = swagger\Scheda::LoadScheda($scheda);

        $myResponse = Web::setupResponseHeaders($response);
        $myResponse->getBody()->write(json_encode($result));

        return $myResponse;
    } catch (Exception $e) {
        return Web::error500($e, $response);
    }
});

/**
 * PUT clientiIdClienteSchedeIdSchedaPut
 * Summary:
 * Notes: Aggiorna la &#x60;Scheda&#x60; cliente. Gli id forniti sulla rotta dovrascrivono quelli eventualmente forniti nel body
 * Output-Formats: [application/json]
 */
$app->PUT('/clienti/{idCliente}/schede/{idScheda}',
    function(ServerRequestInterface $request, ResponseInterface $response, $args) {
    try {
        $response = VerificoClienteById($response, $args);
        if ($response->getStatusCode() >= 400) {
            return $response;
        }

        //verifico che il parametro sia un numerico
        if (!is_numeric($args['idScheda'])) {
            return Web::error400('idScheda', $response);
        }

        $schede = SchedeQuery::create()
            ->filterByIdCliente($args['idCliente'])
            ->filterByIdScheda($args['idScheda'])
            ->find()
            ->toArray();
        // se non trovo corrispondenze do un 404
        if ((count($schede) == 0)) {
            return $response->withStatus(404);
        }

        // prendo i dati dal body e li pulisco di eventuali caratteri speciali
        $body = $request->getParsedBody();
        $codice = web::PulisciStr($body['codice']);
        if ($codice == "") {
            return Web::error400('codice', $response);
        }

        $importo = $body['importo'];
        if (!is_numeric($importo)) {
            return Web::error400('importo', $response);
        }

        $dataRilascio = $body['dataRilascio'];
        if (!Web::isData($dataRilascio)) {
            return Web::error400('dataRilascio', $response);
        }

        //inserisco i dati
        $scheda = SchedeQuery::create()->findOneByIdScheda($args['idScheda']);
        $scheda->setCodiceScheda($codice);
        $scheda->setImportoScheda($importo);
        $scheda->setDataRilascio($dataRilascio);
        $scheda->save();

        $myResponse = Web::setupResponseHeaders($response);
        $myResponse->write(json_encode($scheda->toArray()));
        return $myResponse;
    } catch (Exception $e) {
        return Web::error500($e, $response);
    }
});


/**
 * DELETE clientiIdClienteSchedeIdSchedaDelete
 * Summary:
 * Notes: Cancella la &#x60;Scheda&#x60; cliente
 * Output-Formats: [application/json]
 */
$app->DELETE('/clienti/{idCliente}/schede/{idScheda}',
    function(ServerRequestInterface $request, ResponseInterface $response, $args) {
    try {
        $response = VerificoClienteById($response, $args);
        if ($response->getStatusCode() >= 400) {
            return $response;
        }
        //verifico che il parametro sia un numerico
        if (!is_numeric($args['idScheda'])) {
            return Web::error400('idScheda', $response);
        }

        $schede = SchedeQuery::create()
            ->filterByIdCliente($args['idCliente'])
            ->filterByIdScheda($args['idScheda'])
            ->find()
            ->toArray();

        // se non trovo corrispondenze do un 404
        if ((count($schede) == 0)) {
            return $response->withStatus(404);
        }

        SchedeQuery::create()
            ->filterByIdCliente($args['idCliente'])
            ->filterByIdScheda($args['idScheda'])
            ->delete();

        $myResponse = Web::setupResponseHeaders($response);
        $myResponse->getBody()->write(json_encode($schede));

        return $myResponse;
    } catch (Exception $e) {
        return Web::error500($e, $response);
    }
});


/**
 * OPTIONS clientiIdClienteSchedeIdSchedaOptions
 * Summary:
 * Notes:
 * Output-Formats: [application/json]
 */
$app->OPTIONS('/clienti/{idCliente}/schede/{idScheda}',
    function(ServerRequestInterface $request, ResponseInterface $response) {
    $myResponse = Web::setupResponseHeaders($response);
    return $myResponse;
});