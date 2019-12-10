<?php

use Base\AssegnamentiPostazioneQuery as BaseAssegnamentiPostazioneQuery;

/**
 * Skeleton subclass for performing query and update operations on the 'assegnamenti_postazione' table.
 *
 *
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 */
class AssegnamentiPostazioneQuery extends BaseAssegnamentiPostazioneQuery
{

    /**
     * cancella record dalla tabella Assegnamenti_postazione usando Id_Assegnamento
     *
     * @see        filterByIdAssegnamentoPostazione()
     *
     * @param     mixed $IdAssegnamento The value to use as filter.
     *              Use array values for in_array() equivalent.
     *
     */
    public static function deleteAssegnamentiById($IdAssegnamento)
    {
        AssegnamentiPostazioneQuery::create()
            ->filterByIdAssegnamentoPostazione($IdAssegnamento)
            ->delete();
    }

    /**
     * cancella record dalla tabella Assegnamenti_postazione usando idPostazione
     *
     * @see        filterByIdPostazione()
     *
     * @param     mixed $idPostazioni The value to use as filter.
     *              Use array values for in_array() equivalent.
     *
     */
    public static function deleteAssegnamentiByIdPostazioni($IdPostazioni)
    {
        AssegnamentiPostazioneQuery::create()
            ->filterByIdPostazione($IdPostazioni)
            ->delete();
    }

    /**
     * cancella record dalla tabella Assegnamenti_postazione usando idCliente
     *
     * @see        filterByIdCliente()
     *
     * @param     mixed $IdCliente The value to use as filter.
     *              Use array values for in_array() equivalent.
     *
     */
    public static function deleteAssegnamentiByIdCliente($IdCliente)
    {
        AssegnamentiPostazioneQuery::create()
            ->filterByIdCliente($IdCliente)
            ->delete();
    }

    /**
     * recupera i valori della PK da Assegnamenti_postazione usando idPostazione
     *
     * @see        filterByIdPostazione()
     *
     * @param     mixed $idPostazioni The value to use as filter.
     *              Use array values for in_array() equivalent.
     * @return array PrimaryKey id_assegnamento_postazione
     */
    public static function getPKFromIdPostazione($IdPostazione)
    {
        $IdAssegnamenti = AssegnamentiPostazioneQuery::create()
            ->filterByIdPostazione($IdPostazione)
            ->find()
            ->getColumnValues();
        return $IdAssegnamenti;
    }

    /**
     * recupera i valori della PK da Assegnamenti_postazione usando idCliente
     *
     * @see        filterByIdXCliente()
     *
     * @param     mixed $IdCliente The value to use as filter.
     *              Use array values for in_array() equivalent.
     * @return array PrimaryKey id_assegnamento_postazione
     */
    public static function getPKFromIdCliente($IdCliente)
    {
        $IdAssegnamenti = AssegnamentiPostazioneQuery::create()
            ->filterByIdCliente($IdCliente)
            ->find()
            ->getColumnValues();
        return $IdAssegnamenti;
    }

}
