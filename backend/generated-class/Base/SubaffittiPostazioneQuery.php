<?php

namespace Base;

use \SubaffittiPostazione as ChildSubaffittiPostazione;
use \SubaffittiPostazioneQuery as ChildSubaffittiPostazioneQuery;
use \Exception;
use \PDO;
use Map\SubaffittiPostazioneTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'subaffitti_postazione' table.
 *
 *
 *
 * @method     ChildSubaffittiPostazioneQuery orderByIdSubaffittoPostazione($order = Criteria::ASC) Order by the id_subaffitto_postazione column
 * @method     ChildSubaffittiPostazioneQuery orderByIdDisponibilitaPostazioni($order = Criteria::ASC) Order by the id_disponibilita_postazioni column
 * @method     ChildSubaffittiPostazioneQuery orderByDataInizio($order = Criteria::ASC) Order by the data_inizio column
 * @method     ChildSubaffittiPostazioneQuery orderByDataFine($order = Criteria::ASC) Order by the data_fine column
 *
 * @method     ChildSubaffittiPostazioneQuery groupByIdSubaffittoPostazione() Group by the id_subaffitto_postazione column
 * @method     ChildSubaffittiPostazioneQuery groupByIdDisponibilitaPostazioni() Group by the id_disponibilita_postazioni column
 * @method     ChildSubaffittiPostazioneQuery groupByDataInizio() Group by the data_inizio column
 * @method     ChildSubaffittiPostazioneQuery groupByDataFine() Group by the data_fine column
 *
 * @method     ChildSubaffittiPostazioneQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildSubaffittiPostazioneQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildSubaffittiPostazioneQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildSubaffittiPostazioneQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildSubaffittiPostazioneQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildSubaffittiPostazioneQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildSubaffittiPostazioneQuery leftJoinDisponibilitaPostazione($relationAlias = null) Adds a LEFT JOIN clause to the query using the DisponibilitaPostazione relation
 * @method     ChildSubaffittiPostazioneQuery rightJoinDisponibilitaPostazione($relationAlias = null) Adds a RIGHT JOIN clause to the query using the DisponibilitaPostazione relation
 * @method     ChildSubaffittiPostazioneQuery innerJoinDisponibilitaPostazione($relationAlias = null) Adds a INNER JOIN clause to the query using the DisponibilitaPostazione relation
 *
 * @method     ChildSubaffittiPostazioneQuery joinWithDisponibilitaPostazione($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the DisponibilitaPostazione relation
 *
 * @method     ChildSubaffittiPostazioneQuery leftJoinWithDisponibilitaPostazione() Adds a LEFT JOIN clause and with to the query using the DisponibilitaPostazione relation
 * @method     ChildSubaffittiPostazioneQuery rightJoinWithDisponibilitaPostazione() Adds a RIGHT JOIN clause and with to the query using the DisponibilitaPostazione relation
 * @method     ChildSubaffittiPostazioneQuery innerJoinWithDisponibilitaPostazione() Adds a INNER JOIN clause and with to the query using the DisponibilitaPostazione relation
 *
 * @method     \DisponibilitaPostazioneQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildSubaffittiPostazione findOne(ConnectionInterface $con = null) Return the first ChildSubaffittiPostazione matching the query
 * @method     ChildSubaffittiPostazione findOneOrCreate(ConnectionInterface $con = null) Return the first ChildSubaffittiPostazione matching the query, or a new ChildSubaffittiPostazione object populated from the query conditions when no match is found
 *
 * @method     ChildSubaffittiPostazione findOneByIdSubaffittoPostazione(int $id_subaffitto_postazione) Return the first ChildSubaffittiPostazione filtered by the id_subaffitto_postazione column
 * @method     ChildSubaffittiPostazione findOneByIdDisponibilitaPostazioni(int $id_disponibilita_postazioni) Return the first ChildSubaffittiPostazione filtered by the id_disponibilita_postazioni column
 * @method     ChildSubaffittiPostazione findOneByDataInizio(string $data_inizio) Return the first ChildSubaffittiPostazione filtered by the data_inizio column
 * @method     ChildSubaffittiPostazione findOneByDataFine(string $data_fine) Return the first ChildSubaffittiPostazione filtered by the data_fine column *

 * @method     ChildSubaffittiPostazione requirePk($key, ConnectionInterface $con = null) Return the ChildSubaffittiPostazione by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSubaffittiPostazione requireOne(ConnectionInterface $con = null) Return the first ChildSubaffittiPostazione matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildSubaffittiPostazione requireOneByIdSubaffittoPostazione(int $id_subaffitto_postazione) Return the first ChildSubaffittiPostazione filtered by the id_subaffitto_postazione column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSubaffittiPostazione requireOneByIdDisponibilitaPostazioni(int $id_disponibilita_postazioni) Return the first ChildSubaffittiPostazione filtered by the id_disponibilita_postazioni column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSubaffittiPostazione requireOneByDataInizio(string $data_inizio) Return the first ChildSubaffittiPostazione filtered by the data_inizio column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSubaffittiPostazione requireOneByDataFine(string $data_fine) Return the first ChildSubaffittiPostazione filtered by the data_fine column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildSubaffittiPostazione[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildSubaffittiPostazione objects based on current ModelCriteria
 * @method     ChildSubaffittiPostazione[]|ObjectCollection findByIdSubaffittoPostazione(int $id_subaffitto_postazione) Return ChildSubaffittiPostazione objects filtered by the id_subaffitto_postazione column
 * @method     ChildSubaffittiPostazione[]|ObjectCollection findByIdDisponibilitaPostazioni(int $id_disponibilita_postazioni) Return ChildSubaffittiPostazione objects filtered by the id_disponibilita_postazioni column
 * @method     ChildSubaffittiPostazione[]|ObjectCollection findByDataInizio(string $data_inizio) Return ChildSubaffittiPostazione objects filtered by the data_inizio column
 * @method     ChildSubaffittiPostazione[]|ObjectCollection findByDataFine(string $data_fine) Return ChildSubaffittiPostazione objects filtered by the data_fine column
 * @method     ChildSubaffittiPostazione[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class SubaffittiPostazioneQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\SubaffittiPostazioneQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'dbspiaggie', $modelName = '\\SubaffittiPostazione', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildSubaffittiPostazioneQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildSubaffittiPostazioneQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildSubaffittiPostazioneQuery) {
            return $criteria;
        }
        $query = new ChildSubaffittiPostazioneQuery();
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
     * @return ChildSubaffittiPostazione|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(SubaffittiPostazioneTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = SubaffittiPostazioneTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildSubaffittiPostazione A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id_subaffitto_postazione, id_disponibilita_postazioni, data_inizio, data_fine FROM subaffitti_postazione WHERE id_subaffitto_postazione = :p0';
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
            /** @var ChildSubaffittiPostazione $obj */
            $obj = new ChildSubaffittiPostazione();
            $obj->hydrate($row);
            SubaffittiPostazioneTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildSubaffittiPostazione|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildSubaffittiPostazioneQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(SubaffittiPostazioneTableMap::COL_ID_SUBAFFITTO_POSTAZIONE, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildSubaffittiPostazioneQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(SubaffittiPostazioneTableMap::COL_ID_SUBAFFITTO_POSTAZIONE, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the id_subaffitto_postazione column
     *
     * Example usage:
     * <code>
     * $query->filterByIdSubaffittoPostazione(1234); // WHERE id_subaffitto_postazione = 1234
     * $query->filterByIdSubaffittoPostazione(array(12, 34)); // WHERE id_subaffitto_postazione IN (12, 34)
     * $query->filterByIdSubaffittoPostazione(array('min' => 12)); // WHERE id_subaffitto_postazione > 12
     * </code>
     *
     * @param     mixed $idSubaffittoPostazione The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSubaffittiPostazioneQuery The current query, for fluid interface
     */
    public function filterByIdSubaffittoPostazione($idSubaffittoPostazione = null, $comparison = null)
    {
        if (is_array($idSubaffittoPostazione)) {
            $useMinMax = false;
            if (isset($idSubaffittoPostazione['min'])) {
                $this->addUsingAlias(SubaffittiPostazioneTableMap::COL_ID_SUBAFFITTO_POSTAZIONE, $idSubaffittoPostazione['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($idSubaffittoPostazione['max'])) {
                $this->addUsingAlias(SubaffittiPostazioneTableMap::COL_ID_SUBAFFITTO_POSTAZIONE, $idSubaffittoPostazione['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SubaffittiPostazioneTableMap::COL_ID_SUBAFFITTO_POSTAZIONE, $idSubaffittoPostazione, $comparison);
    }

    /**
     * Filter the query on the id_disponibilita_postazioni column
     *
     * Example usage:
     * <code>
     * $query->filterByIdDisponibilitaPostazioni(1234); // WHERE id_disponibilita_postazioni = 1234
     * $query->filterByIdDisponibilitaPostazioni(array(12, 34)); // WHERE id_disponibilita_postazioni IN (12, 34)
     * $query->filterByIdDisponibilitaPostazioni(array('min' => 12)); // WHERE id_disponibilita_postazioni > 12
     * </code>
     *
     * @see       filterByDisponibilitaPostazione()
     *
     * @param     mixed $idDisponibilitaPostazioni The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSubaffittiPostazioneQuery The current query, for fluid interface
     */
    public function filterByIdDisponibilitaPostazioni($idDisponibilitaPostazioni = null, $comparison = null)
    {
        if (is_array($idDisponibilitaPostazioni)) {
            $useMinMax = false;
            if (isset($idDisponibilitaPostazioni['min'])) {
                $this->addUsingAlias(SubaffittiPostazioneTableMap::COL_ID_DISPONIBILITA_POSTAZIONI, $idDisponibilitaPostazioni['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($idDisponibilitaPostazioni['max'])) {
                $this->addUsingAlias(SubaffittiPostazioneTableMap::COL_ID_DISPONIBILITA_POSTAZIONI, $idDisponibilitaPostazioni['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SubaffittiPostazioneTableMap::COL_ID_DISPONIBILITA_POSTAZIONI, $idDisponibilitaPostazioni, $comparison);
    }

    /**
     * Filter the query on the data_inizio column
     *
     * Example usage:
     * <code>
     * $query->filterByDataInizio('2011-03-14'); // WHERE data_inizio = '2011-03-14'
     * $query->filterByDataInizio('now'); // WHERE data_inizio = '2011-03-14'
     * $query->filterByDataInizio(array('max' => 'yesterday')); // WHERE data_inizio > '2011-03-13'
     * </code>
     *
     * @param     mixed $dataInizio The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSubaffittiPostazioneQuery The current query, for fluid interface
     */
    public function filterByDataInizio($dataInizio = null, $comparison = null)
    {
        if (is_array($dataInizio)) {
            $useMinMax = false;
            if (isset($dataInizio['min'])) {
                $this->addUsingAlias(SubaffittiPostazioneTableMap::COL_DATA_INIZIO, $dataInizio['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($dataInizio['max'])) {
                $this->addUsingAlias(SubaffittiPostazioneTableMap::COL_DATA_INIZIO, $dataInizio['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SubaffittiPostazioneTableMap::COL_DATA_INIZIO, $dataInizio, $comparison);
    }

    /**
     * Filter the query on the data_fine column
     *
     * Example usage:
     * <code>
     * $query->filterByDataFine('2011-03-14'); // WHERE data_fine = '2011-03-14'
     * $query->filterByDataFine('now'); // WHERE data_fine = '2011-03-14'
     * $query->filterByDataFine(array('max' => 'yesterday')); // WHERE data_fine > '2011-03-13'
     * </code>
     *
     * @param     mixed $dataFine The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSubaffittiPostazioneQuery The current query, for fluid interface
     */
    public function filterByDataFine($dataFine = null, $comparison = null)
    {
        if (is_array($dataFine)) {
            $useMinMax = false;
            if (isset($dataFine['min'])) {
                $this->addUsingAlias(SubaffittiPostazioneTableMap::COL_DATA_FINE, $dataFine['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($dataFine['max'])) {
                $this->addUsingAlias(SubaffittiPostazioneTableMap::COL_DATA_FINE, $dataFine['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SubaffittiPostazioneTableMap::COL_DATA_FINE, $dataFine, $comparison);
    }

    /**
     * Filter the query by a related \DisponibilitaPostazione object
     *
     * @param \DisponibilitaPostazione|ObjectCollection $disponibilitaPostazione The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildSubaffittiPostazioneQuery The current query, for fluid interface
     */
    public function filterByDisponibilitaPostazione($disponibilitaPostazione, $comparison = null)
    {
        if ($disponibilitaPostazione instanceof \DisponibilitaPostazione) {
            return $this
                ->addUsingAlias(SubaffittiPostazioneTableMap::COL_ID_DISPONIBILITA_POSTAZIONI, $disponibilitaPostazione->getIdDisponibilitaPostazione(), $comparison);
        } elseif ($disponibilitaPostazione instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(SubaffittiPostazioneTableMap::COL_ID_DISPONIBILITA_POSTAZIONI, $disponibilitaPostazione->toKeyValue('PrimaryKey', 'IdDisponibilitaPostazione'), $comparison);
        } else {
            throw new PropelException('filterByDisponibilitaPostazione() only accepts arguments of type \DisponibilitaPostazione or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the DisponibilitaPostazione relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildSubaffittiPostazioneQuery The current query, for fluid interface
     */
    public function joinDisponibilitaPostazione($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('DisponibilitaPostazione');

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
            $this->addJoinObject($join, 'DisponibilitaPostazione');
        }

        return $this;
    }

    /**
     * Use the DisponibilitaPostazione relation DisponibilitaPostazione object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \DisponibilitaPostazioneQuery A secondary query class using the current class as primary query
     */
    public function useDisponibilitaPostazioneQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinDisponibilitaPostazione($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'DisponibilitaPostazione', '\DisponibilitaPostazioneQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildSubaffittiPostazione $subaffittiPostazione Object to remove from the list of results
     *
     * @return $this|ChildSubaffittiPostazioneQuery The current query, for fluid interface
     */
    public function prune($subaffittiPostazione = null)
    {
        if ($subaffittiPostazione) {
            $this->addUsingAlias(SubaffittiPostazioneTableMap::COL_ID_SUBAFFITTO_POSTAZIONE, $subaffittiPostazione->getIdSubaffittoPostazione(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the subaffitti_postazione table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(SubaffittiPostazioneTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            SubaffittiPostazioneTableMap::clearInstancePool();
            SubaffittiPostazioneTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(SubaffittiPostazioneTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(SubaffittiPostazioneTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            SubaffittiPostazioneTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            SubaffittiPostazioneTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // SubaffittiPostazioneQuery
