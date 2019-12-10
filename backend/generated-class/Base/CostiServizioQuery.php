<?php

namespace Base;

use \CostiServizio as ChildCostiServizio;
use \CostiServizioQuery as ChildCostiServizioQuery;
use \Exception;
use \PDO;
use Map\CostiServizioTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'costi_servizio' table.
 *
 *
 *
 * @method     ChildCostiServizioQuery orderByIdCosto($order = Criteria::ASC) Order by the id_costo column
 * @method     ChildCostiServizioQuery orderByIdTipoServizio($order = Criteria::ASC) Order by the id_tipo_servizio column
 * @method     ChildCostiServizioQuery orderByInizioPeriodo($order = Criteria::ASC) Order by the inizio_periodo column
 * @method     ChildCostiServizioQuery orderByFinePeriodo($order = Criteria::ASC) Order by the fine_periodo column
 * @method     ChildCostiServizioQuery orderByCosto($order = Criteria::ASC) Order by the costo column
 *
 * @method     ChildCostiServizioQuery groupByIdCosto() Group by the id_costo column
 * @method     ChildCostiServizioQuery groupByIdTipoServizio() Group by the id_tipo_servizio column
 * @method     ChildCostiServizioQuery groupByInizioPeriodo() Group by the inizio_periodo column
 * @method     ChildCostiServizioQuery groupByFinePeriodo() Group by the fine_periodo column
 * @method     ChildCostiServizioQuery groupByCosto() Group by the costo column
 *
 * @method     ChildCostiServizioQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildCostiServizioQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildCostiServizioQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildCostiServizioQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildCostiServizioQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildCostiServizioQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildCostiServizioQuery leftJoinTipiServizio($relationAlias = null) Adds a LEFT JOIN clause to the query using the TipiServizio relation
 * @method     ChildCostiServizioQuery rightJoinTipiServizio($relationAlias = null) Adds a RIGHT JOIN clause to the query using the TipiServizio relation
 * @method     ChildCostiServizioQuery innerJoinTipiServizio($relationAlias = null) Adds a INNER JOIN clause to the query using the TipiServizio relation
 *
 * @method     ChildCostiServizioQuery joinWithTipiServizio($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the TipiServizio relation
 *
 * @method     ChildCostiServizioQuery leftJoinWithTipiServizio() Adds a LEFT JOIN clause and with to the query using the TipiServizio relation
 * @method     ChildCostiServizioQuery rightJoinWithTipiServizio() Adds a RIGHT JOIN clause and with to the query using the TipiServizio relation
 * @method     ChildCostiServizioQuery innerJoinWithTipiServizio() Adds a INNER JOIN clause and with to the query using the TipiServizio relation
 *
 * @method     \TipiServizioQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildCostiServizio findOne(ConnectionInterface $con = null) Return the first ChildCostiServizio matching the query
 * @method     ChildCostiServizio findOneOrCreate(ConnectionInterface $con = null) Return the first ChildCostiServizio matching the query, or a new ChildCostiServizio object populated from the query conditions when no match is found
 *
 * @method     ChildCostiServizio findOneByIdCosto(int $id_costo) Return the first ChildCostiServizio filtered by the id_costo column
 * @method     ChildCostiServizio findOneByIdTipoServizio(int $id_tipo_servizio) Return the first ChildCostiServizio filtered by the id_tipo_servizio column
 * @method     ChildCostiServizio findOneByInizioPeriodo(string $inizio_periodo) Return the first ChildCostiServizio filtered by the inizio_periodo column
 * @method     ChildCostiServizio findOneByFinePeriodo(string $fine_periodo) Return the first ChildCostiServizio filtered by the fine_periodo column
 * @method     ChildCostiServizio findOneByCosto(double $costo) Return the first ChildCostiServizio filtered by the costo column *

 * @method     ChildCostiServizio requirePk($key, ConnectionInterface $con = null) Return the ChildCostiServizio by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCostiServizio requireOne(ConnectionInterface $con = null) Return the first ChildCostiServizio matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildCostiServizio requireOneByIdCosto(int $id_costo) Return the first ChildCostiServizio filtered by the id_costo column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCostiServizio requireOneByIdTipoServizio(int $id_tipo_servizio) Return the first ChildCostiServizio filtered by the id_tipo_servizio column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCostiServizio requireOneByInizioPeriodo(string $inizio_periodo) Return the first ChildCostiServizio filtered by the inizio_periodo column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCostiServizio requireOneByFinePeriodo(string $fine_periodo) Return the first ChildCostiServizio filtered by the fine_periodo column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCostiServizio requireOneByCosto(double $costo) Return the first ChildCostiServizio filtered by the costo column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildCostiServizio[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildCostiServizio objects based on current ModelCriteria
 * @method     ChildCostiServizio[]|ObjectCollection findByIdCosto(int $id_costo) Return ChildCostiServizio objects filtered by the id_costo column
 * @method     ChildCostiServizio[]|ObjectCollection findByIdTipoServizio(int $id_tipo_servizio) Return ChildCostiServizio objects filtered by the id_tipo_servizio column
 * @method     ChildCostiServizio[]|ObjectCollection findByInizioPeriodo(string $inizio_periodo) Return ChildCostiServizio objects filtered by the inizio_periodo column
 * @method     ChildCostiServizio[]|ObjectCollection findByFinePeriodo(string $fine_periodo) Return ChildCostiServizio objects filtered by the fine_periodo column
 * @method     ChildCostiServizio[]|ObjectCollection findByCosto(double $costo) Return ChildCostiServizio objects filtered by the costo column
 * @method     ChildCostiServizio[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class CostiServizioQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\CostiServizioQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'dbspiaggie', $modelName = '\\CostiServizio', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildCostiServizioQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildCostiServizioQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildCostiServizioQuery) {
            return $criteria;
        }
        $query = new ChildCostiServizioQuery();
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
     * @return ChildCostiServizio|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(CostiServizioTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = CostiServizioTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildCostiServizio A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id_costo, id_tipo_servizio, inizio_periodo, fine_periodo, costo FROM costi_servizio WHERE id_costo = :p0';
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
            /** @var ChildCostiServizio $obj */
            $obj = new ChildCostiServizio();
            $obj->hydrate($row);
            CostiServizioTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildCostiServizio|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildCostiServizioQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(CostiServizioTableMap::COL_ID_COSTO, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildCostiServizioQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(CostiServizioTableMap::COL_ID_COSTO, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the id_costo column
     *
     * Example usage:
     * <code>
     * $query->filterByIdCosto(1234); // WHERE id_costo = 1234
     * $query->filterByIdCosto(array(12, 34)); // WHERE id_costo IN (12, 34)
     * $query->filterByIdCosto(array('min' => 12)); // WHERE id_costo > 12
     * </code>
     *
     * @param     mixed $idCosto The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCostiServizioQuery The current query, for fluid interface
     */
    public function filterByIdCosto($idCosto = null, $comparison = null)
    {
        if (is_array($idCosto)) {
            $useMinMax = false;
            if (isset($idCosto['min'])) {
                $this->addUsingAlias(CostiServizioTableMap::COL_ID_COSTO, $idCosto['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($idCosto['max'])) {
                $this->addUsingAlias(CostiServizioTableMap::COL_ID_COSTO, $idCosto['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CostiServizioTableMap::COL_ID_COSTO, $idCosto, $comparison);
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
     * @see       filterByTipiServizio()
     *
     * @param     mixed $idTipoServizio The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCostiServizioQuery The current query, for fluid interface
     */
    public function filterByIdTipoServizio($idTipoServizio = null, $comparison = null)
    {
        if (is_array($idTipoServizio)) {
            $useMinMax = false;
            if (isset($idTipoServizio['min'])) {
                $this->addUsingAlias(CostiServizioTableMap::COL_ID_TIPO_SERVIZIO, $idTipoServizio['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($idTipoServizio['max'])) {
                $this->addUsingAlias(CostiServizioTableMap::COL_ID_TIPO_SERVIZIO, $idTipoServizio['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CostiServizioTableMap::COL_ID_TIPO_SERVIZIO, $idTipoServizio, $comparison);
    }

    /**
     * Filter the query on the inizio_periodo column
     *
     * Example usage:
     * <code>
     * $query->filterByInizioPeriodo('2011-03-14'); // WHERE inizio_periodo = '2011-03-14'
     * $query->filterByInizioPeriodo('now'); // WHERE inizio_periodo = '2011-03-14'
     * $query->filterByInizioPeriodo(array('max' => 'yesterday')); // WHERE inizio_periodo > '2011-03-13'
     * </code>
     *
     * @param     mixed $inizioPeriodo The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCostiServizioQuery The current query, for fluid interface
     */
    public function filterByInizioPeriodo($inizioPeriodo = null, $comparison = null)
    {
        if (is_array($inizioPeriodo)) {
            $useMinMax = false;
            if (isset($inizioPeriodo['min'])) {
                $this->addUsingAlias(CostiServizioTableMap::COL_INIZIO_PERIODO, $inizioPeriodo['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($inizioPeriodo['max'])) {
                $this->addUsingAlias(CostiServizioTableMap::COL_INIZIO_PERIODO, $inizioPeriodo['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CostiServizioTableMap::COL_INIZIO_PERIODO, $inizioPeriodo, $comparison);
    }

    /**
     * Filter the query on the fine_periodo column
     *
     * Example usage:
     * <code>
     * $query->filterByFinePeriodo('2011-03-14'); // WHERE fine_periodo = '2011-03-14'
     * $query->filterByFinePeriodo('now'); // WHERE fine_periodo = '2011-03-14'
     * $query->filterByFinePeriodo(array('max' => 'yesterday')); // WHERE fine_periodo > '2011-03-13'
     * </code>
     *
     * @param     mixed $finePeriodo The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCostiServizioQuery The current query, for fluid interface
     */
    public function filterByFinePeriodo($finePeriodo = null, $comparison = null)
    {
        if (is_array($finePeriodo)) {
            $useMinMax = false;
            if (isset($finePeriodo['min'])) {
                $this->addUsingAlias(CostiServizioTableMap::COL_FINE_PERIODO, $finePeriodo['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($finePeriodo['max'])) {
                $this->addUsingAlias(CostiServizioTableMap::COL_FINE_PERIODO, $finePeriodo['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CostiServizioTableMap::COL_FINE_PERIODO, $finePeriodo, $comparison);
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
     * @return $this|ChildCostiServizioQuery The current query, for fluid interface
     */
    public function filterByCosto($costo = null, $comparison = null)
    {
        if (is_array($costo)) {
            $useMinMax = false;
            if (isset($costo['min'])) {
                $this->addUsingAlias(CostiServizioTableMap::COL_COSTO, $costo['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($costo['max'])) {
                $this->addUsingAlias(CostiServizioTableMap::COL_COSTO, $costo['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CostiServizioTableMap::COL_COSTO, $costo, $comparison);
    }

    /**
     * Filter the query by a related \TipiServizio object
     *
     * @param \TipiServizio|ObjectCollection $tipiServizio The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildCostiServizioQuery The current query, for fluid interface
     */
    public function filterByTipiServizio($tipiServizio, $comparison = null)
    {
        if ($tipiServizio instanceof \TipiServizio) {
            return $this
                ->addUsingAlias(CostiServizioTableMap::COL_ID_TIPO_SERVIZIO, $tipiServizio->getIdTipoServizio(), $comparison);
        } elseif ($tipiServizio instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(CostiServizioTableMap::COL_ID_TIPO_SERVIZIO, $tipiServizio->toKeyValue('PrimaryKey', 'IdTipoServizio'), $comparison);
        } else {
            throw new PropelException('filterByTipiServizio() only accepts arguments of type \TipiServizio or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the TipiServizio relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildCostiServizioQuery The current query, for fluid interface
     */
    public function joinTipiServizio($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('TipiServizio');

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
            $this->addJoinObject($join, 'TipiServizio');
        }

        return $this;
    }

    /**
     * Use the TipiServizio relation TipiServizio object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \TipiServizioQuery A secondary query class using the current class as primary query
     */
    public function useTipiServizioQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinTipiServizio($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'TipiServizio', '\TipiServizioQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildCostiServizio $costiServizio Object to remove from the list of results
     *
     * @return $this|ChildCostiServizioQuery The current query, for fluid interface
     */
    public function prune($costiServizio = null)
    {
        if ($costiServizio) {
            $this->addUsingAlias(CostiServizioTableMap::COL_ID_COSTO, $costiServizio->getIdCosto(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the costi_servizio table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(CostiServizioTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            CostiServizioTableMap::clearInstancePool();
            CostiServizioTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(CostiServizioTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(CostiServizioTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            CostiServizioTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            CostiServizioTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // CostiServizioQuery
