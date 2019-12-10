<?php

include_once 'conf/conf_include.php';

use Base\ClientiQuery as BaseClientiQuery;
use \Propel\Runtime\ActiveQuery\Criteria as Criteria;

/**
 * Skeleton subclass for performing query and update operations on the 'clienti' table.
 *
 *
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 */
class ClientiQuery extends BaseClientiQuery
{

    public static function joinAccount_Privilegi($cliente, $chiaveRicerca = '%',
        $joinType = criteria::INNER_JOIN, $relationAlias = null)
    {
        $cliente = $cliente
            ->useAccountQuery()
            ->orderByNome()
            ->filterByNome($chiaveRicerca, Criteria::LIKE)
            ->_or()
            ->filterByEmail($chiaveRicerca, Criteria::LIKE)
            ->withColumn('account.nome', 'Nome')
            ->withColumn('account.email', 'Email')
            ->withColumn('account.indirizzo', 'Indirizzo')
            ->withColumn('account.telefono', 'Telefono')
            ->withColumn('account.abilitato', 'Abilitato')
            ->useProfiliQuery()
            ->withColumn('profili.id_profilo', 'IdProfilo')
            ->withColumn('profili.descrizione', 'DescrizioneProfilo')
            ->usePrivilegiProfiloQuery()
            ->usePrivilegiQuery()
            ->withColumn('privilegi.id_privilegio', 'idPrivilegio')
            ->withColumn('privilegi.descrizione', 'descrizionePrivilegio')
            ->endUse()
            ->endUse()
            ->endUse()
            ->endUse();
        return $cliente;
}

    public static function joinAssegnamentiPostazione_Subaffitto($cliente,
        $joinType = criteria::INNER_JOIN, $relationAlias = null)
    {
        $cliente = $cliente
            ->useAssegnamentiPostazioneQuery($relationAlias, $joinType)
            ->withColumn('assegnamenti_postazione.id_assegnamento_postazione', 'IdAssegnamento')
            ->withColumn('assegnamenti_postazione.data_inizio', 'Assegato_Dal')
            ->withColumn('assegnamenti_postazione.data_fine', 'Assegnato_Al')
            ->withColumn('assegnamenti_postazione.note', 'note')
            ->useDisponibilitaPostazioneQuery($relationAlias, $joinType)
            ->withColumn('disponibilita_postazione.id_disponibilita_postazione', 'id_disponibilita')
            ->withColumn('disponibilita_postazione.data_inizio', 'disponibile_da')
            ->withColumn('disponibilita_postazione.data_fine', 'disponibile_a')
            ->useSubaffittiPostazioneQuery($relationAlias, $joinType)
            ->withColumn('subaffitti_postazione.id_subaffitto_postazione', 'id_subaffitto')
            ->withColumn('subaffitti_postazione.data_inizio', 'subaffitto_dal')
            ->withColumn('subaffitti_postazione.data_fine', 'subaffitto_al')
            ->endUse()
            ->endUse()
            ->endUse();
        return $cliente;
    }

}
