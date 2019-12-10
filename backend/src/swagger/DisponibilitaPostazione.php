<?php

namespace swagger;

class DisponibilitaPostazione
{
    /**
     * Id della disponibilita
     * @var integer iddisponibilita
     */
    public $idDisponibilita;

    /**
     * Data inizio periodo di disponibilita
     * @var DataTime dataInizio
     */
    public $dataInizio;

    /**
     * Data fine periodo di disponibilita
     * @var DataTime dataFine
     */
    public $dataFine;

    /**
     * Subaffitti delle postazioni liberate dal cliente abilitato
     * @var object swagger/SubaffittoPostazione
     */
    public $subaffitti;

}
