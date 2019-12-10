<?php

use Base\Abbonamenti as BaseAbbonamenti;

require_once 'src/swagger/Abbonamento.php';


/**
 * Skeleton subclass for representing a row from the 'abbonamenti' table.
 *
 *
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 */
class Abbonamenti extends BaseAbbonamenti
{
    /**
     * Converte l'oggetto Abbonamenti restituito da Propel
     * nel formato previsto dall'API.
     * @param \Abbonamenti $this
     * @return \swagger\Abbonamento
     */
    public function toSwagger(): swagger\Abbonamento {
        $result = new swagger\Abbonamento();

        $result->idAbbonamento = $this->getIdAbbonamento();
        $result->codice = $this->getCodice();
        $result->costo = $this->getCosto();

        return $result;
    }

}
