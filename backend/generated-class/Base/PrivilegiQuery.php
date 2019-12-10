<?php

namespace Base;

use \Privilegi as ChildPrivilegi;
use \PrivilegiQuery as ChildPrivilegiQuery;
use \Exception;
use \PDO;
use Map\PrivilegiTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'privilegi' table.
 *
 *
 *
 * @method     ChildPrivilegiQuery orderByIdPrivilegio($order = Criteria::ASC) Order by the id_privilegio column
 * @method     ChildPrivilegiQuery orderByDescrizione($order = Criteria::ASC) Order by the descrizione column
 * @method     ChildPrivilegiQuery orderByNoteInterne($order = Criteria::ASC) Order by the note_interne column
 *
 * @method     ChildPrivilegiQuery groupByIdPrivilegio() Group by the id_privilegio column
 * @method     ChildPrivilegiQuery groupByDescrizione() Group by the descrizione column
 * @method     ChildPrivilegiQuery groupByNoteInterne() Group by the note_interne column
 *
 * @method     ChildPrivilegiQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildPrivilegiQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildPrivilegiQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildPrivilegiQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildPrivilegiQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildPrivilegiQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildPrivilegiQuery leftJoinPrivilegiProfilo($relationAlias = null) Adds a LEFT JOIN clause to the query using the PrivilegiProfilo relation
 * @method     ChildPrivilegiQuery rightJoinPrivilegiProfilo($relationAlias = null) Adds a RIGHT JOIN clause to the query using the PrivilegiProfilo relation
 * @method     ChildPrivilegiQuery innerJoinPrivilegiProfilo($relationAlias = null) Adds a INNER JOIN clause to the query using the PrivilegiProfilo relation
 *
 * @method     ChildPrivilegiQuery joinWithPrivilegiProfilo($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the PrivilegiProfilo relation
 *
 * @method     ChildPrivilegiQuery leftJoinWithPrivilegiProfilo() Adds a LEFT JOIN clause and with to the query using the PrivilegiProfilo relation
 * @method     ChildPrivilegiQuery rightJoinWithPrivilegiProfilo() Adds a RIGHT JOIN clause and with to the query using the PrivilegiProfilo relation
 * @method     ChildPrivilegiQuery innerJoinWithPrivilegiProfilo() Adds a INNER JOIN clause and with to the query using the PrivilegiProfilo relation
 *
 * @method     \PrivilegiProfiloQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildPrivilegi findOne(ConnectionInterface $con = null) Return the first ChildPrivilegi matching the query
 * @method     ChildPrivilegi findOneOrCreate(ConnectionInterface $con = null) Return the first ChildPrivilegi matching the query, or a new ChildPrivilegi object populated from the query conditions when no match is found
 *
 * @method     ChildPrivilegi findOneByIdPrivilegio(int $id_privilegio) Return the first ChildPrivilegi filtered by the id_privilegio column
 * @method     ChildPrivilegi findOneByDescrizione(string $descrizione) Return the first ChildPrivilegi filtered by the descrizione column
 * @method     ChildPrivilegi findOneByNoteInterne(string $note_interne) Return the first ChildPrivilegi filtered by the note_interne column *

 * @method     ChildPrivilegi requirePk($key, ConnectionInterface $con = null) Return the ChildPrivilegi by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPrivilegi requireOne(ConnectionInterface $con = null) Return the first ChildPrivilegi matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildPrivilegi requireOneByIdPrivilegio(int $id_privilegio) Return the first ChildPrivilegi filtered by the id_privilegio column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPrivilegi requireOneByDescrizione(string $descrizione) Return the first ChildPrivilegi filtered by the descrizione column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPrivilegi requireOneByNoteInterne(string $note_interne) Return the first ChildPrivilegi filtered by the note_interne column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildPrivilegi[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildPrivilegi objects based on current ModelCriteria
 * @method     ChildPrivilegi[]|ObjectCollection findByIdPrivilegio(int $id_privilegio) Return ChildPrivilegi objects filtered by the id_privilegio column
 * @method     ChildPrivilegi[]|ObjectCollection findByDescrizione(string $descrizione) Return ChildPrivilegi objects filtered by the descrizione column
 * @method     ChildPrivilegi[]|ObjectCollection findByNoteInterne(string $note_interne) Return ChildPrivilegi objects filtered by the note_interne column
 * @method     ChildPrivilegi[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class PrivilegiQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\PrivilegiQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'dbspiaggie', $modelName = '\\Privilegi', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildPrivilegiQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildPrivilegiQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildPrivilegiQuery) {
            return $criteria;
        }
        $query = new ChildPrivilegiQuery();
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
     * @return ChildPrivilegi|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(PrivilegiTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = PrivilegiTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildPrivilegi A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id_privilegio, descrizione, note_interne FROM privilegi WHERE id_privilegio = :p0';
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
            /** @var ChildPrivilegi $obj */
            $obj = new ChildPrivilegi();
            $obj->hydrate($row);
            PrivilegiTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildPrivilegi|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildPrivilegiQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(PrivilegiTableMap::COL_ID_PRIVILEGIO, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildPrivilegiQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(PrivilegiTableMap::COL_ID_PRIVILEGIO, $keys, Criteria::IN);
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
     * @param     mixed $idPrivilegio The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPrivilegiQuery The current query, for fluid interface
     */
    public function filterByIdPrivilegio($idPrivilegio = null, $comparison = null)
    {
        if (is_array($idPrivilegio)) {
            $useMinMax = false;
            if (isset($idPrivilegio['min'])) {
                $this->addUsingAlias(PrivilegiTableMap::COL_ID_PRIVILEGIO, $idPrivilegio['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($idPrivilegio['max'])) {
                $this->addUsingAlias(PrivilegiTableMap::COL_ID_PRIVILEGIO, $idPrivilegio['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PrivilegiTableMap::COL_ID_PRIVILEGIO, $idPrivilegio, $comparison);
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
     * @return $this|ChildPrivilegiQuery The current query, for fluid interface
     */
    public function filterByDescrizione($descrizione = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($descrizione)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PrivilegiTableMap::COL_DESCRIZIONE, $descrizione, $comparison);
    }

    /**
     * Filter the query on the note_interne column
     *
     * Example usage:
     * <code>
     * $query->filterByNoteInterne('fooValue');   // WHERE note_interne = 'fooValue'
     * $query->filterByNoteInterne('%fooValue%', Criteria::LIKE); // WHERE note_interne LIKE '%fooValue%'
     * </code>
     *
     * @param     string $noteInterne The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPrivilegiQuery The current query, for fluid interface
     */
    public function filterByNoteInterne($noteInterne = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($noteInterne)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PrivilegiTableMap::COL_NOTE_INTERNE, $noteInterne, $comparison);
    }

    /**
     * Filter the query by a related \PrivilegiProfilo object
     *
     * @param \PrivilegiProfilo|ObjectCollection $privilegiProfilo the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPrivilegiQuery The current query, for fluid interface
     */
    public function filterByPrivilegiProfilo($privilegiProfilo, $comparison = null)
    {
        if ($privilegiProfilo instanceof \PrivilegiProfilo) {
            return $this
                ->addUsingAlias(PrivilegiTableMap::COL_ID_PRIVILEGIO, $privilegiProfilo->getIdPrivilegio(), $comparison);
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
     * @return $this|ChildPrivilegiQuery The current query, for fluid interface
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
     * Filter the query by a related Profili object
     * using the privilegi_profilo table as cross reference
     *
     * @param Profili $profili the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPrivilegiQuery The current query, for fluid interface
     */
    public function filterByProfili($profili, $comparison = Criteria::EQUAL)
    {
        return $this
            ->usePrivilegiProfiloQuery()
            ->filterByProfili($profili, $comparison)
            ->endUse();
    }

    /**
     * Exclude object from result
     *
     * @param   ChildPrivilegi $privilegi Object to remove from the list of results
     *
     * @return $this|ChildPrivilegiQuery The current query, for fluid interface
     */
    public function prune($privilegi = null)
    {
        if ($privilegi) {
            $this->addUsingAlias(PrivilegiTableMap::COL_ID_PRIVILEGIO, $privilegi->getIdPrivilegio(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the privilegi table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(PrivilegiTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            PrivilegiTableMap::clearInstancePool();
            PrivilegiTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(PrivilegiTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(PrivilegiTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            PrivilegiTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            PrivilegiTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // PrivilegiQuery
