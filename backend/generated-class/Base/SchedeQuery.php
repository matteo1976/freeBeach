<?php

namespace Base;

use \Schede as ChildSchede;
use \SchedeQuery as ChildSchedeQuery;
use \Exception;
use \PDO;
use Map\SchedeTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'schede' table.
 *
 *
 *
 * @method     ChildSchedeQuery orderByIdScheda($order = Criteria::ASC) Order by the id_scheda column
 * @method     ChildSchedeQuery orderByIdCliente($order = Criteria::ASC) Order by the id_cliente column
 * @method     ChildSchedeQuery orderByCodiceScheda($order = Criteria::ASC) Order by the codice_scheda column
 * @method     ChildSchedeQuery orderByImportoScheda($order = Criteria::ASC) Order by the importo_scheda column
 * @method     ChildSchedeQuery orderByDataRilascio($order = Criteria::ASC) Order by the data_rilascio column
 *
 * @method     ChildSchedeQuery groupByIdScheda() Group by the id_scheda column
 * @method     ChildSchedeQuery groupByIdCliente() Group by the id_cliente column
 * @method     ChildSchedeQuery groupByCodiceScheda() Group by the codice_scheda column
 * @method     ChildSchedeQuery groupByImportoScheda() Group by the importo_scheda column
 * @method     ChildSchedeQuery groupByDataRilascio() Group by the data_rilascio column
 *
 * @method     ChildSchedeQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildSchedeQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildSchedeQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildSchedeQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildSchedeQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildSchedeQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildSchedeQuery leftJoinClienti($relationAlias = null) Adds a LEFT JOIN clause to the query using the Clienti relation
 * @method     ChildSchedeQuery rightJoinClienti($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Clienti relation
 * @method     ChildSchedeQuery innerJoinClienti($relationAlias = null) Adds a INNER JOIN clause to the query using the Clienti relation
 *
 * @method     ChildSchedeQuery joinWithClienti($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Clienti relation
 *
 * @method     ChildSchedeQuery leftJoinWithClienti() Adds a LEFT JOIN clause and with to the query using the Clienti relation
 * @method     ChildSchedeQuery rightJoinWithClienti() Adds a RIGHT JOIN clause and with to the query using the Clienti relation
 * @method     ChildSchedeQuery innerJoinWithClienti() Adds a INNER JOIN clause and with to the query using the Clienti relation
 *
 * @method     \ClientiQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildSchede findOne(ConnectionInterface $con = null) Return the first ChildSchede matching the query
 * @method     ChildSchede findOneOrCreate(ConnectionInterface $con = null) Return the first ChildSchede matching the query, or a new ChildSchede object populated from the query conditions when no match is found
 *
 * @method     ChildSchede findOneByIdScheda(int $id_scheda) Return the first ChildSchede filtered by the id_scheda column
 * @method     ChildSchede findOneByIdCliente(int $id_cliente) Return the first ChildSchede filtered by the id_cliente column
 * @method     ChildSchede findOneByCodiceScheda(string $codice_scheda) Return the first ChildSchede filtered by the codice_scheda column
 * @method     ChildSchede findOneByImportoScheda(double $importo_scheda) Return the first ChildSchede filtered by the importo_scheda column
 * @method     ChildSchede findOneByDataRilascio(string $data_rilascio) Return the first ChildSchede filtered by the data_rilascio column *

 * @method     ChildSchede requirePk($key, ConnectionInterface $con = null) Return the ChildSchede by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSchede requireOne(ConnectionInterface $con = null) Return the first ChildSchede matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildSchede requireOneByIdScheda(int $id_scheda) Return the first ChildSchede filtered by the id_scheda column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSchede requireOneByIdCliente(int $id_cliente) Return the first ChildSchede filtered by the id_cliente column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSchede requireOneByCodiceScheda(string $codice_scheda) Return the first ChildSchede filtered by the codice_scheda column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSchede requireOneByImportoScheda(double $importo_scheda) Return the first ChildSchede filtered by the importo_scheda column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSchede requireOneByDataRilascio(string $data_rilascio) Return the first ChildSchede filtered by the data_rilascio column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildSchede[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildSchede objects based on current ModelCriteria
 * @method     ChildSchede[]|ObjectCollection findByIdScheda(int $id_scheda) Return ChildSchede objects filtered by the id_scheda column
 * @method     ChildSchede[]|ObjectCollection findByIdCliente(int $id_cliente) Return ChildSchede objects filtered by the id_cliente column
 * @method     ChildSchede[]|ObjectCollection findByCodiceScheda(string $codice_scheda) Return ChildSchede objects filtered by the codice_scheda column
 * @method     ChildSchede[]|ObjectCollection findByImportoScheda(double $importo_scheda) Return ChildSchede objects filtered by the importo_scheda column
 * @method     ChildSchede[]|ObjectCollection findByDataRilascio(string $data_rilascio) Return ChildSchede objects filtered by the data_rilascio column
 * @method     ChildSchede[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class SchedeQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\SchedeQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'dbspiaggie', $modelName = '\\Schede', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildSchedeQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildSchedeQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildSchedeQuery) {
            return $criteria;
        }
        $query = new ChildSchedeQuery();
        if (null !== $modelAlias) {
            $query->setModelAlias($modelAlias);
        }
        if ($criteria instanceof Criteria) {
            $query->mergeWith($criteria);
        }

        return $query;
    }

    /**
     * Find object by primary key.
     * Propel uses the instance pool to skip the database if the object exists.
     * Go fast if the query is untouched.
     *
     * <code>
     * $obj  = $c->findPk(12, $con);
     * </code>
     *
     * @param mixed $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildSchede|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(SchedeTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = SchedeTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
            // the object is already in the instance pool
            return $obj;
        }

        return $this->findPkSimple($key, $con);
    }

    /**
     * Find object by primary key using raw SQL to go fast.
     * Bypass doSelect() and the object formatter by using generated code.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildSchede A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id_scheda, id_cliente, codice_scheda, importo_scheda, data_rilascio FROM schede WHERE id_scheda = :p0';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key, PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            /** @var ChildSchede $obj */
            $obj = new ChildSchede();
            $obj->hydrate($row);
            SchedeTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
        }
        $stmt->closeCursor();

        return $obj;
    }

    /**
     * Find object by primary key.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @return ChildSchede|array|mixed the result, formatted by the current formatter
     */
    protected function findPkComplex($key, ConnectionInterface $con)
    {
        // As the query uses a PK condition, no limit(1) is necessary.
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKey($key)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->formatOne($dataFetcher);
    }

    /**
     * Find objects by primary key
     * <code>
     * $objs = $c->findPks(array(12, 56, 832), $con);
     * </code>
     * @param     array $keys Primary keys to use for the query
     * @param     ConnectionInterface $con an optional connection object
     *
     * @return ObjectCollection|array|mixed the list of results, formatted by the current formatter
     */
    public function findPks($keys, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getReadConnection($this->getDbName());
        }
        $this->basePreSelect($con);
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKeys($keys)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->format($dataFetcher);
    }

    /**
     * Filter the query by primary key
     *
     * @param     mixed $key Primary key to use for the query
     *
     * @return $this|ChildSchedeQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(SchedeTableMap::COL_ID_SCHEDA, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildSchedeQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(SchedeTableMap::COL_ID_SCHEDA, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the id_scheda column
     *
     * Example usage:
     * <code>
     * $query->filterByIdScheda(1234); // WHERE id_scheda = 1234
     * $query->filterByIdScheda(array(12, 34)); // WHERE id_scheda IN (12, 34)
     * $query->filterByIdScheda(array('min' => 12)); // WHERE id_scheda > 12
     * </code>
     *
     * @param     mixed $idScheda The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSchedeQuery The current query, for fluid interface
     */
    public function filterByIdScheda($idScheda = null, $comparison = null)
    {
        if (is_array($idScheda)) {
            $useMinMax = false;
            if (isset($idScheda['min'])) {
                $this->addUsingAlias(SchedeTableMap::COL_ID_SCHEDA, $idScheda['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($idScheda['max'])) {
                $this->addUsingAlias(SchedeTableMap::COL_ID_SCHEDA, $idScheda['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SchedeTableMap::COL_ID_SCHEDA, $idScheda, $comparison);
    }

    /**
     * Filter the query on the id_cliente column
     *
     * Example usage:
     * <code>
     * $query->filterByIdCliente(1234); // WHERE id_cliente = 1234
     * $query->filterByIdCliente(array(12, 34)); // WHERE id_cliente IN (12, 34)
     * $query->filterByIdCliente(array('min' => 12)); // WHERE id_cliente > 12
     * </code>
     *
     * @see       filterByClienti()
     *
     * @param     mixed $idCliente The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSchedeQuery The current query, for fluid interface
     */
    public function filterByIdCliente($idCliente = null, $comparison = null)
    {
        if (is_array($idCliente)) {
            $useMinMax = false;
            if (isset($idCliente['min'])) {
                $this->addUsingAlias(SchedeTableMap::COL_ID_CLIENTE, $idCliente['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($idCliente['max'])) {
                $this->addUsingAlias(SchedeTableMap::COL_ID_CLIENTE, $idCliente['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SchedeTableMap::COL_ID_CLIENTE, $idCliente, $comparison);
    }

    /**
     * Filter the query on the codice_scheda column
     *
     * Example usage:
     * <code>
     * $query->filterByCodiceScheda('fooValue');   // WHERE codice_scheda = 'fooValue'
     * $query->filterByCodiceScheda('%fooValue%', Criteria::LIKE); // WHERE codice_scheda LIKE '%fooValue%'
     * </code>
     *
     * @param     string $codiceScheda The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSchedeQuery The current query, for fluid interface
     */
    public function filterByCodiceScheda($codiceScheda = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($codiceScheda)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SchedeTableMap::COL_CODICE_SCHEDA, $codiceScheda, $comparison);
    }

    /**
     * Filter the query on the importo_scheda column
     *
     * Example usage:
     * <code>
     * $query->filterByImportoScheda(1234); // WHERE importo_scheda = 1234
     * $query->filterByImportoScheda(array(12, 34)); // WHERE importo_scheda IN (12, 34)
     * $query->filterByImportoScheda(array('min' => 12)); // WHERE importo_scheda > 12
     * </code>
     *
     * @param     mixed $importoScheda The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSchedeQuery The current query, for fluid interface
     */
    public function filterByImportoScheda($importoScheda = null, $comparison = null)
    {
        if (is_array($importoScheda)) {
            $useMinMax = false;
            if (isset($importoScheda['min'])) {
                $this->addUsingAlias(SchedeTableMap::COL_IMPORTO_SCHEDA, $importoScheda['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($importoScheda['max'])) {
                $this->addUsingAlias(SchedeTableMap::COL_IMPORTO_SCHEDA, $importoScheda['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SchedeTableMap::COL_IMPORTO_SCHEDA, $importoScheda, $comparison);
    }

    /**
     * Filter the query on the data_rilascio column
     *
     * Example usage:
     * <code>
     * $query->filterByDataRilascio('2011-03-14'); // WHERE data_rilascio = '2011-03-14'
     * $query->filterByDataRilascio('now'); // WHERE data_rilascio = '2011-03-14'
     * $query->filterByDataRilascio(array('max' => 'yesterday')); // WHERE data_rilascio > '2011-03-13'
     * </code>
     *
     * @param     mixed $dataRilascio The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSchedeQuery The current query, for fluid interface
     */
    public function filterByDataRilascio($dataRilascio = null, $comparison = null)
    {
        if (is_array($dataRilascio)) {
            $useMinMax = false;
            if (isset($dataRilascio['min'])) {
                $this->addUsingAlias(SchedeTableMap::COL_DATA_RILASCIO, $dataRilascio['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($dataRilascio['max'])) {
                $this->addUsingAlias(SchedeTableMap::COL_DATA_RILASCIO, $dataRilascio['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SchedeTableMap::COL_DATA_RILASCIO, $dataRilascio, $comparison);
    }

    /**
     * Filter the query by a related \Clienti object
     *
     * @param \Clienti|ObjectCollection $clienti The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildSchedeQuery The current query, for fluid interface
     */
    public function filterByClienti($clienti, $comparison = null)
    {
        if ($clienti instanceof \Clienti) {
            return $this
                ->addUsingAlias(SchedeTableMap::COL_ID_CLIENTE, $clienti->getIdCliente(), $comparison);
        } elseif ($clienti instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(SchedeTableMap::COL_ID_CLIENTE, $clienti->toKeyValue('PrimaryKey', 'IdCliente'), $comparison);
        } else {
            throw new PropelException('filterByClienti() only accepts arguments of type \Clienti or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Clienti relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildSchedeQuery The current query, for fluid interface
     */
    public function joinClienti($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Clienti');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'Clienti');
        }

        return $this;
    }

    /**
     * Use the Clienti relation Clienti object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \ClientiQuery A secondary query class using the current class as primary query
     */
    public function useClientiQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinClienti($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Clienti', '\ClientiQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildSchede $schede Object to remove from the list of results
     *
     * @return $this|ChildSchedeQuery The current query, for fluid interface
     */
    public function prune($schede = null)
    {
        if ($schede) {
            $this->addUsingAlias(SchedeTableMap::COL_ID_SCHEDA, $schede->getIdScheda(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the schede table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(SchedeTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            SchedeTableMap::clearInstancePool();
            SchedeTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

    /**
     * Performs a DELETE on the database based on the current ModelCriteria
     *
     * @param ConnectionInterface $con the connection to use
     * @return int             The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                         if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public function delete(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(SchedeTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(SchedeTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            SchedeTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            SchedeTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // SchedeQuery
