<?php

use \Psr\Http\Message\ServerRequestInterface;
use \Psr\Http\Message\ResponseInterface;
use \Propel\Runtime\ActiveQuery\Criteria;

require_once 'src/swagger/Servizio.php';

/**
 * GET postazioniIdPostazioneServiziGet
 * Summary:
 * Notes: Restituisce i servizi della postazione.
 * ***TODO*** da rivedere. La gestione dei servizi lato cliente andrebbe fatta su
 * *cliente/id/postazioni/id/servizi* per \&quot;blindare\&quot; id cliente e id postazione
 * Output-Formats: [application/json]
 */
$app->GET('/postazioni/{idPostazione}/assegnamenti/{idAssegnamento}/servizi',
    function(ServerRequestInterface $request, ResponseInterface $response, $args) {

    try {

        $con = Web::getConnection();
        $dataInizio = '';
        $dataFine = '';
        $response = VerificoPostazioneById($response, $args);
        if ($response->getStatusCode() >= 400) {
            return $response;
        }

        $response = VerificoAssegnamentoById($response, $args);
        if ($response->getStatusCode() >= 400) {
            return $response;
        }

        $query = ServiziQuery::create()
            ->filterByIdAssegnamentoPostazione($args['idAssegnamento']);

        $queryParams = $request->getQueryParams();

        if (web::assertParam($queryParams, 'dataInizio')) {
            $dataInizio = Web::toDateTime($queryParams['dataInizio'], 'dataInizio');
            $dataInizio->setTime(0, 0, 0);
            $query = $query->filterByDataInizio($dataInizio, Criteria::GREATER_EQUAL);
        }

        if (web::assertParam($queryParams, 'dataFine')) {
            $dataFine = Web::toDateTime($queryParams['dataFine'], 'dataFine');
            $dataFine->setTime(23, 59, 59);
            $query = $query->filterByDataFine($dataFine, Criteria::LESS_EQUAL);
        }

        $servizi = $query->find();

        //echo $con->getLastExecutedQuery();

        $results = [];

        foreach ($servizi as $servizio) {
            $results[] = $servizio->toSwagger();
        }

        return Web::responseOk($response, json_encode($results));
    } catch (BadRequestException $bre) {
        return Web::error400($bre->fieldName, $response);
    } catch (Exception $e) {
        return Web::error500($e, $response);
    }
});

/**
 * POST postazioniIdPostazioneServiziPost
 * Summary:
 * Notes: Aggiunge un servizio sulla postazione
 * Output-Formats: [application/json]
 */
$app->POST('/postazioni/{idPostazione}/assegnamenti/{idAssegnamento}/servizi',
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

        // prendo i dati dal body e li pulisco di eventuali caratteri speciali
        $body = $request->getParsedBody();

        if (web::assertParam($body, 'dataInizio')) {
            $dataInizio = Web::toDateTime($body['dataInizio'], 'dataInizio');
            $dataInizio->setTime(0, 0, 0);
        }

        if (web::assertParam($body, 'dataFine')) {
            $dataFine = Web::toDateTime($body['dataFine'], 'dataFine');
            $dataFine->setTime(23, 59, 59);
        }

        $idTipoServizio = $body['idTipoServizio'];
        if (!is_numeric($idTipoServizio)) {
            return Web::error400('idTipoServizio', $response);
        }

        $qta = $body['qta'];
        if (!is_numeric($qta)) {
            return Web::error400('qta', $response);
        }

        $costoUnitario = CostiServizioQuery::create()
            ->filterByIdTipoServizio($idTipoServizio)
            ->filterByInizioPeriodo($dataFine, Criteria::LESS_EQUAL)
            ->filterByFinePeriodo($dataInizio, Criteria::GREATER_EQUAL)
            ->find();

        //echo $con->getLastExecutedQuery();

        if (is_null($costoUnitario)) {
            return $response->withStatus(400);
        }

        //$dataInizio = strtotime($dataInizio);
        //$dataFine = strtotime($dataFine);

        $tot = 0;
        $giorniServizio = 0;
        //inizio_periodo e fine_periodo date prese dal database
        //data_inizio data_fine date inserite dal'utente
        //
        foreach ($costoUnitario as $costo) {
            $fine_periodo = $costo->getFinePeriodo()->getTimestamp();
            $inizio_periodo = $costo->getInizioPeriodo()->getTimestamp();

            // controllo date per calcolo
            if ($dataInizio >= $inizio_periodo) {
                if ($dataFine <= $fine_periodo) {
                    $giorniServizio = $giorniServizio + web::delta_tempo($dataInizio, $dataFine, "g") + 1;
                } elseif ($dataFine > $fine_periodo) {
                    $giorniServizio = $giorniServizio + web::delta_tempo($dataInizio, $fine_periodo,
                            "g") + 1;
                }
            } elseif ($dataInizio < $inizio_periodo) {
                if ($dataFine <= $fine_periodo) {
                    $giorniServizio = $giorniServizio + web::delta_tempo($inizio_periodo, $dataFine,
                            "g") + 1;
                } elseif ($dataFine > $fine_periodo) {
                    $giorniServizio = $giorniServizio + web::delta_tempo($inizio_periodo,
                            $fine_periodo, "g") + 1;
                }
            }
            $tot = $tot + ($giorniServizio * $costo->getCosto());
        }
        $costoFinale = ($tot * $qta );

        $note = web::PulisciStr($body['note']);

        //inserisco i dati
        $servizi = new Servizi();
        $servizi->setIdAssegnamentoPostazione($args['idAssegnamento']);
        $servizi->setIdTipoServizio($idTipoServizio);
        $servizi->setDataInizio($dataInizio);
        $servizi->setDataFine($dataFine);
        $servizi->setQta($qta);
        $servizi->setCostoFinale($costoFinale);
        $servizi->setNote($note);
        $servizi->save();

        return Web::responseOk($response,
            json_encode([
                'idServizio' => $servizi->getIdServizio()
        ]));
    } catch (BadRequestException $bre) {
        return Web::error400($bre->fieldName, $response);
    } catch (Exception $e) {
        return Web::error500($e, $response);
    }
});

/**
 * OPTIONS postazioniIdPostazioneServiziOptions
 * Summary:
 * Notes:
 * Output-Formats: [application/json]
 */
$app->OPTIONS('/postazioni/{idPostazione}/assegnamenti/{idAssegnamento}/servizi',
    function(ServerRequestInterface $request, ResponseInterface $response) {
    return Web::setupResponseHeaders($response);
});


//*************************************************************/postazioni/{idPostazione}/servizi/{idServizio}
/**
 * GET postazioniIdPostazioneServiziIdServizioGet
 * Summary:
 * Notes: Restituisce il subaffitto della postazione
 * Output-Formats: [application/json]
 */
$app->GET('/postazioni/{idPostazione}/assegnamenti/{idAssegnamento}/servizi/{idServizio}',
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

        //verifico che il parametro sia un numerico
        if (!is_numeric($args['idServizio'])) {
            return Web::error400('idServizio', $response);
        }

        $servizio = ServiziQuery::create()
            ->filterByIdAssegnamentoPostazione($args['idAssegnamento'])
            ->filterByIdServizio($args['idServizio'])
            ->find();

        if ($servizio === NULL) {
            $servizio = [];
        }
        $results = [];

        foreach ($servizio as $appServizio) {
            $results[] = $appServizio->ToSwagger();
        }

        return Web::responseOk($response, json_encode($results));
    } catch (Exception $e) {
        return Web::error500($e, $response);
    }
});

/**
 * PUT postazioniIdPostazioneServiziIdServizioPut
 * Summary:
 * Notes: Aggiorna il servizio della postazione
 * Output-Formats: [application/json]
 */
$app->PUT('/postazioni/{idPostazione}/assegnamenti/{idAssegnamento}/servizi/{idServizio}',
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

        // prendo i dati dal body e li pulisco di eventuali caratteri speciali
        $body = $request->getParsedBody();

        if (web::assertParam($body, 'dataInizio')) {
            $dataInizio = Web::toDateTime($body['dataInizio'], 'dataInizio');
            $dataInizio->setTime(0, 0, 0);
        } else {
            $dataInizio = null;
        }

        if (web::assertParam($body, 'dataFine')) {
            $dataFine = Web::toDateTime($body['dataFine'], 'dataFine');
            $dataFine->setTime(23, 59, 59);
        } else {
            $dataFine = null;
        }

        $idTipoServizio = $body['idTipoServizio'];
        if (!is_numeric($idTipoServizio)) {
            return Web::error400('idTipoServizio', $response);
        }

        $qta = $body['qta'];
        if (!is_numeric($qta)) {
            return Web::error400('qta', $response);
        }

        $costoUnitario = CostiServizioQuery::create()
            ->filterByIdTipoServizio($idTipoServizio)
            ->filterByInizioPeriodo($dataFine, Criteria::LESS_EQUAL)
            ->filterByFinePeriodo($dataInizio, Criteria::GREATER_EQUAL)
            ->find();

        if ($costoUnitario === null) {
            $costoUnitario = [];
        }

        // A occhio non servono più
//        $dataInizio = strtotime($dataInizio);
//        $dataFine = strtotime($dataFine);

        $tot = 0;
        $giorniServizio = 0;

        //TODO: mettere questo codice di calcolo costi con controllo date in una funzione stesso codice anche nella POST
        //inizio_periodo e fine_periodo date prese dal database
        //data_inizio data_fine date inserite dal'utente
        // -> Verificare se si può usare l'aritmetica dei timestamp

        foreach ($costoUnitario as $costo) {
            $fine_periodo = $costo->getFinePeriodo()->getTimestamp();
            $inizio_periodo = $costo->getInizioPeriodo()->getTimestamp();

            // controllo date per calcolo
            if ($dataInizio >= $inizio_periodo) {
                if ($dataFine <= $fine_periodo) {
                    $giorniServizio = $giorniServizio + web::delta_tempo($dataInizio, $dataFine, "g") + 1;
                } elseif ($dataFine > $fine_periodo) {
                    $giorniServizio = $giorniServizio + web::delta_tempo($dataInizio, $fine_periodo,
                            "g") + 1;
                }
            } elseif ($dataInizio < $inizio_periodo) {
                if ($dataFine <= $fine_periodo) {
                    $giorniServizio = $giorniServizio + web::delta_tempo($inizio_periodo, $dataFine,
                            "g") + 1;
                } elseif ($dataFine > $fine_periodo) {
                    $giorniServizio = $giorniServizio + web::delta_tempo($inizio_periodo,
                            $fine_periodo, "g") + 1;
                }
            }
            $tot = $tot + ($giorniServizio * $costo->getCosto());
        }
        $costoFinale = ($tot * $qta );

        $note = web::PulisciStr($body['note']);

        //inserisco i dati
        $servizi = ServiziQuery::create()->findOneByIdServizio($args['idServizio']);
        $servizi->setIdAssegnamentoPostazione($args['idAssegnamento']);
        $servizi->setIdTipoServizio($idTipoServizio);
        $servizi->setDataInizio($dataInizio);
        $servizi->setDataFine($dataFine);
        $servizi->setQta($qta);
        $servizi->setCostoFinale($costoFinale);
        $servizi->setNote($note);
        $servizi->save();

        $myResponse = Web::setupResponseHeaders($response);
        $myResponse->write(json_encode($servizi->toArray()));

        return $myResponse;
    } catch (BadRequestException $bre) {
        return Web::error400($bre->fieldName, $response);
    } catch (Exception $e) {
        return Web::error500($e, $response);
    }
});

/**
 * DELETE postazioniIdPostazioneServiziIdServizioDelete
 * Summary:
 * Notes: Cancella il servizio della postazione
 * Output-Formats: [application/json]
 */
$app->DELETE('/postazioni/{idPostazione}/assegnamenti/{idAssegnamento}/servizi/{idServizio}',
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

        //verifico che il parametro sia un numerico
        if (!is_numeric($args['idServizio'])) {
            return Web::error400('idServizio', $response);
            $response->getBody()->write($tmpError);
            return $response->withStatus(400);
        }

        $servizio = ServiziQuery::create()
            ->filterByIdAssegnamentoPostazione($args['idAssegnamento'])
            ->filterByIdServizio($args['idServizio'])
            ->find();
        if ($servizio === null) {
            $servizio = [];
        }
        $results = [];

        foreach ($servizio as $appServizio) {
            $results[] = $appServizio->ToSwagger();
        }

        ServiziQuery::create()
            ->filterByIdAssegnamentoPostazione($args['idAssegnamento'])
            ->filterByIdServizio($args['idServizio'])
            ->delete();

        $myResponse = Web::setupResponseHeaders($response);
        $myResponse->getBody()->write(json_encode($results));

        return $myResponse;
    } catch (Exception $e) {
        return Web::error500($e, $response);
    }
});

/**
 * OPTIONS postazioniIdPostazioneServiziIdServizioOptions
 * Summary:
 * Notes:
 * Output-Formats: [application/json]
 */
$app->OPTIONS('/postazioni/{idPostazione}/assegnamenti/{idAssegnamento}/servizi/{idServizio}',
    function(ServerRequestInterface $request, ResponseInterface $response) {
    return Web::setupResponseHeaders($response);
});
