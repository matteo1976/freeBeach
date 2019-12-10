<?php

namespace swagger;


class Pagamento
{
    /**
     * Id del pagamento.
     * @var integer
     */
    public $idPagamento;

    /**
     * Importo del pagamento.
     * @var float
     */
    public $importo;

    /**
     * Data del pagamento.
     * @var string Data in formato ISO-8601
     */
    public $data;
}
