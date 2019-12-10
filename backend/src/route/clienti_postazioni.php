<?php

use \Psr\Http\Message\ServerRequestInterface;
use \Psr\Http\Message\ResponseInterface;
use \Propel\Runtime\ActiveQuery\Criteria;

require_once 'src/swagger/AssegnamentoPostazione.php';

/**
 * GET clientiIdClientePostazioniGet
 * Summary:
 * Notes: Restituisce la lista delle postazioni assegnate al cliente
 * Output-Formats: [application/json]
 */
$app->GET('/clienti/{idCliente}/postazioni',
    function(ServerRequestInterface $request, ResponseInterface $response, $args) {

    try {
        $response = VerificoClienteById($response, $args);
        if ($response->getStatusCode() >= 400) {
            return $response;
        }

        $query = AssegnamentiPostazioneQuery::create()
            ->filterByIdCliente($args['idCliente']);

        $queryParams = $request->getQueryParams();

        if (web::assertParam($queryParams, 'dataInizio')) {
            $dataInizio = Web::toDateTime($queryParams['dataInizio'], 'dataInizio');
            $dataInizio->setTime(0, 0, 0);
            $query = $query->filterByDataFine($dataInizio, Criteria::GREATER_EQUAL);
        }

        if (web::assertParam($queryParams, 'dataFine')) {
            $dataFine = Web::toDateTime($queryParams['dataFine'], 'dataFine');
            $dataFine->setTime(0, 0, 0);
            $query = $query->filterByDataInizio($dataFine, Criteria::LESS_EQUAL);
        }

        $assegnamenti = $query->find();
        $results = [];

        foreach ($assegnamenti as $assegnamento) {
            $assegnamento->getDisponibilitaPostaziones();

            foreach ($assegnamento->getDisponibilitaPostaziones() as $disponibilita) {
                $disponibilita->getSubaffittiPostaziones();
            }

            $results[] = $assegnamento->toSwagger(AssegnamentiPostazione::WITH_POSTAZIONE);
        }

        return Web::responseOk($response, json_encode($results));
    } catch (Exception $e) {
        return Web::error500($e, $response);
    }
});

/**
 * OPTIONS clientiIdClientePostazioniOptions
 * Summary:
 * Notes:
 * Output-Formats: [application/json]
 */
$app->OPTIONS('/clienti/{idCliente}/postazioni',
    function(ServerRequestInterface $request, ResponseInterface $response) {
    $myResponse = Web::setupResponseHeaders($response);
    return $myResponse;
});

//*************************************************************'/clienti/{idCliente}/postazioni/{idPostazione}'

/**
 * GET clientiIdClientePostazioniIdPostazioneGet
 * Summary:
 * Notes: Anagrafica della &#x60;Postazione&#x60; associata al cliente
 * Output-Formats: [application/json]
 */
$app->GET('/clienti/{idCliente}/postazioni/{idPostazione}',
    function(ServerRequestInterface $request, ResponseInterface $response, $args) {

    try {
        $response = VerificoClienteById($response, $args);
        if ($response->getStatusCode() >= 400) {
            return $response;
        }

        $query = AssegnamentiPostazioneQuery::create()
            ->filterByIdCliente($args['idCliente'])
            ->filterByIdPostazione($args['idPostazione']);

        $queryParams = $request->getQueryParams();
        if (web::assertParam($queryParams, 'dataInizio')) {
            $dataInizio = $queryParams['dataInizio'];

            if (!Web::isData($dataInizio)) {
                return Web::error400('DataInizio', $response);
            }

            $query = $query
                ->filterByDataInizio($dataInizio, Criteria::GREATER_EQUAL);
        }

        if (web::assertParam($queryParams, 'dataFine')) {
            $dataFine = $queryParams['dataFine'];

            if (!Web::isData($dataFine)) {
                return Web::error400('dataFine', $response);
            }

            $query = $query
                ->filterByDataFine($dataFine, Criteria::LESS_EQUAL);
        }

        $assegnamenti = $query->find();
        $results = [];

        foreach ($assegnamenti as $assegnamento) {
            $assegnamento->getDisponibilitaPostaziones();

            foreach ($assegnamento->getDisponibilitaPostaziones() as $disponibilita) {
                $disponibilita->getSubaffittiPostaziones();
            }

            $results[] = $assegnamento->toSwagger();
        }

        $myResponse = Web::setupResponseHeaders($response);
        $myResponse->getBody()->write(json_encode($results));

        return $myResponse;
    } catch (Exception $e) {
        return Web::error500($e, $response);
    }
});

/**
 * POST clientiIdClientePostazioniPost
 * Summary:
 * Notes: Assegna una &#x60;Postazione&#x60; al cliente
 * Output-Formats: [application/json]
 */
$app->POST('/clienti/{idCliente}/postazioni/{idPostazione}',
    function(ServerRequestInterface $request, ResponseInterface $response, $args) {
    try {
        $response = VerificoClienteById($response, $args);
        if ($response->getStatusCode() >= 400) {
            return $response;
        }

        $response = VerificoPostazioneById($response, $args);
        if ($response->getStatusCode() >= 400) {
            return $response;
        }

        // prendo i dati dal body e li pulisco di eventuali caratteri speciali
        $body = $request->getParsedBody();

        $id_abbonamento = $body['idAbbonamento'];
        if (!is_numeric($id_abbonamento)) {
            return Web::error400('idAbbonamento', $response);
        }

        if (array_key_exists('note', $body)) {
            $note = web::PulisciStr($body['note']);
        }

        // prendo i dati dal body e li pulisco di eventuali caratteri speciali

        $dataInizio = $body['dataInizio'];
        if (!Web::isData($dataInizio)) {
            return Web::error400('DataInizio', $response);
        }
        $dataFine = $body['dataFine'];
        if (!Web::isData($dataFine)) {
            return Web::error400('DataFine', $response);
        }

        //inserisco i dati
        $assegnamenti = new AssegnamentiPostazione();

        $assegnamenti->setIdAbbonamento($id_abbonamento);
        $assegnamenti->setIdCliente($args['idCliente']);
        $assegnamenti->setDataInizio($dataInizio);
        $assegnamenti->setIdPostazione($args['idPostazione']);
        $assegnamenti->setDataFine($dataFine);
        $assegnamenti->save();
        $assegnamenti->getIdAssegnamentoPostazione();

        $myResponse = Web::setupResponseHeaders($response);
        $myResponse->write(json_encode($assegnamenti->toArray()));

        return $myResponse;
    } catch (Exception $e) {
        return Web::error500($e, $response);
    }
});

/**
 * PUT clientiIdClientePostazioniIdPostazionePut
 * Summary:
 * Notes: Aggiorna l&#39;anagrafica &#x60;Postazione&#x60;. Gli id forniti sulla rotta dovrascrivono quelli eventualmente forniti nel body
 * Output-Formats: [application/json]
 */
$app->PUT('/clienti/{idCliente}/postazioni/{idPostazione}',
    function(ServerRequestInterface $request, ResponseInterface $response, $args) {
    try {
        $response = VerificoClienteById($response, $args);
        if ($response->getStatusCode() >= 400) {
            return $response;
        }

        $response = VerificoPostazioneById($response, $args);
        if ($response->getStatusCode() >= 400) {
            return $response;
        }

        // prendo i dati dal body e li pulisco di eventuali caratteri speciali
        $body = $request->getParsedBody();

        $id_abbonamento = $body['idAbbonamento'];
        if (!is_numeric($id_abbonamento)) {
            return Web::error400('idAbbonamento', $response);
        }

        if (array_key_exists('note', $body)) {
            $note = web::PulisciStr($body['note']);
        }

        // prendo i dati dal body e li pulisco di eventuali caratteri speciali

        $dataInizio = $body['dataInizio'];
        if (!Web::isData($dataInizio)) {
            return Web::error400('DataInizio', $response);
        }

        $dataFine = $body['dataFine'];
        if (!Web::isData($dataFine)) {
            return Web::error400('DataFine', $response);
        }

        //inserisco i dati
        $assegnamenti = AssegnamentiPostazioneQuery::create()
            ->filterByIdCliente($args['idCliente'])
            ->filterByIdPostazione($args['idPostazione'])
            ->findOneByIdPostazione($args['idPostazione']);

        $assegnamenti->setIdAbbonamento($id_abbonamento);
        $assegnamenti->setDataInizio($dataInizio);
        $assegnamenti->setDataFine($dataFine);
        $assegnamenti->save();
        $assegnamenti->getIdAssegnamentoPostazione();

        $myResponse = Web::setupResponseHeaders($response);
        $myResponse->write(json_encode($assegnamenti->toArray()));

        return $myResponse;
    } catch (Exception $e) {
        return Web::error500($e, $response);
    }
});

/**
 * DELETE clientiIdClientePostazioniIdPostazionePut
 * Summary:
 * Notes: Cancella l&#39;assegnamento la postazione.
 * Output-Formats: [application/json]
 */
$app->DELETE('/clienti/{idCliente}/postazioni/{idPostazione}',
    function(ServerRequestInterface $request, ResponseInterface $response, $args) {
    $con = web::getConnection();
// TODO: PENSARE SE VA LASCITA
    try {

        $response = VerificoPostazioneById($response, $args);
        if ($response->getStatusCode() >= 400) {
            return $response;
        }

        // Verifico id assegnamento
        $response = VerificoClienteById($response, $args);
        if ($response->getStatusCode() >= 400) {
            return $response;
        }

        // prendo i dati dal body e li pulisco di eventuali caratteri speciali
        $body = $request->getParsedBody();

        $id_assegnamento = $body['idAssegnamento'];   //// *****   TO DO***** PENSARE SE VA BENE SE VA BENE MODIFICARE API
        if (!is_numeric($id_assegnamento)) {
            return Web::error400('idAssegnamento');
        }

        // prendo gli le pk di disponibilita postazione
        $disponibilita = DisponibilitaPostazioneQuery::getPKFromIdAssegnamento($id_assegnamento);

        // prendo gli le pk di subaffitti_postazione
        $subaffitti = SubaffittiPostazioneQuery::getPKFromIdDisponibilita($disponibilita);

        $assegnamenti = AssegnamentiPostazioneQuery::create()
            ->filterByIdAssegnamentoPostazione($id_assegnamento)
            ->filterByIdPostazione($args['idPostazione'])
            ->find();
        //$assegnamenti = AssegnamentiPostazioneQuery::joinDisponibilita_Subaffitto($assegnamenti);

        $results = [];

        foreach ($assegnamenti as $assegnamento) {
            $assegnamento->getDisponibilitaPostaziones();

            foreach ($assegnamento->getDisponibilitaPostaziones() as $disponibilita) {
                $disponibilita->getSubaffittiPostaziones();
            }

            $results[] = $assegnamento->toSwagger();
        }

        $con->beginTransaction();

        //cancello i record anche nelle tabelle collegate
        SubaffittiPostazioneQuery::deleteSubaffittiById($subaffitti);
        DisponibilitaPostazioneQuery::deleteDisponibilitaByIdAssegnamento($id_assegnamento);
        AssegnamentiPostazioneQuery::deleteAssegnamentiById($id_assegnamento);

        $con->commit();

        $myResponse = Web::setupResponseHeaders($response);
        $myResponse->getBody()->write($assegnamenti->toArray());
        return $myResponse;
    } catch (Exception $e) {
        $con->rollBack();
        return Web::error500($e, $response);
    }
});

/**
 * OPTIONS clientiIdClientePostazioniIdPostazioneOptions
 * Summary:
 * Notes:
 * Output-Formats: [application/json]
 */
$app->OPTIONS('/clienti/{idCliente}/postazioni/{idPostazione}',
    function(ServerRequestInterface $request, ResponseInterface $response) {
    $myResponse = Web::setupResponseHeaders($response);
    return $myResponse;
});
