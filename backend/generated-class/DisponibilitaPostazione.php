<?php

use Base\DisponibilitaPostazione as BaseDisponibilitaPostazione;

include_once 'src/swagger/SubaffittoPostazione.php';

/**
 * Skeleton subclass for representing a row from the 'disponibilita_postazione' table.
 *
 *
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 */
class DisponibilitaPostazione extends BaseDisponibilitaPostazione
{

    /**
     * Carica nell'oggetto swagger i dati delle disponibilita
     * dall'oggetto restituito da propel
     * @param object $this ChildDisponibilitaPostazione
     * @return swagger/object DisponibilitaPostazione
     */
    public function toSwagger(): swagger\DisponibilitaPostazione {
        $disponibilita = new swagger\DisponibilitaPostazione();

        $disponibilita->idDisponibilita = $this->getIdDisponibilitaPostazione();
        $disponibilita->dataInizio = $this->getDataInizio(\DateTime::ISO8601);
        $disponibilita->dataFine = $this->getDataFine(\DateTime::ISO8601);

        foreach ($this->getSubaffittiPostaziones() as $sub) {
            $disponibilita->subaffitti = $sub->toSwagger();
        }

        return $disponibilita;
    }

}
