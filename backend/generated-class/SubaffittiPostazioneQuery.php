<?php

use Base\SubaffittiPostazioneQuery as BaseSubaffittiPostazioneQuery;

/**
 * Skeleton subclass for performing query and update operations on the 'subaffitti_postazione' table.
 *
 *
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 */
class SubaffittiPostazioneQuery extends BaseSubaffittiPostazioneQuery
{
    /**
     * recupera i valori della PK da subaffitti_postazione
     * usando la FK id_disponibilita_postazioni
     *
     *
     * @see        filterByIdDisponibilitaPostazioni()
     *
     * @param     mixed $IdDisponibilita The value to use as filter.
     *              Use array values for in_array() equivalent.
     * @return array, int, PrimaryKey id_disponibilita_postazione
     */
    public static function getPKFromIdDisponibilita($IdDisponibilita)
    {
        $IdSubaffitti = SubaffittiPostazioneQuery::create()
            ->filterByIdDisponibilitaPostazioni($IdDisponibilita)
            ->find()
            ->getColumnValues();
        return $IdSubaffitti;
    }

    /**
     * cancella record dalla tabella subaffitti_postazione
     *  usando la sua PK id_subaffitto_postazione
     *
     * @see        filterByIdAssegnamentoPostazione()
     *
     * @param     mixed $IdSubaffitto The value to use as filter.
     *              Use array values for in_array() equivalent.
     *
     */
    public static function deleteSubaffittiById($IdSubaffitto)
    {
        SubaffittiPostazioneQuery::create()
            ->filterByIdSubaffittoPostazione($IdSubaffitto)
            ->delete();
    }

    /**
     * cancella record dalla tabella subaffitti_postazione
     *  usando la FK Id_disponibilta_postazione
     *
     * @see        filterByIdPostazione()
     *
     * @param     mixed $IdDisponibilita The value to use as filter.
     *              Use array values for in_array() equivalent.
     *
     */
    public static function deleteSubaffittiByIdDisponibilita($IdDisponibilita)
    {
        SubaffittiPostazioneQuery::create()
            ->filterByIdDisponibilitaPostazioni($IdDisponibilita)
            ->delete();
    }

}
