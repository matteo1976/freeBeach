<?php

use Base\ServiziQuery as BaseServiziQuery;
use \Propel\Runtime\ActiveQuery\Criteria as Criteria;

/**
 * Skeleton subclass for performing query and update operations on the 'servizi' table.
 *
 *
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 */
class ServiziQuery extends BaseServiziQuery
{

    /**
     * cancella record dalla tabella servizi
     *
     * Example usage:
     * <code>
     * </code>
     *
     * @see       filterByIdServizio()
     *
     * @param     mixed $idServizi The value to use as filter.
     *              Use array values for in_array() equivalent.
     *
     */
    public static function DeleteServiziById($idServizi)
    {
        ServiziQuery::create()
            ->filterByIdServizio($idServizi)
            ->delete();
    }

    /**
     * cancella record dalla tabella servizi usando idPostazione
     *
     * @see        filterByIdServizio()
     *
     * @param     mixed $idPostazioni The value to use as filter.
     *              Use array values for in_array() equivalent.
     *
     */
    public static function DeleteServiziByIdPostazioni($idPostazioni)
    {
        ServiziQuery::create()
            ->filterByIdServizio($idPostazioni)
            ->delete();
    }

    /**
     * crea tutte le join tra le tabelle
     * servizi, tipi_servizio,costi_servizio
     * e ne estrae i campi
     *
     * @see        useServiziQuery()
     * @see        useTipiServizioQuery()
     * @see        useCostiServizioQuery()
     * @see        withColumn()
     *
     * @param    $servizio ObjectCollection
     * @param    $joinType  Criteria::INNER_JOIN,LEFT_JOIN,RIGHT_JOIN
     * @param    $relationAlias = null - alias alla relazione

     * @return   ChildAssegnamentiSeviziQuery
     */
    public static function joinServizi_CostiServizio($servizio, $joinType = Criteria::INNER_JOIN,
        $relationAlias = null)
    {
        $servizio = $servizio
            ->useServiziQuery()
            ->withColumn('servizi.id_servizio', 'id_servizio')
            ->withColumn('servizi.data_inizio', 'servizio_dal')
            ->withColumn('servizi.data_fine', 'servizio_al')
            ->withColumn('servizi.qta', 'qta')
            ->withColumn('servizi.costo_finale', 'costo_finale')
            ->withColumn('servizi.note', 'note')
            ->useTipiServizioQuery()
            ->withColumn('tipi_servizio.id_tipo_servizio', 'IdTipoServizio')
            ->withColumn('tipi_servizio.descrizione', 'DescrizioneTipoServizio')
            /* ->useCostiServizioQuery()
              ->withColumn('costi_servizio.id_costo','id_costo')
              ->withColumn('costi_servizio.inizio_periodo','costo_dal')
              ->withColumn('costi_servizio.fine_periodo','costo_al')
              ->withColumn('costi_servizio.costo','costo_unitario')
              ->endUse() */
            ->endUse()
            ->endUse();
        return $servizio;
    }

}
