<?php

use Base\CostiServizio as BaseCostiServizio;

include_once 'src/swagger/CostoServizio.php';

/**
 * Skeleton subclass for representing a row from the 'costi_servizio' table.
 *
 *
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 */
class CostiServizio extends BaseCostiServizio
{

    const SW_ID_COSTO = 'idCosto';

    const SW_ID_TIPO_SERVIZIO = 'idTipoServizio';

    const SW_INIZIO_PERIODO = 'inizioPeriodo';

    const SW_FINE_PERIODO = 'finePeriodo';

    const SW_COSTO = 'costo';

    /**
     * Carica nell'oggetto swagger i dati dei Costi dei Servizi
     * dall'oggetto restituito da propel
     * @param   object   $value      ChildCostiServizio
     * @return object swagger/CostoServizio
     */
    public function ToSwagger(): \swagger\CostoServizio {
        $costo = new \swagger\CostoServizio();

        $costo->idCosto = $this->getIdCosto();
        $costo->idTipoServizio = $this->getIdTipoServizio();
        $costo->inizioPeriodo = $this->getInizioPeriodo(\DateTime::ISO8601);
        $costo->finePeriodo = $this->getFinePeriodo(\DateTime::ISO8601);
        $costo->costo = $this->getCosto();

        return $costo;
   }

    public static function FromSwagger($body): CostiServizio {
        $cs = new CostiServizio();

        if (is_int($body[self::SW_ID_COSTO])) {
            $cs->setIdCosto($body[self::SW_ID_COSTO]);
        }

        if (is_int($body[self::SW_ID_TIPO_SERVIZIO])) {
            $cs->setIdTipoServizio($body[self::SW_ID_TIPO_SERVIZIO]);
        }

        if (is_numeric($body[self::SW_COSTO])) {
            $cs->setCosto($body[self::SW_COSTO]);
        }

        if (is_string($body[self::SW_INIZIO_PERIODO])) {
            $cs->setInizioPeriodo($body[self::SW_INIZIO_PERIODO]);
        }

        if (is_string($body[self::SW_FINE_PERIODO])) {
            $cs->setFinePeriodo($body[self::SW_FINE_PERIODO]);
        }

        return $cs;
 }

}
