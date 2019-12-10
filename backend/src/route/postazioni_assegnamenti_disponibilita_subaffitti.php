<?php

use \Psr\Http\Message\ServerRequestInterface;
use \Psr\Http\Message\ResponseInterface;
use \Propel\Runtime\ActiveQuery\Criteria;

/* * *
 * GET postazioniIdPostazioneAssegnamentiIdAssegnamentoDisponibilitaIdDisponibilitaSubaffittiGet
 * Summary:
 * Notes: Restituisce i subaffitti della postazione
 * Output-Formats: [application/json]
 */

$app->GET('/postazioni/{idPostazione}/assegnamenti/{idAssegnamento}/disponibilita/{idDisponibilita}/subaffitti',
    function(ServerRequestInterface $request, ResponseInterface $response, $args) {
    try {
        $response = VerificoPostazioneById($response, $args);
        if ($response->getStatusCode() >= 400) {
            return $response;
        }

        $response = VerificoAssegnamentoById($response, $args);
        if ($response->getStatusCode() >= 400) {
            return $response;
        }
        $response = VerificoDisponibilitaById($response, $args);
        if ($response->getStatusCode() >= 400) {
            return $response;
        }

        //NB: cosi facendo tengo valida tutta la rotta senza caricare tutti i record da postazioni
        $subaffitto = SubaffittiPostazioneQuery::create()
            ->filterByIdDisponibilitaPostazioni($args['idDisponibilita'])
            ->useDisponibilitaPostazioneQuery()
                ->useAssegnamentiPostazioneQuery()
                    ->filterByIdAssegnamentoPostazione($args['idAssegnamento'])
                    ->usePostazioniQuery()
                        ->filterByIdPostazione($args['idPostazione'])
                    ->endUse()
                ->endUse()
            ->endUse()
            ->find();

        $results=[];

        foreach ($subaffitto as $subAff){
            $results[]= $subAff->toSwagger();
        }

        $myResponse = Web::setupResponseHeaders($response);
        $myResponse->getBody()->write(json_encode($results));

        return $myResponse;
    } catch (Exception $e) {
        return Web::error500($e, $response);
    }
});

/**
 * POST postazioniIdPostazioneAssegnamentiIdAssegnamentoDisponibilitaIdDisponibilitaSubaffittiPost
 * Summary:
 * Notes: Aggiunge un subaffitto alla postazione
 * Output-Formats: [application/json]
 */
$app->POST('/postazioni/{idPostazione}/assegnamenti/{idAssegnamento}/disponibilita/{idDisponibilita}/subaffitti',
    function(ServerRequestInterface $request, ResponseInterface $response, $args) {
    try {
        $body = $request->getParsedBody();

        $response = VerificoPostazioneById($response, $args);
        if ($response->getStatusCode() >= 400) {
            return $response;
        }

        $response = VerificoAssegnamentoById($response, $args);
        if ($response->getStatusCode() >= 400) {
            return $response;
        }

        $response = VerificoDisponibilitaById($response, $args);
        if ($response->getStatusCode() >= 400) {
            return $response;
        }

        $dataInizio = $body['dataInizio'];
        if (!Web::isData($dataInizio)) {
            //esco e do errore
            return Web::error400('DataInizio', $response);
        }

        $dataFine = $body['dataFine'];
        if (!Web::isData($dataFine)) {
            return Web::error400('DataFine', $response);
        }

        //inserisco i dati
        $subaffitto = new SubaffittiPostazione();
        $subaffitto->setIdDisponibilitaPostazioni($args['idDisponibilita']);
        $subaffitto->setDataInizio($dataInizio);
        $subaffitto->setDataFine($dataFine);
        $subaffitto->save();
        $subaffitto->getIdSubaffittoPostazione();

        $myResponse = Web::setupResponseHeaders($response);
        $myResponse->write(json_encode($subaffitto->toArray()));

        return $myResponse;
    } catch (Exception $e) {
        return Web::error500($e, $response);
    }
});

/**
 * OPTIONS postazioniIdPostazioneAssegnamentiIdAssegnamentoDisponibilitaIdDisponibilitaSubaffittiOptions
 * Summary:
 * Notes:
 * Output-Formats: [application/json]
 */
$app->OPTIONS('/postazioni/{idPostazione}/assegnamenti/{idAssegnamento}/disponibilita/{idDisponibilita}/subaffitti',
    function(ServerRequestInterface $request, ResponseInterface $response) {
        $myResponse = Web::setupResponseHeaders($response);
        return $myResponse;
});

//*************/postazioni/{idPostazione}/assegnamenti/{idAssegnamento}/disponibilita/{idDisponibilita}/subaffitti/{idSubaffitto}',

/**
 * GET postazioniIdPostazioneAssegnamentiIdAssegnamentoDisponibilitaIdDisponibilitaSubaffittiIdSubaffittoGet
 * Summary:
 * Notes: Restituisce il subaffitto della postazione
 * Output-Formats: [application/json]
 */
$app->GET('/postazioni/{idPostazione}/assegnamenti/{idAssegnamento}/disponibilita/{idDisponibilita}/subaffitti/{idSubaffitto}',
    function(ServerRequestInterface $request, ResponseInterface $response, $args) {
    try {
        //Verifico IdPostzione
        //verifico che il parametro sia un numerico

        $response = VerificoPostazioneById($response, $args);
        if ($response->getStatusCode() >= 400) {
            return $response;
        }

        $response = VerificoAssegnamentoById($response, $args);
        if ($response->getStatusCode() >= 400) {
            return $response;
        }
        $response = VerificoDisponibilitaById($response, $args);
        if ($response->getStatusCode() >= 400) {
            return $response;
        }
        if (!is_numeric($args['idSubaffitto'])) {
            return Web::error400('idSubaffitto', $response);
        }

        $subaffitto = SubaffittiPostazioneQuery::create()
            ->useDisponibilitaPostazioneQuery()
            ->useAssegnamentiPostazioneQuery()
            ->usePostazioniQuery()
            ->filterByIdPostazione($args['idPostazione'])
            ->endUse()
            ->filterByIdAssegnamentoPostazione($args['idAssegnamento'])
            ->endUse()
            ->filterByIdDisponibilitaPostazione($args['idDisponibilita'])
            ->endUse()
            ->filterByIdSubaffittoPostazione($args['idSubaffitto'])
            ->find()
            ->toArray();
        if (count($subaffitto) == 0) {
            return $response->withStatus(404);
        }

        $results= swagger\SubaffittoPostazione::LoadSubaffitti($subaffitto);

        $myResponse = Web::setupResponseHeaders($response);
        $myResponse->getBody()->write(json_encode($results));

        return $myResponse;
    } catch (Exception $e) {
        return Web::error500($e, $response);
    }
});

/**
 * PUT postazioniIdPostazioneAssegnamentiIdAssegnamentoDisponibilitaIdDisponibilitaSubaffittiIdSubaffittoPut
 * Summary:
 * Notes: Aggiorna il subaffitto della postazione
 * Output-Formats: [application/json]
 */
$app->PUT('/postazioni/{idPostazione}/assegnamenti/{idAssegnamento}/disponibilita/{idDisponibilita}/subaffitti/{idSubaffitto}',
    function(ServerRequestInterface $request, ResponseInterface $response, $args) {
    try {
        $body = $request->getParsedBody();

        $response = VerificoPostazioneById($response, $args);
        if ($response->getStatusCode() >= 400) {
            return $response;
        }

        $response = VerificoAssegnamentoById($response, $args);
        if ($response->getStatusCode() >= 400) {
            return $response;
        }

        $response = VerificoDisponibilitaById($response, $args);
        if ($response->getStatusCode() >= 400) {
            return $response;
        }
        if (!is_numeric($args['idSubaffitto'])) {
            return Web::error400('idSubaffitto', $response);
        }

        $dataInizio = $body['dataInizio'];
        if (!Web::isData($dataInizio)) {
            return Web::error400('DataInizio', $response);
        }

        $dataFine = $body['dataFine'];
        if (!Web::isData($dataFine)) {
            return Web::error400('DataFine', $response);
        }

        //inserisco i dati
        $subaffitto = SubaffittiPostazioneQuery::create()->findOneByIdSubaffittoPostazione($args['idSubaffitto']);
        $subaffitto->setIdDisponibilitaPostazioni($args['idDisponibilita']);
        $subaffitto->setDataInizio($dataInizio);
        $subaffitto->setDataFine($dataFine);
        $subaffitto->save();
        $subaffitto->getIdSubaffittoPostazione();

        $myResponse = Web::setupResponseHeaders($response);
        $myResponse->write(json_encode($subaffitto->toArray()));

        return $myResponse;
    } catch (Exception $e) {
        return Web::error500($e, $response);
    }
});

/**
 * DELETE postazioniIdPostazioneAssegnamentiIdAssegnamentoDisponibilitaIdDisponibilitaSubaffittiIdSubaffittoDelete
 * Summary:
 * Notes: Cancella il subaffitto della postazione
 * Output-Formats: [application/json]
 */
$app->DELETE('/postazioni/{idPostazione}/assegnamenti/{idAssegnamento}/disponibilita/{idDisponibilita}/subaffitti/{idSubaffitto}',
    function(ServerRequestInterface $request, ResponseInterface $response, $args) {
    try {
        $response = VerificoPostazioneById($response, $args);
        if ($response->getStatusCode() >= 400) {
            return $response;
        }

        $response = VerificoAssegnamentoById($response, $args);
        if ($response->getStatusCode() >= 400) {
            return $response;
        }
        $response = VerificoDisponibilitaById($response, $args);
        if ($response->getStatusCode() >= 400) {
            return $response;
        }

        if (!is_numeric($args['idSubaffitto'])) {
            return Web::error400('idSubaffitto', $response);
        }

        $subaffitto = SubaffittiPostazioneQuery::create()
            ->useDisponibilitaPostazioneQuery()
            ->useAssegnamentiPostazioneQuery()
            ->usePostazioniQuery()
            ->filterByIdPostazione($args['idPostazione'])
            ->endUse()
            ->filterByIdAssegnamentoPostazione($args['idAssegnamento'])
            ->endUse()
            ->filterByIdDisponibilitaPostazione($args['idDisponibilita'])
            ->endUse()
            ->filterByIdSubaffittoPostazione($args['idSubaffitto'])
            ->find();

        if (count($subaffitto) == 0) {
            return $response->withStatus(404);
        }

        $results= swagger\SubaffittoPostazione::LoadSubaffitti($subaffitto);

        SubaffittiPostazioneQuery::deleteSubaffittiById($args['idSubaffitto']);

        $myResponse = Web::setupResponseHeaders($response);
        $myResponse->getBody()->write(json_encode($results));

        return $myResponse;
    } catch (Exception $e) {
        return Web::error500($e, $response);
    }
});

/**
 * OPTIONS postazioniIdPostazioneAssegnamentiIdAssegnamentoDisponibilitaIdDisponibilitaSubaffittiIdSubaffittoOptions
 * Summary:
 * Notes:
 * Output-Formats: [application/json]
 */
$app->OPTIONS('/postazioni/{idPostazione}/assegnamenti/{idAssegnamento}/disponibilita/{idDisponibilita}/subaffitti/{idSubaffitto}',
    function(ServerRequestInterface $request, ResponseInterface $response) {
        $myResponse = Web::setupResponseHeaders($response);
        return $myResponse;
});
