<?php

use \Psr\Http\Message\ServerRequestInterface;
use \Psr\Http\Message\ResponseInterface;

/**
 * GET postazioniIdPostazioneAssegnamentiIdAssegnamentoDisponibilitaGet
 * Summary:
 * Notes: Restituisce le disponibilità della postazione
 * Output-Formats: [application/json]
 */
$app->GET('/postazioni/{idPostazione}/assegnamenti/{idAssegnamento}/disponibilita',
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

        $disponibilita = DisponibilitaPostazioneQuery::create()
            ->useAssegnamentiPostazioneQuery()
            ->usePostazioniQuery()
            ->filterByIdPostazione($args['idPostazione'])
            ->endUse()
            ->endUse()
            ->filterByIdAssegnamentoPostazione($args['idAssegnamento'])
            ->find();
        $results = [];
        foreach ($disponibilita as $disp) {
            $results[] = $disp->toSwagger();
        }
        $myResponse = Web::setupResponseHeaders($response);
        $myResponse->getBody()->write(json_encode($results));

        return $myResponse;
    } catch (Exception $e) {
        return Web::error500($e, $response);
    }
});

/**
 * POST postazioniIdPostazioneAssegnamentiIdAssegnamentoDisponibilitaPost
 * Summary:
 * Notes: Aggiunge una disponibilità della postazione
 * Output-Formats: [application/json]
 */
$app->POST('/postazioni/{idPostazione}/assegnamenti/{idAssegnamento}/disponibilita',
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

        $dataInizio = $body['dataInizio'];
        if (!Web::isData($dataInizio)) {
            return Web::error400('DataInizio', $response);
        }

        $dataFine = $body['dataFine'];
        if (!Web::isData($dataFine)) {
            return Web::error400('DataFine', $response);
        }

        //inserisco i dati
        $disponibilita = new DisponibilitaPostazione();

        $disponibilita->setIdAssegnamentoPostazione($args['idAssegnamento']);
        $disponibilita->setDataInizio($dataInizio);
        $disponibilita->setDataFine($dataFine);
        $disponibilita->save();
        $disponibilita->getIdDisponibilitaPostazione();

        $myResponse = Web::setupResponseHeaders($response);
        $myResponse->write(json_encode($disponibilita->toArray()));

        return $myResponse;
    } catch (Exception $e) {
        return Web::error500($e, $response);
    }
});

/**
 * OPTIONS postazioniIdPostazioneAssegnamentiIdAssegnamentoDisponibilitaOptions
 * Summary:
 * Notes:
 * Output-Formats: [application/json]
 */
$app->OPTIONS('/postazioni/{idPostazione}/assegnamenti/{idAssegnamento}/disponibilita',
    function(ServerRequestInterface $request, ResponseInterface $response) {
    $myResponse = Web::setupResponseHeaders($response);
    return $myResponse;
});

//************************************   /postazioni/{idPostazione}/assegnamenti/{idAssegnamento}/disponibilita/{idDisponibilita}

/**
 * GET postazioniIdPostazioneAssegnamentiIdAssegnamentoDisponibilitaIdDisponibilitaGet
 * Summary:
 * Notes: Restituisce la disponibilità della postazione
 * Output-Formats: [application/json]
 */
$app->GET('/postazioni/{idPostazione}/assegnamenti/{idAssegnamento}/disponibilita/{idDisponibilita}',
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

        $disponibilita = DisponibilitaPostazioneQuery::create()
            ->useAssegnamentiPostazioneQuery()
            ->usePostazioniQuery()
            ->filterByIdPostazione($args['idPostazione'])
            ->endUse()
            ->endUse()
            ->filterByIdAssegnamentoPostazione($args['idAssegnamento'])
            ->filterByIdDisponibilitaPostazione($args['idDisponibilita'])
            ->find();

        $results = $disponibilita->toSwagger();

        $myResponse = Web::setupResponseHeaders($response);
        $myResponse->getBody()->write(json_encode($results));

        return $myResponse;
    } catch (Exception $e) {
        return Web::error500($e, $response);
    }
});

/**
 * PUT postazioniIdPostazioneAssegnamentiIdAssegnamentoDisponibilitaIdDisponibilitaPut
 * Summary:
 * Notes: Aggiorna la disponibilità della postazione
 * Output-Formats: [application/json]
 */
$app->PUT('/postazioni/{idPostazione}/assegnamenti/{idAssegnamento}/disponibilita/{idDisponibilita}',
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
            return Web::error400('DataInizio', $response);
        }

        $dataFine = $body['dataFine'];
        if (!Web::isData($dataFine)) {
            return Web::error400('DataFine', $response);
        }

        //inserisco i dati
        $disponibilita = DisponibilitaPostazioneQuery::create()->findOneByIdDisponibilitaPostazione($args['idDisponibilita']);

        $disponibilita->setIdAssegnamentoPostazione($args['idAssegnamento']);
        $disponibilita->setDataInizio($dataInizio);
        $disponibilita->setDataFine($dataFine);
        $disponibilita->save();

        $myResponse = Web::setupResponseHeaders($response);
        $myResponse->write(json_encode($disponibilita->toArray()));

        return $myResponse;
    } catch (Exception $e) {
        return Web::error500($e, $response);
    }
});

/**
 * DELETE postazioniIdPostazioneAssegnamentiIdAssegnamentoDisponibilitaIdDisponibilitaDelete
 * Summary:
 * Notes: Cancella la disponibilità della postazione. ***TODO*** Come gestiamo eventuali subaffitti già registrati?
 * Output-Formats: [application/json]
 */
$app->DELETE('/postazioni/{idPostazione}/assegnamenti/{idAssegnamento}/disponibilita/{idDisponibilita}',
    function(ServerRequestInterface $request, ResponseInterface $response, $args) {
    $con = web::getConnection();

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

        $disponibilita = DisponibilitaPostazioneQuery::create()
            ->useAssegnamentiPostazioneQuery()
            ->usePostazioniQuery()
            ->filterByIdPostazione($args['idPostazione'])
            ->endUse()
            ->endUse()
            ->filterByIdAssegnamentoPostazione($args['idAssegnamento'])
            ->filterByIdDisponibilitaPostazione($args['idDisponibilita'])
            ->find();

        /* TODO: verificare che LoadDisponibilita() si equivalente al loop
          foreach ($disponibilita as $disponibile) {
          $disponibile->getAssegnamentiPostazione();
          $disponibile->getSubaffittiPostaziones();
          } */
        //Matteo dovrebbe funzionare perche' ho una sola disponibilita.
        $results[] = $disponibilita->toSwagger();


        $con->beginTransaction();

        SubaffittiPostazioneQuery::deleteSubaffittiByIdDisponibilita($args['idDisponibilita']);
        DisponibilitaPostazioneQuery::deleteDisponibilitaById($args['idDisponibilita']);

        $con->commit();

        $myResponse = Web::setupResponseHeaders($response);
        $myResponse->getBody()->write($results);

        return $myResponse;
    } catch (Exception $e) {
        $con->rollBack();
        return Web::error500($e, $response);
    }
});

/**
 * OPTIONS postazioniIdPostazioneAssegnamentiIdAssegnamentoDisponibilitaIdDisponibilitaOptions
 * Summary:
 * Notes:
 * Output-Formats: [application/json]
 */
$app->OPTIONS('/postazioni/{idPostazione}/assegnamenti/{idAssegnamento}/disponibilita/{idDisponibilita}',
    function(ServerRequestInterface $request, ResponseInterface $response) {
    $myResponse = Web::setupResponseHeaders($response);
    return $myResponse;
});
