<?php

use Base\TipiServizio as BaseTipiServizio;
use Propel\Runtime\ActiveQuery\Criteria;

include_once 'src/swagger/TipoServizio.php';
include_once 'src/swagger/CostoServizio.php';

/**
 * Skeleton subclass for representing a row from the 'tipi_servizio' table.
 *
 *
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 */
class TipiServizio extends BaseTipiServizio
{
    const SW_ID_TIPO_SERVIZIO = 'idTipoServizio';

    const SW_DESCRIZIONE = 'descrizione';

    const SW_COSTO = 'costo';

    /**
     * Carica nell'oggetto swagger i dati dei Tipo dei Servizi
     * dall'oggetto restituito da propel
     * @param   object   $value      ChildTipiServizio
     * @return object swagger/TipiServizio
     */
    public function ToSwagger($filtroDati): \swagger\TipoServizio {
        $tipo = new \swagger\TipoServizio();

        $tipo->idTipoServizio = $this->getIdTipoServizio();
        $tipo->descrizione = $this->getDescrizione();

        $criteriaCosti = null;
        if ($filtroDati !== null) {
            $criteriaCosti = new Criteria(Base\CostiServizio::TABLE_MAP);
            $criteriaCosti->add(Map\CostiServizioTableMap::COL_FINE_PERIODO, $filtroDati,
                Criteria::GREATER_EQUAL);
            $criteriaCosti->addAscendingOrderByColumn(Map\CostiServizioTableMap::COL_INIZIO_PERIODO);
        }

        foreach ($this->getCostiServizios($criteriaCosti) as $costo) {
            $tipo->costo[] = $costo->ToSwagger();
        }

        return $tipo;
   }

    public function FromSwagger($body) {
        if (is_int($body[self::SW_ID_TIPO_SERVIZIO])) {
            $this->setIdTipoServizio($body[self::SW_ID_TIPO_SERVIZIO]);
        }

        if (is_string($body[self::SW_DESCRIZIONE])) {
            $this->setDescrizione($body[self::SW_DESCRIZIONE]);
        }

//        if (!empty($body[self::SW_COSTO]) && is_array($body[self::SW_COSTO])) {
//            foreach ($body[self::SW_COSTO] as $cs) {
//                $costo = CostiServizio::FromSwagger($cs);
//                $this->addCostiServizio($costo);
//            }
//        }
    }

}
