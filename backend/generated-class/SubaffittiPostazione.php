<?php

use Base\SubaffittiPostazione as BaseSubaffittiPostazione;

require_once 'src/swagger/SubaffittoPostazione.php';

/**
 * Skeleton subclass for representing a row from the 'subaffitti_postazione' table.
 *
 *
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 */
class SubaffittiPostazione extends BaseSubaffittiPostazione
{

    /**
     * Carica nell'oggetto swagger i dati dei subaffitti
     * dall'oggetto restituito da propel
     * @param object $value ChildSubaffittiPostazione
     * @return swagger/object SubaffittoPostazione
     */
    public function toSwagger(): \swagger\SubaffittoPostazione {
        $subAffitto = new \swagger\SubaffittoPostazione;

        $subAffitto->idSubaffitto = $this->getIdSubaffittoPostazione();
        $subAffitto->dataInizio = $this->getDataInizio(\DateTime::ISO8601);
        $subAffitto->dataFine = $this->getDataFine(\DateTime::ISO8601);

        return $subAffitto;
    }
}
