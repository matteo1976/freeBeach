<?php

namespace Base;

use \Abbonamenti as ChildAbbonamenti;
use \AbbonamentiQuery as ChildAbbonamentiQuery;
use \Exception;
use \PDO;
use Map\AbbonamentiTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'abbonamenti' table.
 *
 *
 *
 * @method     ChildAbbonamentiQuery orderByIdAbbonamento($order = Criteria::ASC) Order by the id_abbonamento column
 * @method     ChildAbbonamentiQuery orderByCodice($order = Criteria::ASC) Order by the codice column
 * @method     ChildAbbonamentiQuery orderByCosto($order = Criteria::ASC) Order by the costo column
 *
 * @method     ChildAbbonamentiQuery groupByIdAbbonamento() Group by the id_abbonamento column
 * @method     ChildAbbonamentiQuery groupByCodice() Group by the codice column
 * @method     ChildAbbonamentiQuery groupByCosto() Group by the costo column
 *
 * @method     ChildAbbonamentiQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildAbbonamentiQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildAbbonamentiQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildAbbonamentiQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildAbbonamentiQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildAbbonamentiQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildAbbonamentiQuery leftJoinAssegnamentiPostazione($relationAlias = null) Adds a LEFT JOIN clause to the query using the AssegnamentiPostazione relation
 * @method     ChildAbbonamentiQuery rightJoinAssegnamentiPostazione($relationAlias = null) Adds a RIGHT JOIN clause to the query using the AssegnamentiPostazione relation
 * @method     ChildAbbonamentiQuery innerJoinAssegnamentiPostazione($relationAlias = null) Adds a INNER JOIN clause to the query using the AssegnamentiPostazione relation
 *
 * @method     ChildAbbonamentiQuery joinWithAssegnamentiPostazione($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the AssegnamentiPostazione relation
 *
 * @method     ChildAbbonamentiQuery leftJoinWithAssegnamentiPostazione() Adds a LEFT JOIN clause and with to the query using the AssegnamentiPostazione relation
 * @method     ChildAbbonamentiQuery rightJoinWithAssegnamentiPostazione() Adds a RIGHT JOIN clause and with to the query using the AssegnamentiPostazione relation
 * @method     ChildAbbonamentiQuery innerJoinWithAssegnamentiPostazione() Adds a INNER JOIN clause and with to the query using the AssegnamentiPostazione relation
 *
 * @method     \AssegnamentiPostazioneQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildAbbonamenti findOne(ConnectionInterface $con = null) Return the first ChildAbbonamenti matching the query
 * @method     ChildAbbonamenti findOneOrCreate(ConnectionInterface $con = null) Return the first ChildAbbonamenti matching the query, or a new ChildAbbonamenti object populated from the query conditions when no match is found
 *
 * @method     ChildAbbonamenti findOneByIdAbbonamento(int $id_abbonamento) Return the first ChildAbbonamenti filtered by the id_abbonamento column
 * @method     ChildAbbonamenti findOneByCodice(string $codice) Return the first ChildAbbonamenti filtered by the codice column
 * @method     ChildAbbonamenti findOneByCosto(double $costo) Return the first ChildAbbonamenti filtered by the costo column *

 * @method     ChildAbbonamenti requirePk($key, ConnectionInterface $con = null) Return the ChildAbbonamenti by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAbbonamenti requireOne(ConnectionInterface $con = null) Return the first ChildAbbonamenti matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildAbbonamenti requireOneByIdAbbonamento(int $id_abbonamento) Return the first ChildAbbonamenti filtered by the id_abbonamento column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAbbonamenti requireOneByCodice(string $codice) Return the first ChildAbbonamenti filtered by the codice column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAbbonamenti requireOneByCosto(double $costo) Return the first ChildAbbonamenti filtered by the costo column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildAbbonamenti[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildAbbonamenti objects based on current ModelCriteria
 * @method     ChildAbbonamenti[]|ObjectCollection findByIdAbbonamento(int $id_abbonamento) Return ChildAbbonamenti objects filtered by the id_abbonamento column
 * @method     ChildAbbonamenti[]|ObjectCollection findByCodice(string $codice) Return ChildAbbonamenti objects filtered by the codice column
 * @method     ChildAbbonamenti[]|ObjectCollection findByCosto(double $costo) Return ChildAbbonamenti objects filtered by the costo column
 * @method     ChildAbbonamenti[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class AbbonamentiQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\AbbonamentiQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'dbspiaggie', $modelName = '\\Abbonamenti', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildAbbonamentiQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildAbbonamentiQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildAbbonamentiQuery) {
            return $criteria;
        }
        $query = new ChildAbbonamentiQuery();
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
     * @return ChildAbbonamenti|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(AbbonamentiTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = AbbonamentiTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildAbbonamenti A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id_abbonamento, codice, costo FROM abbonamenti WHERE id_abbonamento = :p0';
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
            /** @var ChildAbbonamenti $obj */
            $obj = new ChildAbbonamenti();
            $obj->hydrate($row);
            AbbonamentiTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildAbbonamenti|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildAbbonamentiQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(AbbonamentiTableMap::COL_ID_ABBONAMENTO, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildAbbonamentiQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(AbbonamentiTableMap::COL_ID_ABBONAMENTO, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the id_abbonamento column
     *
     * Example usage:
     * <code>
     * $query->filterByIdAbbonamento(1234); // WHERE id_abbonamento = 1234
     * $query->filterByIdAbbonamento(array(12, 34)); // WHERE id_abbonamento IN (12, 34)
     * $query->filterByIdAbbonamento(array('min' => 12)); // WHERE id_abbonamento > 12
     * </code>
     *
     * @param     mixed $idAbbonamento The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAbbonamentiQuery The current query, for fluid interface
     */
    public function filterByIdAbbonamento($idAbbonamento = null, $comparison = null)
    {
        if (is_array($idAbbonamento)) {
            $useMinMax = false;
            if (isset($idAbbonamento['min'])) {
                $this->addUsingAlias(AbbonamentiTableMap::COL_ID_ABBONAMENTO, $idAbbonamento['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($idAbbonamento['max'])) {
                $this->addUsingAlias(AbbonamentiTableMap::COL_ID_ABBONAMENTO, $idAbbonamento['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AbbonamentiTableMap::COL_ID_ABBONAMENTO, $idAbbonamento, $comparison);
    }

    /**
     * Filter the query on the codice column
     *
     * Example usage:
     * <code>
     * $query->filterByCodice('fooValue');   // WHERE codice = 'fooValue'
     * $query->filterByCodice('%fooValue%', Criteria::LIKE); // WHERE codice LIKE '%fooValue%'
     * </code>
     *
     * @param     string $codice The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAbbonamentiQuery The current query, for fluid interface
     */
    public function filterByCodice($codice = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($codice)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AbbonamentiTableMap::COL_CODICE, $codice, $comparison);
    }

    /**
     * Filter the query on the costo column
     *
     * Example usage:
     * <code>
     * $query->filterByCosto(1234); // WHERE costo = 1234
     * $query->filterByCosto(array(12, 34)); // WHERE costo IN (12, 34)
     * $query->filterByCosto(array('min' => 12)); // WHERE costo > 12
     * </code>
     *
     * @param     mixed $costo The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAbbonamentiQuery The current query, for fluid interface
     */
    public function filterByCosto($costo = null, $comparison = null)
    {
        if (is_array($costo)) {
            $useMinMax = false;
            if (isset($costo['min'])) {
                $this->addUsingAlias(AbbonamentiTableMap::COL_COSTO, $costo['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($costo['max'])) {
                $this->addUsingAlias(AbbonamentiTableMap::COL_COSTO, $costo['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AbbonamentiTableMap::COL_COSTO, $costo, $comparison);
    }

    /**
     * Filter the query by a related \AssegnamentiPostazione object
     *
     * @param \AssegnamentiPostazione|ObjectCollection $assegnamentiPostazione the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildAbbonamentiQuery The current query, for fluid interface
     */
    public function filterByAssegnamentiPostazione($assegnamentiPostazione, $comparison = null)
    {
        if ($assegnamentiPostazione instanceof \AssegnamentiPostazione) {
            return $this
                ->addUsingAlias(AbbonamentiTableMap::COL_ID_ABBONAMENTO, $assegnamentiPostazione->getIdAbbonamento(), $comparison);
        } elseif ($assegnamentiPostazione instanceof ObjectCollection) {
            return $this
                ->useAssegnamentiPostazioneQuery()
                ->filterByPrimaryKeys($assegnamentiPostazione->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByAssegnamentiPostazione() only accepts arguments of type \AssegnamentiPostazione or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the AssegnamentiPostazione relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildAbbonamentiQuery The current query, for fluid interface
     */
    public function joinAssegnamentiPostazione($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('AssegnamentiPostazione');

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
            $this->addJoinObject($join, 'AssegnamentiPostazione');
        }

        return $this;
    }

    /**
     * Use the AssegnamentiPostazione relation AssegnamentiPostazione object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \AssegnamentiPostazioneQuery A secondary query class using the current class as primary query
     */
    public function useAssegnamentiPostazioneQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinAssegnamentiPostazione($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'AssegnamentiPostazione', '\AssegnamentiPostazioneQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildAbbonamenti $abbonamenti Object to remove from the list of results
     *
     * @return $this|ChildAbbonamentiQuery The current query, for fluid interface
     */
    public function prune($abbonamenti = null)
    {
        if ($abbonamenti) {
            $this->addUsingAlias(AbbonamentiTableMap::COL_ID_ABBONAMENTO, $abbonamenti->getIdAbbonamento(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the abbonamenti table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(AbbonamentiTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            AbbonamentiTableMap::clearInstancePool();
            AbbonamentiTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(AbbonamentiTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(AbbonamentiTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            AbbonamentiTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            AbbonamentiTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // AbbonamentiQuery
