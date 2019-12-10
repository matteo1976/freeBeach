<?php

use \Psr\Http\Message\ServerRequestInterface;
use \Psr\Http\Message\ResponseInterface;
use \Propel\Runtime\ActiveQuery\Criteria;

require_once 'src/swagger/AssegnamentoPostazione.php';

/**
 * Restituisce gli assegnamenti della postazione
 * Output-Formats: [application/json]
 */
$app->GET('/postazioni/{idPostazione}/assegnamenti',
    function(ServerRequestInterface $request, ResponseInterface $response, $args) {

    try {
        $response = VerificoPostazioneById($response, $args);
        if ($response->getStatusCode() >= 400) {
            return $response;
        }

        $query = AssegnamentiPostazioneQuery::create()
            ->filterByIdPostazione($args['idPostazione']);

        $queryParams = $request->getQueryParams();

        if (web::assertParam($queryParams, 'dataInizio')) {
            $dataInizio = Web::toDateTime($queryParams['dataInizio'], 'dataInizio');
            $dataInizio->setTime(0, 0, 0);
            $query = $query->filterByDataFine($dataInizio, Criteria::GREATER_EQUAL);
        }

        if (web::assertParam($queryParams, 'dataFine')) {
            $dataFine = Web::toDateTime($queryParams['dataFine'], 'dataFine');
            $dataFine->setTime(23, 59, 59);
            $query = $query->filterByDataInizio($dataFine, Criteria::LESS_EQUAL);
        }

        $assegnamenti = $query->find();
        $results = [];

        foreach ($assegnamenti as $assegnamento) {
            $results[] = $assegnamento->toSwagger(AssegnamentiPostazione::WITH_CLIENTE);
        }

        return Web::responseOk($response, json_encode($results));
    } catch (BadRequestException $bre) {
        return Web::error400($bre->fieldName, $response);
    } catch (Exception $e) {
        return Web::error500($e, $response);
    }
});

/**
 * Assegna la postazione
 * Output-Formats: [application/json]
 */
$app->POST('/postazioni/{idPostazione}/assegnamenti',
    function(ServerRequestInterface $request, ResponseInterface $response, $args) {

    try {
        $body = $request->getParsedBody();

        $response = VerificoPostazioneById($response, $args);
        if ($response->getStatusCode() >= 400) {
            return $response;
        }
        $idPostazione = $args['idPostazione'];

        if (!array_key_exists('idCliente', $body)) {
            return Web::error400('idCliente', $response);
        }
        $id_cliente = $body['idCliente'];

        if (!is_numeric($id_cliente)) {
            return Web::error400('idCliente', $response);
        }

        if (!array_key_exists('idAbbonamento', $body)) {
            return Web::error400('idAbbonamento', $response);
        }
        $id_abbonamento = $body['idAbbonamento'];

        if (!is_numeric($id_abbonamento)) {
            return Web::error400('idAbbonamento', $response);
        }

        if (web::assertParam($body, 'dataInizio')) {
            $dataInizio = Web::toDateTime($body['dataInizio'], 'dataInizio');
            $dataInizio->setTime(0, 0, 0);
        }

        if (web::assertParam($body, 'dataFine')) {
            $dataFine = Web::toDateTime($body['dataFine'], 'dataFine');
            $dataFine->setTime(23, 59, 59);
        }

        if (array_key_exists('note', $body)) {
            $note = web::PulisciStr($body['note']);
        }

        if (array_key_exists('autorizzati', $body)) {
            $autorizzati = web::PulisciStr($body['autorizzati']);
        }

        $assegnamenti_free = AssegnamentiPostazioneQuery::create()
            ->filterByIdPostazione($idPostazione)
            ->filterByDataFine($dataInizio, Criteria::GREATER_EQUAL)
            ->_and()
            ->filterByDataInizio($dataFine, Criteria::LESS_EQUAL)
            ->find()
            ->toArray();

        if (count($assegnamenti_free) !== 0) {
            return Web::error400('Periodo non disponibile', $response, $assegnamenti_free);
        }

        //inserisco i dati
        $assegnamenti = new AssegnamentiPostazione();

        $assegnamenti->setIdAbbonamento($id_abbonamento);
        $assegnamenti->setIdCliente($id_cliente);
        $assegnamenti->setDataInizio($dataInizio);
        $assegnamenti->setIdPostazione($idPostazione);
        $assegnamenti->setDataFine($dataFine);
        $assegnamenti->setNote($note);
        $assegnamenti->setAutorizzati($autorizzati);
        $assegnamenti->save();
        $assegnamenti->getIdAssegnamentoPostazione();

        return Web::responseOk($response, json_encode([
            'idAssegnamento' => $assegnamenti->getIdAssegnamentoPostazione()
        ]));
    } catch (BadRequestException $bre) {
        return Web::error400($bre->fieldName, $response);
    } catch (Exception $e) {
        return Web::error500($e, $response);
    }
});

/**
 * OPTIONS postazioniIdPostazioneAssegnamentiOptions
 * Summary:
 * Notes:
 * Output-Formats: [application/json]
 */
$app->OPTIONS('/postazioni/{idPostazione}/assegnamenti',
    function(ServerRequestInterface $request, ResponseInterface $response) {
    return Web::setupResponseHeaders($response);
});

/**
 * GET postazioniIdPostazioneAssegnamentiIdAssegnamentoGet
 * Summary:
 * Notes: Restituisce l&#39;assegnamento della postazione
 * Output-Formats: [application/json]
 */
$app->GET('/postazioni/{idPostazione}/assegnamenti/{idAssegnamento}',
    function(ServerRequestInterface $request, ResponseInterface $response, $args) {
    try {
        //Verifico IdPostzione

        $response = VerificoPostazioneById($response, $args);
        if ($response->getStatusCode() >= 400) {
            return $response;
        }

        $idPostazione = $args['idPostazione'];

        // Verifico id assegnamento
        $response = VerificoAssegnamentoById($response, $args);
        if ($response->getStatusCode() >= 400) {
            return $response;
        }

        $idAssegnamento = $args['idAssegnamento'];

        $assegnamenti = AssegnamentiPostazioneQuery::create()
            ->filterByIdAssegnamentoPostazione($idAssegnamento)
            ->filterByIdPostazione($idPostazione)
            ->find();

        $results = [];

        foreach ($assegnamenti as $assegno) {
            $results[] = $assegno->toSwagger(true);
        }

        return Web::responseOk($response, json_encode($results));
    } catch (Exception $e) {
        return Web::error500($e, $response);
    }
});

/**
 * Aggiorna l'assegnamento
 * Output-Formats: [application/json]
 */
$app->PUT('/postazioni/{idPostazione}/assegnamenti/{idAssegnamento}',
    function(ServerRequestInterface $request, ResponseInterface $response, $args) {

    try {
        $body = $request->getParsedBody();

        $response = VerificoPostazioneById($response, $args);
        if ($response->getStatusCode() >= 400) {
            return $response;
        }

        $idPostazione = $args['idPostazione'];

        // Verifico id assegnamento
        $response = VerificoAssegnamentoById($response, $args);
        if ($response->getStatusCode() >= 400) {
            return $response;
        }

        $idAssegnamento = $args['idAssegnamento'];

        if (!array_key_exists('idCliente', $body)) {
            return Web::error400('idCliente', $response);
        }
        $id_cliente = $body['idCliente'];
        if (!is_numeric($id_cliente)) {
            return Web::error400('idCliente', $response);
        }
        if (!array_key_exists('idAbbonamento', $body)) {
            return Web::error400('idAbbonamento', $response);
        }
        $id_abbonamento = $body['idAbbonamento'];
        if (!is_numeric($id_abbonamento)) {
            return Web::error400('idAbbonamento', $response);
        }

        if (web::assertParam($body, 'dataInizio')) {
            $dataInizio = Web::toDateTime($body['dataInizio'], 'dataInizio');
            $dataInizio->setTime(0, 0, 0);
        }

        if (web::assertParam($body, 'dataFine')) {
            $dataFine = Web::toDateTime($body['dataFine'], 'dataFine');
            $dataFine->setTime(23, 59, 59);
        }

        if (array_key_exists('autorizzati', $body)) {
            $autorizzati = web::PulisciStr($body['autorizzati']);
        } else {
            $autorizzati = null;
        }

        if (array_key_exists('note', $body)) {
            $note = web::PulisciStr($body['note']);
        } else {
            $note = null;
        }

        $assegnamenti_free = AssegnamentiPostazioneQuery::create()
            ->filterByIdPostazione($idPostazione)
            ->filterByDataFine($dataInizio, Criteria::GREATER_EQUAL)
            ->_and()
            ->filterByDataInizio($dataFine, Criteria::LESS_EQUAL)
            ->_and()
            ->filterByIdAssegnamentoPostazione($idAssegnamento, Criteria::NOT_EQUAL)
            ->find()
            ->toArray();

        if (count($assegnamenti_free) !== 0) {
            return Web::error400('Periodo non disponibile', $response, $assegnamenti_free);
        }

        //inserisco i dati
        $assegnamento = AssegnamentiPostazioneQuery::create()->findPk($idAssegnamento);

        $assegnamento->setIdAbbonamento($id_abbonamento);
        $assegnamento->setIdCliente($id_cliente);
        $assegnamento->setDataInizio($dataInizio);
        $assegnamento->setIdPostazione($idPostazione);
        $assegnamento->setDataFine($dataFine);
        $assegnamento->setAutorizzati($autorizzati);
        $assegnamento->setNote($note);
        $assegnamento->save();

        return Web::responseOk($response, null);
    } catch (BadRequestException $bre) {
        return Web::error400($bre->fieldName, $response);
    } catch (Exception $e) {
        return Web::error500($e, $response);
    }
});

/**
 * DELETE postazioniIdPostazioneAssegnamentiIdAssegnamentoDelete
 * Summary:
 * Notes: Cancella l&#39;assegnamento la postazione. ***TODO*** Come gestiamo eventuali dati collegati alla postazione e già registrati?
 * Output-Formats: [application/json]
 */
$app->DELETE('/postazioni/{idPostazione}/assegnamenti/{idAssegnamento}',
    function(ServerRequestInterface $request, ResponseInterface $response, $args) {
    $con = web::getConnection();

    try {
        $response = VerificoPostazioneById($response, $args);
        if ($response->getStatusCode() >= 400) {
            return $response;
        }

        // Verifico id assegnamento
        $response = VerificoAssegnamentoById($response, $args);
        if ($response->getStatusCode() >= 400) {
            return $response;
        }
        $idAssegnamento = $args['idAssegnamento'];

        // prendo gli le pk di disponibilita postazione
        $disponibilita = DisponibilitaPostazioneQuery::
            getPKFromIdAssegnamento($idAssegnamento);

        // prendo gli le pk di subaffitti_postazione
        $subaffitti = SubaffittiPostazioneQuery::
            getPKFromIdDisponibilita($disponibilita);

        $assegnamento = AssegnamentiPostazioneQuery::create()
            ->findOneByIdAssegnamentoPostazione($idAssegnamento);

        $result = $assegnamento->toSwagger(true);

        //cancello i record anche nelle tabelle collegate
        $con->beginTransaction();

        SubaffittiPostazioneQuery::deleteSubaffittiById($subaffitti);
        DisponibilitaPostazioneQuery::
        deleteDisponibilitaByIdAssegnamento($idAssegnamento);
        AssegnamentiPostazioneQuery::
        deleteAssegnamentiById($idAssegnamento);

        $con->commit();

        return Web::responseOk($response, json_encode($result));
    } catch (Exception $e) {
        $con->rollBack();
        return Web::error500($e, $response);
    }
});

/**
 * OPTIONS postazioniIdPostazioneAssegnamentiIdAssegnamentoOptions
 * Summary:
 * Notes:
 * Output-Formats: [application/json]
 */
$app->OPTIONS('/postazioni/{idPostazione}/assegnamenti/{idAssegnamento}',
    function(ServerRequestInterface $request, ResponseInterface $response) {
    return Web::setupResponseHeaders($response);
});
