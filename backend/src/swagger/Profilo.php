<?php

namespace swagger;

class Profilo
{
    /**
     * Identificativo del profilo
     * @var int
     */
    public $idProfilo;

    /**
     * Descrizione del profilo
     * @var string
     */
    public $descrizione;

    /**
     * Privilegi associati al profilo
     * @var Array Array di oggetti swagger\Privilegio
     */
    public $privilegi;
}

