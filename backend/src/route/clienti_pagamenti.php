<?php

use \Psr\Http\Message\ServerRequestInterface;
use \Psr\Http\Message\ResponseInterface;

require_once 'src/swagger/Pagamento.php';


/**
 * Restituisce la lista delle caparre versate dal cliente
 * Output-Formats: [application/json]
 */
$app->GET('/clienti/{idCliente}/pagamenti',
    function(ServerRequestInterface $request, ResponseInterface $response, $args) {
    try {
        $response = VerificoClienteById($response, $args);
        if ($response->getStatusCode() >= 400) {
            return $response;
        }

        $idCliente = $args['idCliente'];

        $pagamenti = PagamentiQuery::create()
            ->filterByIdCliente($idCliente)
            ->find();

        $results = [];
        foreach ($pagamenti as $pagamento) {
            $results[] = $pagamento->toSwagger();
        }

        $myResponse = Web::setupResponseHeaders($response);
        $myResponse->getBody()->write(json_encode($results));

        return $myResponse;
    } catch (Exception $e) {
        return Web::error500($e, $response);
    }
});

/**
 * POST clientiIdClientePagamentiPost
 * Summary:
 * Notes: Crea un nuovo record per una caparra versata
 * Output-Formats: [application/json]
 */
$app->POST('/clienti/{idCliente}/pagamenti',
    function(ServerRequestInterface $request, ResponseInterface $response, $args) {
    try {
        $con = web::getConnection();
        $response = VerificoClienteById($response, $args);
        if ($response->getStatusCode() >= 400) {
            return $response;
        }

        // prendo i dati dal body e li pulisco di eventuali caratteri speciali
        $body = $request->getParsedBody();

        $dataPagamento = $body['data'];
        if (!Web::isData($dataPagamento)) {
            return Web::error400('DataPagamento', $response);
        }

        $importo = $body['importo'];
        if ((empty($importo)) || (!is_numeric($importo))) {
            return Web::error400('importo', $response);
        }

        $con->beginTransaction();

        //inserisco i dati
        $pagamenti = new Pagamenti();
        $pagamenti->setidCliente($args['idCliente']);
        $pagamenti->setData($dataPagamento);
        $pagamenti->setImporto($importo);
        $pagamenti->save();

        // TODO: aggiungere tra i parametri un flag per vedere se l'importo va scalato????
        $cliente = ClientiQuery::create()->findPk($args['idCliente']);
        $daSaldare = $cliente->getDaSaldare() - $importo;

        if ($daSaldare < 0) {
            $con->rollBack();
            return web::error400('importo maggiore del dovuto', $response);
        }

        $cliente->setDaSaldare($daSaldare);
        $cliente->save();

        $con->commit();

        $myResponse = Web::setupResponseHeaders($response);
        //$myResponse->write(json_encode($pagamenti->toArray()));
        $myResponse->write(json_encode([
            'idPagamento' => $pagamenti->getIdPagamento()
        ]));

        return $myResponse;
    } catch (Exception $e) {
        $con->rollback();
        return Web::error500($e, $response);
    } return $response;
});

/**
 * OPTIONS clientiIdClientePagamentiOptions
 * Summary:
 * Notes:
 * Output-Formats: [application/json]
 */
$app->OPTIONS('/clienti/{idCliente}/pagamenti',
    function(ServerRequestInterface $request, ResponseInterface $response, $args) {
    $myResponse = Web::setupResponseHeaders($response);
    return $myResponse;
});

/**
 * Restituisce i dati di una caparra versata da un cliente
 * Output-Formats: [application/json]
 */
$app->GET('/clienti/{idCliente}/pagamenti/{idPagamento}',
    function(ServerRequestInterface $request, ResponseInterface $response, $args) {
    try {
        $response = VerificoClienteById($response, $args);
        if ($response->getStatusCode() >= 400) {
            return $response;
        }
        $idCliente = $args['idCliente'];

        $idPagamento = $args['idPagamento'];
        if (!is_numeric($idPagamento)) {
            return Web::error400('idPagamento', $response);
        }

        $pagamenti = PagamentiQuery::create()
            ->filterByIdCliente($idCliente)
            ->filterByIdPagamento($idPagamento)
            ->find();

        $results = [];
        foreach ($pagamenti as $pagamento) {
            $results[] = $pagamento->toSwagger();
        }

        $myResponse = Web::setupResponseHeaders($response);
        $myResponse->getBody()->write(json_encode($results));

        return $myResponse;
    } catch (Exception $e) {
        return Web::error500($e, $response);
    }
});


/**
 * Aggiorna i dati di una caparra versata
 * Output-Formats: [application/json]
 */
$app->PUT('/clienti/{idCliente}/pagamenti/{idPagamento}',
    function(ServerRequestInterface $request, ResponseInterface $response, $args) {
    try {
        $con = web::getConnection();
        $response = VerificoClienteById($response, $args);
        if ($response->getStatusCode() >= 400) {
            return $response;
        }

        //verifico che il parametro sia un numerico
        if (!is_numeric($args['idPagamento'])) {
            return Web::error400('idPagamento', $response);
        }

        $pagamento = PagamentiQuery::create()
            ->filterByidCliente($args['idCliente'])
            ->filterByIdPagamento($args['idPagamento'])
            ->findOne();
        $oldPagamento = $pagamento->getImporto();
        $pagamento->toArray();
        // se non trovo corrispondenze do un 404
        if (count($pagamento) === 0) {
            return $response->withStatus(404);
        }

        // prendo i dati dal body e li pulisco di eventuali caratteri speciali
        $body = $request->getParsedBody();
        $dataPagamento = $body['data'];
        if (!Web::isData($dataPagamento)) {
            return Web::error400('DataPagamento');
        }

        $importo = $body['importo'];
        if ((empty($importo)) || (!is_numeric($importo))) {
            return Web::error400('importo', $response);
        }
        $con->beginTransaction();
        //inserisco i dati
        $pagamento = PagamentiQuery::create()->findOneByIdPagamento($args['idPagamento']);
        $pagamento->setData($dataPagamento);
        $pagamento->setImporto($importo);
        $pagamento->save();

        $cliente = ClientiQuery::create()->findPk($args['idCliente']);
        $importo = $oldPagamento - $importo;
        $daSaldare = ($cliente->getDaSaldare()) + ($importo);

        if ($daSaldare < 0) {
            $con->rollBack();
            return web::error400('importo troppo grande', $response);
        }
        $cliente->setDaSaldare($daSaldare);
        $cliente->save();

        $myResponse = Web::setupResponseHeaders($response);
        $myResponse->write(json_encode($pagamento->toArray()));
        $con->commit();
        return $myResponse;
    } catch (Exception $e) {
        $con->rollBack();
        return Web::error500($e, $response);
    }
});

/**
 * OPTIONS IdClientePagamentiIdPagamentoOptions
 * Summary:
 * Notes:
 * Output-Formats: [application/json]
 */
$app->OPTIONS('/clienti/{idCliente}/pagamenti/{idPagamento}',
    function(ServerRequestInterface $request, ResponseInterface $response, $args) {
    $myResponse = Web::setupResponseHeaders($response);
    return $myResponse;
});
