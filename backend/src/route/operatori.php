<?php

use \Psr\Http\Message\ServerRequestInterface;
use \Psr\Http\Message\ResponseInterface;
use \Propel\Runtime\ActiveQuery\Criteria;

require_once 'src/swagger/Operatore.php';


/**
 * Restituisce la lista degli oggetti &#x60;Account&#x60; definiti
 * Output-Formats: [application/json]
 */
$app->GET('/operatori',
    function(ServerRequestInterface $request, ResponseInterface $response) {

    try {
        $queryParams = $request->getQueryParams();

        if (array_key_exists('filtro', $queryParams)) {
            $filtro = '%' . $queryParams['filtro'] . '%';
        } else {
            $filtro = '%';
        }

        $account = AccountQuery::create()
            ->orderByNome()
            ->filterByNome($filtro, Criteria::LIKE)
            ->useProfiliQuery()
            ->usePrivilegiProfiloQuery()
            ->filterByIdPrivilegio([2,3])
            ->endUse()
            ->endUse()
            ->find();

        $results = [];
        foreach ($account as $operatore) {
            $results[] = $operatore->toSwagger();
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
 * POST accountPost
 * Summary:
 * Notes: Crea un nuovo &#x60;Account&#x60;
 * Output-Formats: [application/json]
 */
$app->POST('/operatori',
    function(ServerRequestInterface $request, ResponseInterface $response, $args) {
    try {
        // prendo i dati dal body e li pulisco di eventuali caratteri speciali
        $body = $request->getParsedBody();

        // TODO: verificare che il profilo sia quello di un operatore
        $idprofilo = $body['idprofilo'];
        if (!is_numeric($idprofilo)) {
            return Web::error400('idprofilo', $response);
        }

//        $idCliente = $body['idCliente'];
//        if (!is_null($idCliente)) {
//            if (!is_numeric($idCliente)) {
//                return Web::error400('idCliente');
//            }
//        }

        $nome = web::PulisciStr($body['nome']);
        if ($nome == "") {
            return Web::error400('nome', $response);
        }

        $email = web::PulisciStr($body['email']);
        if ($email == "") {
            return Web::error400('email', $response);
        }

        $password = web::PulisciStr($body['password']);
        if ($password == "") {
            return Web::error400('password', $response);
        }

        $indirizzo = web::PulisciStr($body['indirizzo']);
        $telefono = web::PulisciStr($body['telefono']);
        $abilitato = $body['abilitato'];

        //inserisco i dati
        $account = new Account();
        $account->setIdCliente(null);
        $account->setIdProfilo($idprofilo);
        $account->setEmail($email);
        $account->setPassword($password);
        $account->setNome($nome);
        $account->setIndirizzo($indirizzo);
        $account->setTelefono($telefono);
        $account->setAbilitato($abilitato);
        $account->save();
        $account->getIdAccount();

        $result = $operatore->toSwagger();

        $myResponse = Web::setupResponseHeaders($response);
        $myResponse->getBody()
            ->write(json_encode($result));

        return $myResponse;
    } catch (Exception $e) {
        return Web::error500($e, $response);
    }
});

/**
 * OPTIONS accountOptions
 * Output-Formats: [application/json]
 */
$app->OPTIONS('/operatori',
    function(ServerRequestInterface $request, ResponseInterface $response) {
    $myResponse = Web::setupResponseHeaders($response);
    return $myResponse;
});

/**
 * GET accountIdAccountGet
 * Summary:
 * Notes: Restituisce l&#39;anagrafica del &#x60;Account&#x60;
 * Output-Formats: [application/json]
 */
$app->GET('/operatori/{idOperatore}',
    function(ServerRequestInterface $request, ResponseInterface $response, $args) {
    try {
        //verifico che il parametro sia un numerico
        if (!is_numeric($args['idOperatore'])) {
            return Web::error400('idOperatore', $response);
        }

        $account = AccountQuery::create()
            ->findPk($args['idOperatore']);

        if ($account === null) {
            return Web::error404($response);
        }

        $result = $operatore->toSwagger();

        $myResponse = Web::setupResponseHeaders($response);
        $myResponse->getBody()
            ->write(json_encode($result));

        return $myResponse;
    } catch (Exception $e) {
        return Web::error500($e, $response);
    }
});

/**
 * Notes: Aggiorna l&#39;anagrafica &#x60;Account&#x60;.
 * L&#39;Id account fornito sulla rotta sovrascrive quello possibilmente fornito nel body
 * Output-Formats: [application/json]
 */
$app->PUT('/operatori/{idOperatore}',
    function(ServerRequestInterface $request, ResponseInterface $response, $args) {

    try {
        //verifico che il parametro sia un numerico
        if (!is_numeric($args['idOperatore'])) {
            return Web::error400('idOperatore', $response);
        }

        $queryParams = $request->getQueryParams();

        // prendo i dati dal body e li pulisco di eventuali caratteri speciali
        $body = $request->getParsedBody();

        // TODO: verificare che il profilo sia da operatore
        $idProfilo = $body['idProfilo'];
        if (!is_numeric($idProfilo)) {
            return Web::error400('idProfilo', $response);
        }

        $idCliente = $body['idCliente'];
        if (!is_null($idCliente)) {
            if (!is_numeric($idCliente)) {
                return Web::error400('idCliente', $response);
            }
        }
        $nome = web::PulisciStr($body['nome']);
        if ($nome == "") {
            return Web::error400('nome', $response);
        }
        $email = web::PulisciStr($body['email']);
        if ($email == "") {
            return Web::error400('email', $response);
        }
        $password = web::PulisciStr($body['password']);
        if ($password == "") {
            return Web::error400('password', $response);
        }

        $indirizzo = web::PulisciStr($body['indirizzo']);
        $telefono = web::PulisciStr($body['telefono']);
        $abilitato = $body['abilitato'];

        $account = AccountQuery::create()
            ->findPk($args['idOperatore']);

        $account->setIdCliente($idCliente);
        $account->setIdProfilo($idProfilo);
        $account->setEmail($email);
        $account->setPassword($password);
        $account->setNome($nome);
        $account->setIndirizzo($indirizzo);
        $account->setTelefono($telefono);
        $account->setAbilitato($abilitato);
        $account->save();

        $result = $operatore->toSwagger();

        $myResponse = Web::setupResponseHeaders($response);
        $myResponse->getBody()
            ->write(json_encode($result));

        return $myResponse;
    } catch (Exception $e) {
        return Web::error500($e, $response);
    }
});


/**
 * DELETE accountIdAccountDelete
 * Summary:
 * Notes: Cancella un &#x60;Account&#x60;
 * Output-Formats: [application/json]
 */
$app->DELETE('/operatori/{idOperatore}',
    function(ServerRequestInterface $request, ResponseInterface $response, $args) {
    try {
        if (!is_numeric($args['idAccount'])) {
            return Web::error400('idAccount', $response);
        }

        $account = AccountQuery::create()
            ->findPk($args['idAccount']);

        if ($account === null) {
            return Web::error404();
        }

        $account->delete();

        $result = $operatore->toSwagger();
        $myResponse = Web::setupResponseHeaders($response);
        $myResponse->getBody()
            ->write(json_encode($result));

        return $myResponse;
    } catch (Exception $e) {
        return Web::error500($e, $response);
    }
});

/**
 * Notes:
 * Output-Formats: [application/json]
 */
$app->OPTIONS('/operatori/{idOperatore}',
    function(ServerRequestInterface $request, ResponseInterface $response) {
    $myResponse = Web::setupResponseHeaders($response);
    return $myResponse;
});

