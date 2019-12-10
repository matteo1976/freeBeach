<?php

namespace swagger;


class Operatore
{

    /**
     * Id dell'operatore
     * @var int
     */
    public $idOperatore;

    /**
     * Nome dell'operatore.
     * @var string
     */
    public $nome;

    /**
     * Indirizzo dell'operatore
     * @var string
     */
    public $indirizzo;

    /**
     * Email dell'operatore
     * @var string
     */
    public $email;

    /**
     * Password dell'operatore
     * @var string
     */
    public $password;

    /**
     * Telefono dell'operatore
     * @var string
     */
    public $telefono;

    /**
     * Operatore abilitato / diasbilitato
     * @var boolean
     */
    public $abilitato;

    /**
     * Profilo funzionale associato all'operatore
     * @var swagger\Profilo
     */
    public $profilo;
}
