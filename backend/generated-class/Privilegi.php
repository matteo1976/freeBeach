<?php

use Base\Privilegi as BasePrivilegi;

/**
 * Skeleton subclass for representing a row from the 'privilegi' table.
 *
 *
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 */
class Privilegi extends BasePrivilegi
{
    /**
     * Carica nell'oggetto swagger i dati dei privilegi legati a un profilo
     * dall'oggetto restituito da propel
     * @param object $value Childprivilegi
     * @return \swagger\Privilegio
     */
    public function toSwagger(): swagger\Privilegio {
        $that = new swagger\Privilegio();

        $that->idPrivilegio = $this->getIdPrivilegio();
        $that->descrizione = $this->getDescrizione();

        return $that;
    }
}
