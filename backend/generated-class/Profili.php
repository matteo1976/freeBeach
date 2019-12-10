<?php

use Base\Profili as BaseProfili;

require_once 'src/swagger/Privilegio.php';


/**
 * Skeleton subclass for representing a row from the 'profili' table.
 *
 *
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 */
class Profili extends BaseProfili
{
    /**
     * Carica nell'oggetto swagger i dati dei profili
     * dall'oggetto restituito da propel
     * @param object $value ChildProfili
     * @return \swagger\Profilo
     */
    public function toSwagger() : swagger\Profilo {
        $result = new swagger\Profilo();

        $result->idProfilo = $this->getIdProfilo();
        $result->descrizione = $this->getDescrizione();

        foreach ($this->getPrivilegiProfilos() as $privilegio) {
            $result->privilegi[] = $privilegio->getPrivilegi()->toSwagger();
        }

        return $result;
    }
}
