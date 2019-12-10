<?php

// vim: set ts=4 sw=4 expandtab:

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \Propel\Runtime\ActiveQuery\Criteria as Criteria;

/**
 * GET abbonamentiGet
 * Summary:
 * Notes: Restituisce la lista di tuttu glii Abbonamenti registrati. Es. stagionale, mensile, settimanale, giornaliero, speciale scelto dall&#39;utente
 * Output-Formats: [application/json]
 */
$app->GET('/abbonamenti',
    function(Request $request, Response $response, $args) {
    try {
        //$con = Web::getConnection();

        $varfiltro = '%';
        $queryParams = $request->getQueryParams();
        //verifico se ci sono criteri di ricerca se ci sono imposto la ricerca
        if (array_key_exists('filtro', $queryParams)) {
            $varfiltro = '%' . $queryParams['filtro'] . '%';
        }

        $abbonamenti = AbbonamentiQuery::create()
            ->orderByCodice()
            ->filterByCodice($varfiltro, Criteria::LIKE)
            ->find();

        //echo $con->getLastExecutedQuery();
        $results = [];
        foreach ($abbonamenti as $abbonamento) {
            $results[] = $abbonamento->toSwagger();
        }

        $myResponse = Web::setupResponseHeaders($response);
        $myResponse->getBody()
            ->write(json_encode($results));

        return $myResponse;
    } catch (Exception $e) {
        return Web::error500($e, $response);
    }
});

/**
 * POST addAbbonamento
 * Summary:
 * Notes: Crea un abbonamento&#x60;
 * Output-Formats: [application/json]
 */
$app->POST('/abbonamenti',
    function(Request $request, Response $response) {
    try {
        // prendo i dati dal body e li pulisco di eventuali caratteri speciali
        $body = $request->getParsedBody();
        $codice = web::PulisciStr($body['codice']);
        if ($codice == "") {
            return Web::error400('codice', $response);
        }
        $costo = $body['costo'];
        //controllo che costo sia numerico e non una stringa
        if (!is_numeric($costo)) {
            return Web::error400('costo', $response);
        }

        //inserisco i dati in abbonamento
        $abbonamnto = new Abbonamenti();
        $abbonamnto->setCodice($codice);
        $abbonamnto->setCosto($costo);
        $abbonamnto->save();
        $abbonamnto->getIdAbbonamento();

        $myResponse = Web::setupResponseHeaders($response);
        $myResponse->getBody()
            ->write(json_encode($abbonamnto->toArray()));

        return $myResponse;
    } catch (Exception $e) {
        return Web::error500($e, $response);
    }
});
//*************************************************/Abbonamenti/{idAbbonamento}

/**
 * GET abbonamentiIdAbbonamentoGet
 * Summary:
 * Notes: Restituisce i dati dell&#x60;Abbonamento&#x60;
 * Output-Formats: [application/json]
 */
$app->GET('/abbonamenti/{idAbbonamento}',
    function(Request $request, Response $response, $args) {
    $myResponse = Web::setupResponseHeaders($response);

    try {
        //verifico che il parametro sia un numerico
        if (!is_numeric($args['idAbbonamento'])) {
            return Web::error400('idAbbonamento', $response);
        }

        // Cerco l'abbonamento
        $abbonamento = AbbonamentiQuery::create()
            ->findPk($args['idAbbonamento']);

        // Se non trovo corrispondenze do un 404
        if ($abbonamento === null) {
            return Web::error404($response);
        } else {
            $myResponse->getBody()
                ->write(json_encode($abbonamento->toSwagger()));
            return $myResponse;
        }
    } catch (Exception $e) {
        return Web::error500($e, $response);
    }
});

/**
 * DELETE abbonamentiIdAbbonamentoDelete
 * Summary:
 * Notes: Cancella una tipologia di Abbonamento
 * Output-Formats: [application/json]
 */
$app->DELETE('/abbonamenti/{idAbbonamento}',
    function(Request $request, Response $response, $args) {
    try {
        //verifico che il parametro sia un numerico
        if (!is_numeric($args['idAbbonamento'])) {
            return Web::error400('idAbbonamento', $response);
        }

        $abbonamenti = AbbonamentiQuery::create()
            ->orderByIdAbbonamento()
            ->filterByIdAbbonamento($args['idAbbonamento'])
            ->find()
            ->toArray();

        if ((count($abbonamenti) == 0))
            return Web::error404();

        AbbonamentiQuery::create()
            ->filterByIdAbbonamento($args['idAbbonamento'])
            ->delete();

        $myResponse = Web::setupResponseHeaders($response);
        $myResponse->getBody()
            ->write(json_encode($abbonamenti));

        return $myResponse;
    } catch (Exception $e) {
        return Web::error500($e, $response);
    }
});
