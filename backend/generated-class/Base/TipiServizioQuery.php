<?php

namespace Base;

use \TipiServizio as ChildTipiServizio;
use \TipiServizioQuery as ChildTipiServizioQuery;
use \Exception;
use \PDO;
use Map\TipiServizioTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'tipi_servizio' table.
 *
 *
 *
 * @method     ChildTipiServizioQuery orderByIdTipoServizio($order = Criteria::ASC) Order by the id_tipo_servizio column
 * @method     ChildTipiServizioQuery orderByDescrizione($order = Criteria::ASC) Order by the descrizione column
 *
 * @method     ChildTipiServizioQuery groupByIdTipoServizio() Group by the id_tipo_servizio column
 * @method     ChildTipiServizioQuery groupByDescrizione() Group by the descrizione column
 *
 * @method     ChildTipiServizioQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildTipiServizioQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildTipiServizioQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildTipiServizioQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildTipiServizioQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildTipiServizioQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildTipiServizioQuery leftJoinCostiServizio($relationAlias = null) Adds a LEFT JOIN clause to the query using the CostiServizio relation
 * @method     ChildTipiServizioQuery rightJoinCostiServizio($relationAlias = null) Adds a RIGHT JOIN clause to the query using the CostiServizio relation
 * @method     ChildTipiServizioQuery innerJoinCostiServizio($relationAlias = null) Adds a INNER JOIN clause to the query using the CostiServizio relation
 *
 * @method     ChildTipiServizioQuery joinWithCostiServizio($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the CostiServizio relation
 *
 * @method     ChildTipiServizioQuery leftJoinWithCostiServizio() Adds a LEFT JOIN clause and with to the query using the CostiServizio relation
 * @method     ChildTipiServizioQuery rightJoinWithCostiServizio() Adds a RIGHT JOIN clause and with to the query using the CostiServizio relation
 * @method     ChildTipiServizioQuery innerJoinWithCostiServizio() Adds a INNER JOIN clause and with to the query using the CostiServizio relation
 *
 * @method     ChildTipiServizioQuery leftJoinServizi($relationAlias = null) Adds a LEFT JOIN clause to the query using the Servizi relation
 * @method     ChildTipiServizioQuery rightJoinServizi($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Servizi relation
 * @method     ChildTipiServizioQuery innerJoinServizi($relationAlias = null) Adds a INNER JOIN clause to the query using the Servizi relation
 *
 * @method     ChildTipiServizioQuery joinWithServizi($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Servizi relation
 *
 * @method     ChildTipiServizioQuery leftJoinWithServizi() Adds a LEFT JOIN clause and with to the query using the Servizi relation
 * @method     ChildTipiServizioQuery rightJoinWithServizi() Adds a RIGHT JOIN clause and with to the query using the Servizi relation
 * @method     ChildTipiServizioQuery innerJoinWithServizi() Adds a INNER JOIN clause and with to the query using the Servizi relation
 *
 * @method     \CostiServizioQuery|\ServiziQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildTipiServizio findOne(ConnectionInterface $con = null) Return the first ChildTipiServizio matching the query
 * @method     ChildTipiServizio findOneOrCreate(ConnectionInterface $con = null) Return the first ChildTipiServizio matching the query, or a new ChildTipiServizio object populated from the query conditions when no match is found
 *
 * @method     ChildTipiServizio findOneByIdTipoServizio(int $id_tipo_servizio) Return the first ChildTipiServizio filtered by the id_tipo_servizio column
 * @method     ChildTipiServizio findOneByDescrizione(string $descrizione) Return the first ChildTipiServizio filtered by the descrizione column *

 * @method     ChildTipiServizio requirePk($key, ConnectionInterface $con = null) Return the ChildTipiServizio by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildTipiServizio requireOne(ConnectionInterface $con = null) Return the first ChildTipiServizio matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildTipiServizio requireOneByIdTipoServizio(int $id_tipo_servizio) Return the first ChildTipiServizio filtered by the id_tipo_servizio column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildTipiServizio requireOneByDescrizione(string $descrizione) Return the first ChildTipiServizio filtered by the descrizione column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildTipiServizio[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildTipiServizio objects based on current ModelCriteria
 * @method     ChildTipiServizio[]|ObjectCollection findByIdTipoServizio(int $id_tipo_servizio) Return ChildTipiServizio objects filtered by the id_tipo_servizio column
 * @method     ChildTipiServizio[]|ObjectCollection findByDescrizione(string $descrizione) Return ChildTipiServizio objects filtered by the descrizione column
 * @method     ChildTipiServizio[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class TipiServizioQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\TipiServizioQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'dbspiaggie', $modelName = '\\TipiServizio', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildTipiServizioQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildTipiServizioQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildTipiServizioQuery) {
            return $criteria;
        }
        $query = new ChildTipiServizioQuery();
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
     * @return ChildTipiServizio|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(TipiServizioTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = TipiServizioTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildTipiServizio A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id_tipo_servizio, descrizione FROM tipi_servizio WHERE id_tipo_servizio = :p0';
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
            /** @var ChildTipiServizio $obj */
            $obj = new ChildTipiServizio();
            $obj->hydrate($row);
            TipiServizioTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildTipiServizio|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildTipiServizioQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(TipiServizioTableMap::COL_ID_TIPO_SERVIZIO, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildTipiServizioQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(TipiServizioTableMap::COL_ID_TIPO_SERVIZIO, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the id_tipo_servizio column
     *
     * Example usage:
     * <code>
     * $query->filterByIdTipoServizio(1234); // WHERE id_tipo_servizio = 1234
     * $query->filterByIdTipoServizio(array(12, 34)); // WHERE id_tipo_servizio IN (12, 34)
     * $query->filterByIdTipoServizio(array('min' => 12)); // WHERE id_tipo_servizio > 12
     * </code>
     *
     * @param     mixed $idTipoServizio The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildTipiServizioQuery The current query, for fluid interface
     */
    public function filterByIdTipoServizio($idTipoServizio = null, $comparison = null)
    {
        if (is_array($idTipoServizio)) {
            $useMinMax = false;
            if (isset($idTipoServizio['min'])) {
                $this->addUsingAlias(TipiServizioTableMap::COL_ID_TIPO_SERVIZIO, $idTipoServizio['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($idTipoServizio['max'])) {
                $this->addUsingAlias(TipiServizioTableMap::COL_ID_TIPO_SERVIZIO, $idTipoServizio['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TipiServizioTableMap::COL_ID_TIPO_SERVIZIO, $idTipoServizio, $comparison);
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
     * @return $this|ChildTipiServizioQuery The current query, for fluid interface
     */
    public function filterByDescrizione($descrizione = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($descrizione)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TipiServizioTableMap::COL_DESCRIZIONE, $descrizione, $comparison);
    }

    /**
     * Filter the query by a related \CostiServizio object
     *
     * @param \CostiServizio|ObjectCollection $costiServizio the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildTipiServizioQuery The current query, for fluid interface
     */
    public function filterByCostiServizio($costiServizio, $comparison = null)
    {
        if ($costiServizio instanceof \CostiServizio) {
            return $this
                ->addUsingAlias(TipiServizioTableMap::COL_ID_TIPO_SERVIZIO, $costiServizio->getIdTipoServizio(), $comparison);
        } elseif ($costiServizio instanceof ObjectCollection) {
            return $this
                ->useCostiServizioQuery()
                ->filterByPrimaryKeys($costiServizio->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByCostiServizio() only accepts arguments of type \CostiServizio or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the CostiServizio relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildTipiServizioQuery The current query, for fluid interface
     */
    public function joinCostiServizio($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('CostiServizio');

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
            $this->addJoinObject($join, 'CostiServizio');
        }

        return $this;
    }

    /**
     * Use the CostiServizio relation CostiServizio object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \CostiServizioQuery A secondary query class using the current class as primary query
     */
    public function useCostiServizioQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinCostiServizio($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'CostiServizio', '\CostiServizioQuery');
    }

    /**
     * Filter the query by a related \Servizi object
     *
     * @param \Servizi|ObjectCollection $servizi the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildTipiServizioQuery The current query, for fluid interface
     */
    public function filterByServizi($servizi, $comparison = null)
    {
        if ($servizi instanceof \Servizi) {
            return $this
                ->addUsingAlias(TipiServizioTableMap::COL_ID_TIPO_SERVIZIO, $servizi->getIdTipoServizio(), $comparison);
        } elseif ($servizi instanceof ObjectCollection) {
            return $this
                ->useServiziQuery()
                ->filterByPrimaryKeys($servizi->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByServizi() only accepts arguments of type \Servizi or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Servizi relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildTipiServizioQuery The current query, for fluid interface
     */
    public function joinServizi($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Servizi');

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
            $this->addJoinObject($join, 'Servizi');
        }

        return $this;
    }

    /**
     * Use the Servizi relation Servizi object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \ServiziQuery A secondary query class using the current class as primary query
     */
    public function useServiziQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinServizi($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Servizi', '\ServiziQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildTipiServizio $tipiServizio Object to remove from the list of results
     *
     * @return $this|ChildTipiServizioQuery The current query, for fluid interface
     */
    public function prune($tipiServizio = null)
    {
        if ($tipiServizio) {
            $this->addUsingAlias(TipiServizioTableMap::COL_ID_TIPO_SERVIZIO, $tipiServizio->getIdTipoServizio(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the tipi_servizio table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(TipiServizioTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            TipiServizioTableMap::clearInstancePool();
            TipiServizioTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(TipiServizioTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(TipiServizioTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            TipiServizioTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            TipiServizioTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // TipiServizioQuery
