<?php

namespace Base;

use \PrivilegiProfilo as ChildPrivilegiProfilo;
use \PrivilegiProfiloQuery as ChildPrivilegiProfiloQuery;
use \Exception;
use \PDO;
use Map\PrivilegiProfiloTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'privilegi_profilo' table.
 *
 *
 *
 * @method     ChildPrivilegiProfiloQuery orderByIdPrivilegio($order = Criteria::ASC) Order by the id_privilegio column
 * @method     ChildPrivilegiProfiloQuery orderByIdProfilo($order = Criteria::ASC) Order by the id_profilo column
 *
 * @method     ChildPrivilegiProfiloQuery groupByIdPrivilegio() Group by the id_privilegio column
 * @method     ChildPrivilegiProfiloQuery groupByIdProfilo() Group by the id_profilo column
 *
 * @method     ChildPrivilegiProfiloQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildPrivilegiProfiloQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildPrivilegiProfiloQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildPrivilegiProfiloQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildPrivilegiProfiloQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildPrivilegiProfiloQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildPrivilegiProfiloQuery leftJoinPrivilegi($relationAlias = null) Adds a LEFT JOIN clause to the query using the Privilegi relation
 * @method     ChildPrivilegiProfiloQuery rightJoinPrivilegi($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Privilegi relation
 * @method     ChildPrivilegiProfiloQuery innerJoinPrivilegi($relationAlias = null) Adds a INNER JOIN clause to the query using the Privilegi relation
 *
 * @method     ChildPrivilegiProfiloQuery joinWithPrivilegi($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Privilegi relation
 *
 * @method     ChildPrivilegiProfiloQuery leftJoinWithPrivilegi() Adds a LEFT JOIN clause and with to the query using the Privilegi relation
 * @method     ChildPrivilegiProfiloQuery rightJoinWithPrivilegi() Adds a RIGHT JOIN clause and with to the query using the Privilegi relation
 * @method     ChildPrivilegiProfiloQuery innerJoinWithPrivilegi() Adds a INNER JOIN clause and with to the query using the Privilegi relation
 *
 * @method     ChildPrivilegiProfiloQuery leftJoinProfili($relationAlias = null) Adds a LEFT JOIN clause to the query using the Profili relation
 * @method     ChildPrivilegiProfiloQuery rightJoinProfili($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Profili relation
 * @method     ChildPrivilegiProfiloQuery innerJoinProfili($relationAlias = null) Adds a INNER JOIN clause to the query using the Profili relation
 *
 * @method     ChildPrivilegiProfiloQuery joinWithProfili($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Profili relation
 *
 * @method     ChildPrivilegiProfiloQuery leftJoinWithProfili() Adds a LEFT JOIN clause and with to the query using the Profili relation
 * @method     ChildPrivilegiProfiloQuery rightJoinWithProfili() Adds a RIGHT JOIN clause and with to the query using the Profili relation
 * @method     ChildPrivilegiProfiloQuery innerJoinWithProfili() Adds a INNER JOIN clause and with to the query using the Profili relation
 *
 * @method     \PrivilegiQuery|\ProfiliQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildPrivilegiProfilo findOne(ConnectionInterface $con = null) Return the first ChildPrivilegiProfilo matching the query
 * @method     ChildPrivilegiProfilo findOneOrCreate(ConnectionInterface $con = null) Return the first ChildPrivilegiProfilo matching the query, or a new ChildPrivilegiProfilo object populated from the query conditions when no match is found
 *
 * @method     ChildPrivilegiProfilo findOneByIdPrivilegio(int $id_privilegio) Return the first ChildPrivilegiProfilo filtered by the id_privilegio column
 * @method     ChildPrivilegiProfilo findOneByIdProfilo(int $id_profilo) Return the first ChildPrivilegiProfilo filtered by the id_profilo column *

 * @method     ChildPrivilegiProfilo requirePk($key, ConnectionInterface $con = null) Return the ChildPrivilegiProfilo by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPrivilegiProfilo requireOne(ConnectionInterface $con = null) Return the first ChildPrivilegiProfilo matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildPrivilegiProfilo requireOneByIdPrivilegio(int $id_privilegio) Return the first ChildPrivilegiProfilo filtered by the id_privilegio column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPrivilegiProfilo requireOneByIdProfilo(int $id_profilo) Return the first ChildPrivilegiProfilo filtered by the id_profilo column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildPrivilegiProfilo[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildPrivilegiProfilo objects based on current ModelCriteria
 * @method     ChildPrivilegiProfilo[]|ObjectCollection findByIdPrivilegio(int $id_privilegio) Return ChildPrivilegiProfilo objects filtered by the id_privilegio column
 * @method     ChildPrivilegiProfilo[]|ObjectCollection findByIdProfilo(int $id_profilo) Return ChildPrivilegiProfilo objects filtered by the id_profilo column
 * @method     ChildPrivilegiProfilo[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class PrivilegiProfiloQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\PrivilegiProfiloQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'dbspiaggie', $modelName = '\\PrivilegiProfilo', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildPrivilegiProfiloQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildPrivilegiProfiloQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildPrivilegiProfiloQuery) {
            return $criteria;
        }
        $query = new ChildPrivilegiProfiloQuery();
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
     * $obj = $c->findPk(array(12, 34), $con);
     * </code>
     *
     * @param array[$id_privilegio, $id_profilo] $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildPrivilegiProfilo|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(PrivilegiProfiloTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = PrivilegiProfiloTableMap::getInstanceFromPool(serialize([(null === $key[0] || is_scalar($key[0]) || is_callable([$key[0], '__toString']) ? (string) $key[0] : $key[0]), (null === $key[1] || is_scalar($key[1]) || is_callable([$key[1], '__toString']) ? (string) $key[1] : $key[1])]))))) {
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
     * @return ChildPrivilegiProfilo A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id_privilegio, id_profilo FROM privilegi_profilo WHERE id_privilegio = :p0 AND id_profilo = :p1';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key[0], PDO::PARAM_INT);
            $stmt->bindValue(':p1', $key[1], PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            /** @var ChildPrivilegiProfilo $obj */
            $obj = new ChildPrivilegiProfilo();
            $obj->hydrate($row);
            PrivilegiProfiloTableMap::addInstanceToPool($obj, serialize([(null === $key[0] || is_scalar($key[0]) || is_callable([$key[0], '__toString']) ? (string) $key[0] : $key[0]), (null === $key[1] || is_scalar($key[1]) || is_callable([$key[1], '__toString']) ? (string) $key[1] : $key[1])]));
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
     * @return ChildPrivilegiProfilo|array|mixed the result, formatted by the current formatter
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
     * $objs = $c->findPks(array(array(12, 56), array(832, 123), array(123, 456)), $con);
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
     * @return $this|ChildPrivilegiProfiloQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {
        $this->addUsingAlias(PrivilegiProfiloTableMap::COL_ID_PRIVILEGIO, $key[0], Criteria::EQUAL);
        $this->addUsingAlias(PrivilegiProfiloTableMap::COL_ID_PROFILO, $key[1], Criteria::EQUAL);

        return $this;
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildPrivilegiProfiloQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {
        if (empty($keys)) {
            return $this->add(null, '1<>1', Criteria::CUSTOM);
        }
        foreach ($keys as $key) {
            $cton0 = $this->getNewCriterion(PrivilegiProfiloTableMap::COL_ID_PRIVILEGIO, $key[0], Criteria::EQUAL);
            $cton1 = $this->getNewCriterion(PrivilegiProfiloTableMap::COL_ID_PROFILO, $key[1], Criteria::EQUAL);
            $cton0->addAnd($cton1);
            $this->addOr($cton0);
        }

        return $this;
    }

    /**
     * Filter the query on the id_privilegio column
     *
     * Example usage:
     * <code>
     * $query->filterByIdPrivilegio(1234); // WHERE id_privilegio = 1234
     * $query->filterByIdPrivilegio(array(12, 34)); // WHERE id_privilegio IN (12, 34)
     * $query->filterByIdPrivilegio(array('min' => 12)); // WHERE id_privilegio > 12
     * </code>
     *
     * @see       filterByPrivilegi()
     *
     * @param     mixed $idPrivilegio The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPrivilegiProfiloQuery The current query, for fluid interface
     */
    public function filterByIdPrivilegio($idPrivilegio = null, $comparison = null)
    {
        if (is_array($idPrivilegio)) {
            $useMinMax = false;
            if (isset($idPrivilegio['min'])) {
                $this->addUsingAlias(PrivilegiProfiloTableMap::COL_ID_PRIVILEGIO, $idPrivilegio['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($idPrivilegio['max'])) {
                $this->addUsingAlias(PrivilegiProfiloTableMap::COL_ID_PRIVILEGIO, $idPrivilegio['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PrivilegiProfiloTableMap::COL_ID_PRIVILEGIO, $idPrivilegio, $comparison);
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
     * @see       filterByProfili()
     *
     * @param     mixed $idProfilo The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPrivilegiProfiloQuery The current query, for fluid interface
     */
    public function filterByIdProfilo($idProfilo = null, $comparison = null)
    {
        if (is_array($idProfilo)) {
            $useMinMax = false;
            if (isset($idProfilo['min'])) {
                $this->addUsingAlias(PrivilegiProfiloTableMap::COL_ID_PROFILO, $idProfilo['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($idProfilo['max'])) {
                $this->addUsingAlias(PrivilegiProfiloTableMap::COL_ID_PROFILO, $idProfilo['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PrivilegiProfiloTableMap::COL_ID_PROFILO, $idProfilo, $comparison);
    }

    /**
     * Filter the query by a related \Privilegi object
     *
     * @param \Privilegi|ObjectCollection $privilegi The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildPrivilegiProfiloQuery The current query, for fluid interface
     */
    public function filterByPrivilegi($privilegi, $comparison = null)
    {
        if ($privilegi instanceof \Privilegi) {
            return $this
                ->addUsingAlias(PrivilegiProfiloTableMap::COL_ID_PRIVILEGIO, $privilegi->getIdPrivilegio(), $comparison);
        } elseif ($privilegi instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(PrivilegiProfiloTableMap::COL_ID_PRIVILEGIO, $privilegi->toKeyValue('PrimaryKey', 'IdPrivilegio'), $comparison);
        } else {
            throw new PropelException('filterByPrivilegi() only accepts arguments of type \Privilegi or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Privilegi relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildPrivilegiProfiloQuery The current query, for fluid interface
     */
    public function joinPrivilegi($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Privilegi');

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
            $this->addJoinObject($join, 'Privilegi');
        }

        return $this;
    }

    /**
     * Use the Privilegi relation Privilegi object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \PrivilegiQuery A secondary query class using the current class as primary query
     */
    public function usePrivilegiQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinPrivilegi($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Privilegi', '\PrivilegiQuery');
    }

    /**
     * Filter the query by a related \Profili object
     *
     * @param \Profili|ObjectCollection $profili The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildPrivilegiProfiloQuery The current query, for fluid interface
     */
    public function filterByProfili($profili, $comparison = null)
    {
        if ($profili instanceof \Profili) {
            return $this
                ->addUsingAlias(PrivilegiProfiloTableMap::COL_ID_PROFILO, $profili->getIdProfilo(), $comparison);
        } elseif ($profili instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(PrivilegiProfiloTableMap::COL_ID_PROFILO, $profili->toKeyValue('PrimaryKey', 'IdProfilo'), $comparison);
        } else {
            throw new PropelException('filterByProfili() only accepts arguments of type \Profili or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Profili relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildPrivilegiProfiloQuery The current query, for fluid interface
     */
    public function joinProfili($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Profili');

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
            $this->addJoinObject($join, 'Profili');
        }

        return $this;
    }

    /**
     * Use the Profili relation Profili object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \ProfiliQuery A secondary query class using the current class as primary query
     */
    public function useProfiliQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinProfili($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Profili', '\ProfiliQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildPrivilegiProfilo $privilegiProfilo Object to remove from the list of results
     *
     * @return $this|ChildPrivilegiProfiloQuery The current query, for fluid interface
     */
    public function prune($privilegiProfilo = null)
    {
        if ($privilegiProfilo) {
            $this->addCond('pruneCond0', $this->getAliasedColName(PrivilegiProfiloTableMap::COL_ID_PRIVILEGIO), $privilegiProfilo->getIdPrivilegio(), Criteria::NOT_EQUAL);
            $this->addCond('pruneCond1', $this->getAliasedColName(PrivilegiProfiloTableMap::COL_ID_PROFILO), $privilegiProfilo->getIdProfilo(), Criteria::NOT_EQUAL);
            $this->combine(array('pruneCond0', 'pruneCond1'), Criteria::LOGICAL_OR);
        }

        return $this;
    }

    /**
     * Deletes all rows from the privilegi_profilo table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(PrivilegiProfiloTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            PrivilegiProfiloTableMap::clearInstancePool();
            PrivilegiProfiloTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(PrivilegiProfiloTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(PrivilegiProfiloTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            PrivilegiProfiloTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            PrivilegiProfiloTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // PrivilegiProfiloQuery
