<?php

namespace swagger;

class Scheda
{

    /**
     * Id della scheda.
     * @var integer
     */
    public $idScheda;

    /**
     * Id del cliente
     * @var integer
     */
    public $idCliente;

    /**
     * Codice della scheda.
     * @var string
     */
    public $codice;

    /**
     * Importo della scheda.
     * @var float
     */
    public $importo;

    /**
     * Data di rilascio della scheda.
     * @var string Data in formato ISO-8601
     */
    public $dataRilascio;
}
