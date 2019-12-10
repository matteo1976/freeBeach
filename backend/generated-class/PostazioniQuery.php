<?php

use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Base\PostazioniQuery as BasePostazioniQuery;

/**
 * Skeleton subclass for performing query and update operations on the 'postazioni' table.
 *
 *
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 */
class PostazioniQuery extends BasePostazioniQuery
{

    /**
     * Restituisce la lista delle postazioni disponibili nel periodo indicato.
     * Attualmente la funzione ha queste limitazioni:
     * - riconosce come disponibili le postazioni che nel periodo non hanno assegnamenti
     * - cioè non riconosce le disponibilità parziali
     * - non riconosce la postazione come occupata se ci sono più assegnamenti che saturano
     *   la disponibilità richiesta.
     * @param DateTime $inizio  Inizio della disponibilità richiesta
     * @param DateTime $fine    Fine della disponibilità richiesta
     * @return Array            Un array di oggetti Postazione
     */
    public function findByDisponibilita(DateTime $inizio, DateTime $fine) {


        /*
          $conn = Propel::getConnection();
          $conn->useDebug(true);

          // TODO: implementare le verifiche per gli altri casi

          $sql = 'select * from postazioni where id_postazione not in ('
          . ' select distinct id_postazione from assegnamenti_postazione'
          . ' where data_inizio >= :inizio_disp and :fine_disp <= data_fine'
          . ')';

          $params = array(
          ':inizio_disp' => $inizio,
          ':fine_disp ' => $fine,
          );

          $stmt = $conn->prepare($sql);
          $stmt->execute($params);

          $formatter = new ObjectFormatter();
          $formatter->setClass('\Postazioni'); //full qualified class name

          $results = $formatter->format($conn->getDataFetcher($stmt));
         *
         */

        $results = PostazioniQuery::create()
            ->filterByIdPostazione(20, Criteria::LESS_EQUAL)
            ->orderByY()
            ->orderByX()
            ->find();


        return $results;
    }

}
