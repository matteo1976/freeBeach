<?php

use Base\Servizi as BaseServizi;

include_once 'src/swagger/Servizio.php';
include_once 'src/swagger/TipoServizio.php';

/**
 * Skeleton subclass for representing a row from the 'servizi' table.
 *
 *
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 */
class Servizi extends BaseServizi
{

    /**
     * Carica nell'oggetto swagger i dati dei Servizi
     * dall'oggetto restituito da propel
     * @param   object   $value      ChildServizi
     * @return object swagger/Servizio
     */
    public function ToSwagger(): \swagger\Servizio {
        $servizio = new \swagger\Servizio();

        $servizio->idServizio = $this->getIdServizio();
        $servizio->idAssegnamento = $this->getIdAssegnamentoPostazione();
        $servizio->idTipoServizio = $this->getIdTipoServizio();
        $servizio->dataInizio = $this->getDataInizio(\DateTime::ISO8601);
        $servizio->dataFine = $this->getDataFine((\DateTime::ISO8601));
        $servizio->costoFinale = $this->getCostoFinale();
        $servizio->qta = $this->getQta();
        $servizio->note = $this->getNote();
        $servizio->tipoServizio = $this->getTipiServizio()->ToSwagger();

        return $servizio;
   }

}
