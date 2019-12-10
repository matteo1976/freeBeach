<?php

namespace Base;

use \Profili as ChildProfili;
use \ProfiliQuery as ChildProfiliQuery;
use \Exception;
use \PDO;
use Map\ProfiliTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'profili' table.
 *
 *
 *
 * @method     ChildProfiliQuery orderByIdProfilo($order = Criteria::ASC) Order by the id_profilo column
 * @method     ChildProfiliQuery orderByDescrizione($order = Criteria::ASC) Order by the descrizione column
 *
 * @method     ChildProfiliQuery groupByIdProfilo() Group by the id_profilo column
 * @method     ChildProfiliQuery groupByDescrizione() Group by the descrizione column
 *
 * @method     ChildProfiliQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildProfiliQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildProfiliQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildProfiliQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildProfiliQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildProfiliQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildProfiliQuery leftJoinAccount($relationAlias = null) Adds a LEFT JOIN clause to the query using the Account relation
 * @method     ChildProfiliQuery rightJoinAccount($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Account relation
 * @method     ChildProfiliQuery innerJoinAccount($relationAlias = null) Adds a INNER JOIN clause to the query using the Account relation
 *
 * @method     ChildProfiliQuery joinWithAccount($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Account relation
 *
 * @method     ChildProfiliQuery leftJoinWithAccount() Adds a LEFT JOIN clause and with to the query using the Account relation
 * @method     ChildProfiliQuery rightJoinWithAccount() Adds a RIGHT JOIN clause and with to the query using the Account relation
 * @method     ChildProfiliQuery innerJoinWithAccount() Adds a INNER JOIN clause and with to the query using the Account relation
 *
 * @method     ChildProfiliQuery leftJoinPrivilegiProfilo($relationAlias = null) Adds a LEFT JOIN clause to the query using the PrivilegiProfilo relation
 * @method     ChildProfiliQuery rightJoinPrivilegiProfilo($relationAlias = null) Adds a RIGHT JOIN clause to the query using the PrivilegiProfilo relation
 * @method     ChildProfiliQuery innerJoinPrivilegiProfilo($relationAlias = null) Adds a INNER JOIN clause to the query using the PrivilegiProfilo relation
 *
 * @method     ChildProfiliQuery joinWithPrivilegiProfilo($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the PrivilegiProfilo relation
 *
 * @method     ChildProfiliQuery leftJoinWithPrivilegiProfilo() Adds a LEFT JOIN clause and with to the query using the PrivilegiProfilo relation
 * @method     ChildProfiliQuery rightJoinWithPrivilegiProfilo() Adds a RIGHT JOIN clause and with to the query using the PrivilegiProfilo relation
 * @method     ChildProfiliQuery innerJoinWithPrivilegiProfilo() Adds a INNER JOIN clause and with to the query using the PrivilegiProfilo relation
 *
 * @method     \AccountQuery|\PrivilegiProfiloQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildProfili findOne(ConnectionInterface $con = null) Return the first ChildProfili matching the query
 * @method     ChildProfili findOneOrCreate(ConnectionInterface $con = null) Return the first ChildProfili matching the query, or a new ChildProfili object populated from the query conditions when no match is found
 *
 * @method     ChildProfili findOneByIdProfilo(int $id_profilo) Return the first ChildProfili filtered by the id_profilo column
 * @method     ChildProfili findOneByDescrizione(string $descrizione) Return the first ChildProfili filtered by the descrizione column *

 * @method     ChildProfili requirePk($key, ConnectionInterface $con = null) Return the ChildProfili by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildProfili requireOne(ConnectionInterface $con = null) Return the first ChildProfili matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildProfili requireOneByIdProfilo(int $id_profilo) Return the first ChildProfili filtered by the id_profilo column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildProfili requireOneByDescrizione(string $descrizione) Return the first ChildProfili filtered by the descrizione column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildProfili[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildProfili objects based on current ModelCriteria
 * @method     ChildProfili[]|ObjectCollection findByIdProfilo(int $id_profilo) Return ChildProfili objects filtered by the id_profilo column
 * @method     ChildProfili[]|ObjectCollection findByDescrizione(string $descrizione) Return ChildProfili objects filtered by the descrizione column
 * @method     ChildProfili[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class ProfiliQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\ProfiliQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'dbspiaggie', $modelName = '\\Profili', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildProfiliQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildProfiliQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildProfiliQuery) {
            return $criteria;
        }
        $query = new ChildProfiliQuery();
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
     * @return ChildProfili|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(ProfiliTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = ProfiliTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildProfili A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id_profilo, descrizione FROM profili WHERE id_profilo = :p0';
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
            /** @var ChildProfili $obj */
            $obj = new ChildProfili();
            $obj->hydrate($row);
            ProfiliTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildProfili|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildProfiliQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(ProfiliTableMap::COL_ID_PROFILO, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildProfiliQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(ProfiliTableMap::COL_ID_PROFILO, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the id_profilo column
     *
     * Example usage:
     * <code>
     * $query->filterByIdProfilo(1234); // WHERE id_profilo = 1234
     * $query->filterByIdProfilo(array(12, 34)); // WHERE id_profilo IN (12, 34)
     * $query->filterByIdProfilo(array('min' => 12)); // WHERE id_profilo > 12
     * </code>
     *
     * @param     mixed $idProfilo The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildProfiliQuery The current query, for fluid interface
     */
    public function filterByIdProfilo($idProfilo = null, $comparison = null)
    {
        if (is_array($idProfilo)) {
            $useMinMax = false;
            if (isset($idProfilo['min'])) {
                $this->addUsingAlias(ProfiliTableMap::COL_ID_PROFILO, $idProfilo['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($idProfilo['max'])) {
                $this->addUsingAlias(ProfiliTableMap::COL_ID_PROFILO, $idProfilo['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ProfiliTableMap::COL_ID_PROFILO, $idProfilo, $comparison);
    }

    /**
     * Filter the query on the descrizione column
     *
     * Example usage:
     * <code>
     * $query->filterByDescrizione('fooValue');   // WHERE descrizione = 'fooValue'
     * $query->filterByDescrizione('%fooValue%', Criteria::LIKE); // WHERE descrizione LIKE '%fooValue%'
     * </code>
     *
     * @param     string $descrizione The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildProfiliQuery The current query, for fluid interface
     */
    public function filterByDescrizione($descrizione = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($descrizione)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ProfiliTableMap::COL_DESCRIZIONE, $descrizione, $comparison);
    }

    /**
     * Filter the query by a related \Account object
     *
     * @param \Account|ObjectCollection $account the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildProfiliQuery The current query, for fluid interface
     */
    public function filterByAccount($account, $comparison = null)
    {
        if ($account instanceof \Account) {
            return $this
                ->addUsingAlias(ProfiliTableMap::COL_ID_PROFILO, $account->getIdProfilo(), $comparison);
        } elseif ($account instanceof ObjectCollection) {
            return $this
                ->useAccountQuery()
                ->filterByPrimaryKeys($account->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByAccount() only accepts arguments of type \Account or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Account relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildProfiliQuery The current query, for fluid interface
     */
    public function joinAccount($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Account');

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
            $this->addJoinObject($join, 'Account');
        }

        return $this;
    }

    /**
     * Use the Account relation Account object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \AccountQuery A secondary query class using the current class as primary query
     */
    public function useAccountQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinAccount($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Account', '\AccountQuery');
    }

    /**
     * Filter the query by a related \PrivilegiProfilo object
     *
     * @param \PrivilegiProfilo|ObjectCollection $privilegiProfilo the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildProfiliQuery The current query, for fluid interface
     */
    public function filterByPrivilegiProfilo($privilegiProfilo, $comparison = null)
    {
        if ($privilegiProfilo instanceof \PrivilegiProfilo) {
            return $this
                ->addUsingAlias(ProfiliTableMap::COL_ID_PROFILO, $privilegiProfilo->getIdProfilo(), $comparison);
        } elseif ($privilegiProfilo instanceof ObjectCollection) {
            return $this
                ->usePrivilegiProfiloQuery()
                ->filterByPrimaryKeys($privilegiProfilo->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByPrivilegiProfilo() only accepts arguments of type \PrivilegiProfilo or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the PrivilegiProfilo relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildProfiliQuery The current query, for fluid interface
     */
    public function joinPrivilegiProfilo($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('PrivilegiProfilo');

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
            $this->addJoinObject($join, 'PrivilegiProfilo');
        }

        return $this;
    }

    /**
     * Use the PrivilegiProfilo relation PrivilegiProfilo object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \PrivilegiProfiloQuery A secondary query class using the current class as primary query
     */
    public function usePrivilegiProfiloQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinPrivilegiProfilo($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'PrivilegiProfilo', '\PrivilegiProfiloQuery');
    }

    /**
     * Filter the query by a related Privilegi object
     * using the privilegi_profilo table as cross reference
     *
     * @param Privilegi $privilegi the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildProfiliQuery The current query, for fluid interface
     */
    public function filterByPrivilegi($privilegi, $comparison = Criteria::EQUAL)
    {
        return $this
            ->usePrivilegiProfiloQuery()
            ->filterByPrivilegi($privilegi, $comparison)
            ->endUse();
    }

    /**
     * Exclude object from result
     *
     * @param   ChildProfili $profili Object to remove from the list of results
     *
     * @return $this|ChildProfiliQuery The current query, for fluid interface
     */
    public function prune($profili = null)
    {
        if ($profili) {
            $this->addUsingAlias(ProfiliTableMap::COL_ID_PROFILO, $profili->getIdProfilo(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the profili table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(ProfiliTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            ProfiliTableMap::clearInstancePool();
            ProfiliTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(ProfiliTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(ProfiliTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            ProfiliTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            ProfiliTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // ProfiliQuery
