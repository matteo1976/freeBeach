<?php

use Base\Schede as BaseSchede;

/**
 * Skeleton subclass for representing a row from the 'schede' table.
 *
 *
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 */
class Schede extends BaseSchede
{
    /**
     * Carica nell'oggetto swagger i dati delle schede cliente
     * dall'oggetto restituito da propel
     * @param \Schede $this
     * @return \swagger\Scheda
     **/
    public function toSwagger() : swagger\Scheda {
        $that = new swagger\Scheda();

        $that->id = $this->getIdScheda();
        //$that->idCliente = $scheda->getIdCliente();
        $that->codice = $this->getCodiceScheda();
        $that->importo = $this->getImportoScheda();
        $that->dataRilascio = $this->getDataRilascio(\DateTime::ISO8601);

        return $that;
    }
}
