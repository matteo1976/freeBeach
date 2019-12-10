<?php

use Base\ProfiliQuery as BaseProfiliQuery;
use \Propel\Runtime\ActiveQuery\Criteria as Criteria;

/**
 * Skeleton subclass for performing query and update operations on the 'profili' table.
 *
 *
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 */
class ProfiliQuery extends BaseProfiliQuery
{

    /**
     * crea tutte le join tra le tabelle
     * profili, privilegi_profili, privilegi
     * e ne estrae i campi di profili e privilegi
     *
     * @see        usePrivilegiProfiloQuery()
     * @see        usePrivilegiQuery()
     * @see        withColumn()
     *
     * @param    $profilo ObjectCollection
     * @param    $joinType  Criteria::INNER_JOIN,LEFT_JOIN,RIGHT_JOIN
     * @param    $relationAlias = null - alias alla relazione

     * @return   ChildAssegnamentiPostazioneQuery
     */
    public static function joinProfili_Privilegi($profilo, $joinType = criteria::INNER_JOIN,
        $relationAlias = null)
    {
        $profilo = $profilo
            ->usePrivilegiProfiloQuery($relationAlias, $joinType)
            ->usePrivilegiQuery($relationAlias, $joinType)
            ->withColumn('privilegi.id_privilegio', 'idPrivilegio')
            ->withColumn('privilegi.descrizione', 'descrizionePrivilegio')
            ->endUse()
            ->endUse();
        return $profilo;

    }

    /**
     * cancella i record di profili e privilegi_profilo
     *
     * @param    $idProfilo INT o ARRAY con gli id dei profili da cancellare

     */
    public static function DeleteProfili($idProfilo)
    {
        //cancello prima il legame con privilegi,profilo
        PrivilegiProfiloQuery::create()
            ->filterByIdProfilo($idProfilo)
            ->delete();
        //cancello i profili
        ProfiliQuery::create()
            ->filterByIdProfilo($idProfilo)
            ->delete();
    }

}
