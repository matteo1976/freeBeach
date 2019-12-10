<?php

// vim: set ts=4 sw=4 expandtab:

use \Psr\Http\Message\ResponseInterface;

define('ERRORE_400',
    "Controlli di validazione falliti. "
    . "Almeno un parametro non e' valido "
    . "(ad esempio una stringa al posto di un intero). "
    . "Si puo' trattare di un parametro specificato sulla rotta o nel body. "
    . "L'oggetto Error restituito nella risposta "
    . "contiene maggiori informazioni.");
define('ERRORE_404',
    "Risorsa non trovata. "
    . "Gli id forniti dal client sono validi "
    . "ma non esiste un'entita' corrispondente nel database");

class Web
{

    public static function assert($value) {
        if (empty($value)) {
            http_response_code(400);
            exit;
        }
    }

    public static function assertParam($queryParams, $key) {
        if (empty($queryParams))
            return false;

        if (!array_key_exists($key, $queryParams))
            return false;

        if (empty($queryParams[$key]))
            return false;

        return true;
    }

    /**
     *  Declare JSON type for response
     * @param ResponseInterface $response
     */
    public static function setupResponseHeaders(ResponseInterface $response) {
        /*
         * TODO: Alcuni headers sono già settati e non vengono aggiornati.
         * Ad esempio Content-type.
         * Capire se si possono sovrascrivere allegramente
         */
        /*
          if (!$response->hasHeader('Content-type')) {
          $response = $response->withHeader('Content-type', 'application/json;charset=utf-8');
          }

          // Disable response caching
          if (!$response->hasHeader('Cache-control')) {
          $response = $response->withHeader('Cache-control', 'private, max-age=0, no-cache');
          }

          // Enable access from all IPs
          if (!$response->hasHeader('Access-Control-Allow-Origin')) {
          $response = $response->withHeader('Access-Control-Allow-Origin', '*');
          }
          // Enable CORS  http://www.html5rocks.com/en/tutorials/cors

          if (!$response->hasHeader('Access-Control-Allow-Methods')) {
          $response = $response->withHeader('Access-Control-Allow-Methods',
          'GET, POST, PUT, DELETE, OPTIONS');
          }

          if (!$response->hasHeader('Access-Control-Allow-Headers')) {
          $response = $response->withHeader('Access-Control-Allow-Headers',
          'Origin, X-Requested-With, Content-Type, Accept,Authorization');
          }

          return $response;
         */
        return $response->withHeader('Content-type', 'application/json;charset=utf-8')

                // Disable response caching
                ->withHeader('Cache-control', 'private, max-age=0, no-cache')

                // Enable access from all IPs
                ->withHeader('Access-Control-Allow-Origin', '*')

                // Enable CORS  http://www.html5rocks.com/en/tutorials/cors
                ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS')
                ->withHeader('Access-Control-Allow-Headers',
                    'Origin, X-Requested-With, Content-Type, Accept,Authorization');
    }

    public static function PulisciStr($str) {
        // ma che scopo avrebbe?
        //return trim(preg_replace("/[^A-Za-z0-9 ]/", "", $str));
        return trim($str);
    }

    public static function getConnection() {
        try {
            $con = \Propel\Runtime\Propel::getWriteConnection('dbspiaggie');
            return $con;
        } catch (Exception $e) {
            $error = "Exception " . $e->getCode() . ": " . $e->getMessage() . "" .
                " in " . $e->getFile() . " on line " . $e->getLine() . "";
            echo $error;
        }
    }

    public static function isData($data) {
        try {
            new DateTime($data);
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    public static function toDateTime($timeStamp, $fieldName) {
        // Siccome DateTime di PHP non consente di resettare la frazione di secondo
        // la azzero sulla stringa altrimenti le ricerche non funzionano.
        // TODO: implementare un replace più elegante con preg_replace
        try {
            if (strtoupper(substr($timeStamp, -1)) === 'Z') {
                $timeStamp = substr($timeStamp, 0, strlen($timeStamp) - 4) . '000Z';
            }
            return new DateTime($timeStamp);
        } catch (Exception $e) {
            throw new BadRequestException($fieldName);
        }
    }

    public static function responseOk($response, $body) {
        $response = Web::setupResponseHeaders($response);
        $response->getBody()
            ->write($body);
        return $response->withStatus(200);
    }

    public static function error400($fieldInfo, ResponseInterface $response, $payload) {
        $errorDesc = array(
            'ErrorCode' => 400,
            'ErrorMsg' => ERRORE_400,
            'ErrorFields' => $fieldInfo
        );

        if (!empty($payload)) {
            $errorDesc['Payload'] = $payload;
        }

        if ($response === null) {
            return json_encode($errorDesc);
        } else {
            $response = Web::setupResponseHeaders($response);
            $response->getBody()
                ->write(json_encode($errorDesc));
            return $response->withStatus(400);
        }
    }

    public static function error404(ResponseInterface $response = null) {
        $errorDesc = (object) array(
                'ErrorCode' => 404,
                'ErrorMsg' => ERRORE_404,
                'ErrorFields' => null
        );

        if ($response === null) {
            return json_encode($errorDesc);
        } else {
            $response = Web::setupResponseHeaders($response);
            $response->getBody()
                ->write(json_encode($errorDesc));
            return $response->withStatus(404);
        }
    }

    public static function error500(Exception $e, ResponseInterface $response = null) {
        $message = 'Exception ' . $e->getCode()
            . ': ' . $e->getMessage()
            . ' in ' . $e->getFile()
            . '@' . $e->getLine();

        // TODO: deve utilizzare il logger di slim
        //$this->logger->error($message);
        // Utilizza il logger configurato su Propel
        $container = \Propel\Runtime\Propel::getServiceContainer();
        $logger = $container->getLogger();
        $logger->error($message);

        if ($response !== null) {
            $response = Web::setupResponseHeaders($response);
            return $response->withStatus(500);
        } else {
            return null;
        }
    }

    public static function delta_tempo($data_iniziale, $data_finale, $unita)
    {
        $data1 = $data_iniziale;
        $data2 = $data_finale;

        switch ($unita) {
            case "m": $unita = 1 / 60;
                break; //MINUTI
            case "h": $unita = 1;
                break; //ORE
            case "g": $unita = 24;
                break; //GIORNI
            case "a": $unita = 8760;
                break; //ANNI
        }
        $differenza = (($data2 - $data1) / 3600) / $unita;
        return floor($differenza);
    }
}

class BadRequestException extends Exception
{

    public $fieldName = null;

    public function __construct($fieldName) {
        assert(!empty($fieldName), '$fieldName parameter is required');

        $this->fieldName = $fieldName;
    }

}

set_error_handler(function($err_severity, $err_msg, $err_file, $err_line, array $err_context) {
    $container = \Propel\Runtime\Propel::getServiceContainer();
    $logger = $container->getLogger();

    if (0 === error_reporting()) {
        return false;
    }

    $msg = $err_msg .
        ' in ' . $err_file .
        ' @' . $err_line;

    switch ($err_severity) {
        case E_ERROR:
            $logger->error($msg);
            break;
        case E_WARNING:
            $logger->warning($msg);
            break;
        case E_PARSE:
            $logger->error($msg);
            break;
        case E_NOTICE:
            $logger->warning($msg);
            break;
        case E_CORE_ERROR:
            $logger->error($msg);
            break;
        case E_CORE_WARNING:
            $logger->warning($msg);
            break;
        case E_COMPILE_ERROR:
            $logger->error($msg);
            break;
        case E_COMPILE_WARNING:
            $logger->warning($msg);
            break;
        case E_USER_ERROR:
            $logger->error($msg);
            break;
        case E_USER_WARNING:
            $logger->warning($msg);
            break;
        case E_USER_NOTICE:
            $logger->warning($msg);
            break;
        case E_STRICT:
            $logger->error($msg);
            break;
        case E_RECOVERABLE_ERROR:
            $logger->error($msg);
            break;
        case E_DEPRECATED:
            $logger->error($msg);
            break;
        case E_USER_DEPRECATED:
            $logger->error($msg);
            break;
        default:
            $logger->error($msg);
    }

    throw new ErrorException($err_msg, 0, $err_severity, $err_file, $err_line);

    // se abilitato si deve poi gestire le trow nel codice
    // return true;
});

function VerificoPostazioneById(ResponseInterface $response, $args) {
    if (!is_numeric($args['idPostazione'])) {
        return Web::error400('idPostazione', $response);
    }
    // verifico che id della postazione esiste
    $postazioni = PostazioniQuery::create()
        ->filterByIdPostazione($args['idPostazione'])
        ->count();

    if ($postazioni == 0) {
        return $response->withStatus(404);
    }

    return $response->withStatus(200);
}

function VerificoAssegnamentoById(ResponseInterface $response, $args) {
    if (!is_numeric($args['idAssegnamento'])) {
        return Web::error400('idAssegnamento', $response);
    }

    // verifico che id della postazione esiste
    $assegnamenti = AssegnamentiPostazioneQuery::create()
        ->filterByIdAssegnamentoPostazione($args['idAssegnamento'])
        ->count();

    // se non trovo corrispondenze do un 404
    if ($assegnamenti == 0) {
        return $response->withStatus(404);
    }
    return $response->withStatus(200);
}

function VerificoDisponibilitaById(ResponseInterface $response, $args) {
    if (!is_numeric($args['idDisponibilita'])) {
        return Web::error400('idDisponibilita', $response);
    }
    // verifico che id della postazione esiste
    $disponibilita = DisponibilitaPostazioneQuery::create()
        ->filterByIdDisponibilitaPostazione($args['idDisponibilita'])
        ->count();

    // se non trovo corrispondenze do un 404
    if ($disponibilita == 0) {
        return $response->withStatus(404);
    }

    return $response->withStatus(200);

}

function VerificoClienteById(ResponseInterface $response, $args) {
    if (!is_numeric($args['idCliente'])) {
        return Web::error400('idCliente', $response);
    }

    // verifico che id della postazione esiste
    $Cliente = ClientiQuery::create()
        ->filterByIdCliente($args['idCliente'])
        ->count();

    if ($Cliente == 0) {
        return $response->withStatus(404);
    }

    return $response->withStatus(200);
}
