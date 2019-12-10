<?php

use Base\DisponibilitaPostazioneQuery as BaseDisponibilitaPostazioneQuery;

/**
 * Skeleton subclass for performing query and update operations on the 'disponibilita_postazione' table.
 *
 *
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 */
class DisponibilitaPostazioneQuery extends BaseDisponibilitaPostazioneQuery
{

    /**
     * recupera i valori della PK da disponibilita_postazione
     * usando la FK id_assegnamenti_postazione
     *
     *
     * @see        filterByIdAssegnamentoPostazione()
     *
     * @param     mixed $idAssegnamento The value to use as filter.
     *              Use array values for in_array() equivalent.
     * @return array, int, PrimaryKey id_disponibilita_postazione
     */
    public static function getPKFromIdAssegnamento($idAssegnamento)
    {
        $IdAssegnamenti = DisponibilitaPostazioneQuery::create()
            ->filterByIdAssegnamentoPostazione($idAssegnamento)
            ->find()
            ->getColumnValues();
        return $IdAssegnamenti;
    }

    /**
     * cancella record dalla tabella disponibilita_postazione usando Id_Assegnamento
     *
     * @see        filterByIdAssegnamentoPostazione()
     *
     * @param     mixed $IdAssegnamento The value to use as filter.
     *              Use array values for in_array() equivalent.
     *
     */
    public static function deleteDisponibilitaById($IdDisponibilita)
    {
        DisponibilitaPostazioneQuery::create()
            ->filterByIdDisponibilitaPostazione($IdDisponibilita)
            ->delete();
    }

    /**
     * cancella record dalla tabella disponibilita_postazione
     *  usando la pk Id_disponibilta_postazione
     *
     * @see        filterByIdPostazione()
     *
     * @param     mixed $IdDisponibilita The value to use as filter.
     *              Use array values for in_array() equivalent.
     *
     */
    public static function deleteDisponibilitaByIdAssegnamento($IdAssegnamento)
    {
        DisponibilitaPostazioneQuery::create()
            ->filterByIdDisponibilitaPostazione($IdAssegnamento)
            ->delete();
    }

}
