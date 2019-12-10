<?php

namespace swagger;

require_once 'src/swagger/AssegnamentoPostazione.php';
require_once 'src/swagger/Servizio.php';

/**
 * Description of Servizio
 *
 * @author matteo
 */
class Servizio
{

    public $idServizio;

    public $idAssegnamento;

    public $idTipoServizio;

    public $dataInizio;

    public $dataFine;

    public $qta;

    public $costoFinale;

    public $note;

    public $tipoServizio;

}
