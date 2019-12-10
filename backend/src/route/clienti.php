<?php

use \Psr\Http\Message\ServerRequestInterface;
use \Psr\Http\Message\ResponseInterface;
use \Propel\Runtime\ActiveQuery\Criteria;

require_once 'src/swagger/Cliente.php';



/**
 * GET clienti
 * Summary:
 * Notes: Restituisce la lista degli oggetti Cliente definiti
 * Output-Formats: [application/json]
 */
$app->GET('/clienti',
    function(ServerRequestInterface $request, ResponseInterface $response) {
    try {
        $filtro = '%';
        $queryParams = $request->getQueryParams();

        //verifico se ci sono criteri di ricerca se ci sono imposto la ricerca
        if (array_key_exists('filtro', $queryParams)) {
            $filtro = '%' . $queryParams['filtro'] . '%';
        }

        if (web::assertParam($queryParams, 'assegn_inizio')) {
            $dataInizio = Web::toDateTime($queryParams['assegn_inizio'], 'assegn_inizio');
        } else {
            $dataInizio = new DateTime();
        }
        $dataInizio->setTime(0, 0, 0);

        $filtroData = new Criteria();
        $filtroData->add(Map\AssegnamentiPostazioneTableMap::COL_DATA_FINE, $dataInizio,
            Criteria::GREATER_EQUAL);

        if (web::assertParam($queryParams, 'assegn_fine')) {
            $dataFine = Web::toDateTime($queryParams['assegn_fine'], 'assegn_fine');
            $dataFine->setTime(23, 59, 59);
            $filtroData->addAnd(Map\AssegnamentiPostazioneTableMap::COL_DATA_FINE, $dataFine,
                Criteria::LESS_EQUAL);
        }

        $clienti = ClientiQuery::create()
            ->useAccountQuery()
            ->filterByNome($filtro, Criteria::LIKE)
            ->useProfiliQuery()
            ->usePrivilegiProfiloQuery()
            ->filterByIdPrivilegio(1)
            ->endUse()
            ->endUse()
            ->orderByNome()
            ->endUse()
            ->find();

        $results = [];

        foreach ($clienti as $cliente) {
            $results[] = $cliente->toSwagger(true, $filtroData);
        }

        return Web::responseOk($response, json_encode($results));
    } catch (BadRequestException $bre) {
        return Web::error400($bre->fieldName, $response);
    } catch (Exception $e) {
        return Web::error500($e, $response);
    }
});

/**
 * POST clientiPost
 * Summary:
 * Notes: Crea un nuovo &#x60;Cliente&#x60;
 * Output-Formats: [application/json]
 */
$app->POST('/clienti',
    function(ServerRequestInterface $request, ResponseInterface $response, $args) {
    $con = null;

    try {
        $con = web::getConnection();

        // prendo i dati dal body e li pulisco di eventuali caratteri speciali
        $body = $request->getParsedBody();

        // Email, nome e telefono sono registrati nella tabella degli account.
        // Quindi l'account va creato anche se l'utente non lo chiede, ma in questo caso
        // non viene attivato.

        // TODO: Assegna automaticamente il profilo cliente ma bisognerebbe trovare un
        // modo più furbo di farlo. NON deve prendere il profilo dall'app, questo è un cliente!
        $idprofilo = 3;

        // TODO: questa funzione non rispetta lo standard, alcune email valide vengono
        // rifiutate (vedi http://php.net/manual/en/function.filter-var.php#111828 e successivi
        // In futuro implementare un controllo più smart! Per adesso è sufficiente
        $email = filter_var(trim($body['email']), FILTER_VALIDATE_EMAIL);
        if ($email === false) {
            return Web::error400('email', $response);
        }

        // TODO: Fare una singola funzione di validazione da usare
        //       ogni volta piuttosto di duplicare il codice
        //       Lo stesso codice identico è in PUT/clienti/:id

        $nome = web::PulisciStr($body['nome']);
        if ($nome === "") {
            return Web::error400('nome', $response);
        }

        $indirizzo = web::PulisciStr($body['indirizzo']);
        $cap = web::PulisciStr($body['cap']);
        $citta = web::PulisciStr($body['citta']);
        $provincia = web::PulisciStr($body['provincia']);
        $stato = web::PulisciStr($body['stato']);
        $codiceFiscale = web::PulisciStr($body['codiceFiscale']);

        $telefono = web::PulisciStr($body['telefono']);
        $daSaldare = web::PulisciStr($body['daSaldare']);
        $note = web::PulisciStr($body['note']);

        // Il cliente deve essere abilitato solo dopo la verifica dell'email
        $abilitato = false;

        $con->beginTransaction();

        // Credo il nuovo cliente
        $cliente = new Clienti();
        $cliente->setIndirizzo($indirizzo)
            ->setCitta($citta)
            ->setProvincia($provincia)
            ->setCap($cap)
            ->setStato($stato)
            ->setCodiceFiscale($codiceFiscale)
            ->setDaSaldare($daSaldare)
            ->setNote($note)
            ->save();

        // Creo il nuovo account e lo salvo
        $account = new Account();
        $account->setIdProfilo($idprofilo)
            ->setEmail($email)
            ->setPassword(null)
            ->setNome($nome)
            ->setTelefono($telefono)
            ->setAbilitato($abilitato)
            ->setIdCliente($cliente->getIdCliente())
            ->save();

        $con->commit();

        // TODO: Registrare un task di invio email al nuovo cliente
        // per attivare l'account

        return Web::responseOk($response,
                json_encode([
                'idCliente' => $cliente->getIdCliente()
        ]));
    } catch (Exception $e) {
        // TODO: gestire la violazione di integrità sull'inserimento dell'account
        // Comunicare l'errore alla web-app, l'utente deve capire che l'email è già
        // utilizzata
        $con->rollback();
        return Web::error500($e, $response);
    }
});

/**
 * OPTIONS clientiOptions
 * Summary:
 * Notes:
 * Output-Formats: [application/json]
 */
$app->OPTIONS('/clienti',
    function(ServerRequestInterface $request, ResponseInterface $response) {
    return Web::setupResponseHeaders($response);
});

/**
 * Restituisce la lista degli oggetti &#x60;Cliente&#x60; definiti
 * Output-Formats: [application/json]
 */
$app->GET('/clienti/{idCliente}',
    function(ServerRequestInterface $request, ResponseInterface $response, $args) {
    try {
        // TODO: Validare i dati forniti dal cliente in questo modo è verboso
        // e facile da sbagliare. Nella funzione di verifica sollevare una
        // eccezione specifica per l'errore con tutti i dati da comunicare.
        // Nel metodo del servizio REST implementare la catch opportuna e
        // infine richiamare la Web::error400.

        $queryParams = $request->getQueryParams();

        $response = VerificoClienteById($response, $args);
        if ($response->getStatusCode() >= 400) {
            return $response;
        }

        if (web::assertParam($queryParams, 'assegn_inizio')) {
            $dataInizio = Web::toDateTime($queryParams['assegn_inizio'], 'assegn_inizio');
        } else {
            $dataInizio = new DateTime();
        }
        $dataInizio->setTime(0, 0, 0);

        $filtroData = new Criteria();
        $filtroData->add(Map\AssegnamentiPostazioneTableMap::COL_DATA_FINE, $dataInizio,
            Criteria::GREATER_EQUAL);

        if (web::assertParam($queryParams, 'assegn_fine')) {
            $dataFine = Web::toDateTime($queryParams['assegn_fine'], 'assegn_fine');
            $dataFine->setTime(23, 59, 59);
            $filtroData->addAnd(Map\AssegnamentiPostazioneTableMap::COL_DATA_FINE, $dataFine,
                Criteria::LESS_EQUAL);
        }

        $cliente = ClientiQuery::create()
            ->findPk($args['idCliente']);

        $results = $cliente->toSwagger(true, $filtroData);

        return Web::responseOk($response, json_encode($results));
    } catch (BadRequestException $bre) {
        return Web::error400($bre->fieldName, $response);
    } catch (Exception $e) {
        return Web::error500($e, $response);
    }
});

/**
 * PUT clientiIdClientePut
 * Summary:
 * Notes: Aggiorna l&#39;anagrafica &#x60;Cliente&#x60;. L&#39;Id cliente fornito sulla rotta sovrascrive quello possibilmente fornito nel body
 * Output-Formats: [application/json]
 */
$app->PUT('/clienti/{idCliente}',
    function($request, $response, $args) {
    $con = web::getConnection();
    try {

        $response = VerificoClienteById($response, $args);
        if ($response->getStatusCode() >= 400) {
            return $response;
        }

        // prendo i dati dal body e li pulisco di eventuali caratteri speciali
        $body = $request->getParsedBody();

        // Ignoro id profilo di proposito, non è possibile cambiarlo su un cliente

        $nome = web::PulisciStr($body['nome']);
        if ($nome == "") {
            return Web::error400('nome', $response);
        }

        $email = web::PulisciStr($body['email']);
        if ($email == "") {
            return Web::error400('email', $response);
        }

        $indirizzo = web::PulisciStr($body['indirizzo']);
        $cap = web::PulisciStr($body['cap']);
        $citta = web::PulisciStr($body['citta']);
        $provincia = web::PulisciStr($body['provincia']);
        $stato = web::PulisciStr($body['stato']);
        $codiceFiscale = web::PulisciStr($body['codiceFiscale']);
        $telefono = web::PulisciStr($body['telefono']);
        $daSaldare = web::PulisciStr($body['daSaldare']);
        $note = web::PulisciStr($body['note']);

        // Ignorato, al momento sempre disabled
        //$abilitato = $body['abilitato'];

        $con->beginTransaction();

        $account = AccountQuery::create()->findByIdCliente($args['idCliente']);
        if (count($account) === 1) {
            $account[0]->setEmail($email);
            $account[0]->setNome($nome);
            $account[0]->setTelefono($telefono);
            $account[0]->save();
        } else {
            $msg = 'Associazione cliente-account incongruente per id cliente ' . $args['idCliente'];
            $con->rollBack();
            return Web::error500($msg, $response);
        }

        $cliente = ClientiQuery::create()->findPk($args['idCliente']);
        $cliente->setIndirizzo($indirizzo);
        $cliente->setCitta($citta);
        $cliente->setProvincia($provincia);
        $cliente->setCap($cap);
        $cliente->setStato($stato);
        $cliente->setCodiceFiscale($codiceFiscale);
        $cliente->setDaSaldare($daSaldare);
        $cliente->setNote($note);
        $cliente->save();

        $con->commit();

        return Web::responseOk($response, null);
    } catch (Exception $e) {
        $con->rollBack();
        return Web::error500($e, $response);
    }
});

/**
 * DELETE clientiIdClienteDelete
 * Summary:
 * Notes: Cancella un &#x60;Cliente&#x60;
 * Output-Formats: [application/json]
 */
$app->DELETE('/clienti/{idCliente}',
    function(ServerRequestInterface $request, ResponseInterface $response, $args) {
    $con = web::getConnection();

    try {
        $response = VerificoClienteById($response, $args);
        if ($response->getStatusCode() >= 400) {
            return $response;
        }

        $idCliente = $args['idCliente'];
        $cliente = ClientiQuery::create()
            ->findPk($idCliente);

        if ($cliente === null) {
            return Web::error404($response);
        }
        $result = $cliente->toSwagger(true);

        // Reperisco gli id degli elementi da cancellare
        $assegnamento = AssegnamentiPostazioneQuery::getPKFromIdCliente($idCliente);
        $disponibilita = DisponibilitaPostazioneQuery::getPKFromIdAssegnamento($assegnamento);
        $subaffitti = SubaffittiPostazioneQuery::getPKFromIdDisponibilita($disponibilita);

        // Cancello le entità correlate al cliente
        $con->beginTransaction();

        SubaffittiPostazioneQuery::deleteSubaffittiById($subaffitti);
        DisponibilitaPostazioneQuery::deleteDisponibilitaById($disponibilita);
        AssegnamentiPostazioneQuery::deleteAssegnamentiById($assegnamento);

        AccountQuery::deleteAccountByIdCliente($idCliente);

        SchedeQuery::create()
            ->filterByIdCliente($idCliente)
            ->update(array('IdCliente' => NULL));

        ClientiQuery::create()
            ->filterByIdCliente($idCliente)
            ->delete();

        $con->commit();

        return Web::responseOk($response, json_encode($result));
    } catch (Exception $e) {
        $con->rollBack();
        throw $e;
    }
});

/**
 * OPTIONS clientiIdClienteOptions
 * Summary:
 * Notes:
 * Output-Formats: [application/json]
 */
$app->OPTIONS('/clienti/{idCliente}',
    function(ServerRequestInterface $request, ResponseInterface $response) {
    return Web::setupResponseHeaders($response);
});
