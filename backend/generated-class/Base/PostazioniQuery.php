<?php

namespace Base;

use \Postazioni as ChildPostazioni;
use \PostazioniQuery as ChildPostazioniQuery;
use \Exception;
use \PDO;
use Map\PostazioniTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'postazioni' table.
 *
 *
 *
 * @method     ChildPostazioniQuery orderByIdPostazione($order = Criteria::ASC) Order by the id_postazione column
 * @method     ChildPostazioniQuery orderByFila($order = Criteria::ASC) Order by the fila column
 * @method     ChildPostazioniQuery orderByColonna($order = Criteria::ASC) Order by the colonna column
 * @method     ChildPostazioniQuery orderBySettore($order = Criteria::ASC) Order by the settore column
 * @method     ChildPostazioniQuery orderByX($order = Criteria::ASC) Order by the x column
 * @method     ChildPostazioniQuery orderByY($order = Criteria::ASC) Order by the y column
 * @method     ChildPostazioniQuery orderByNote($order = Criteria::ASC) Order by the note column
 *
 * @method     ChildPostazioniQuery groupByIdPostazione() Group by the id_postazione column
 * @method     ChildPostazioniQuery groupByFila() Group by the fila column
 * @method     ChildPostazioniQuery groupByColonna() Group by the colonna column
 * @method     ChildPostazioniQuery groupBySettore() Group by the settore column
 * @method     ChildPostazioniQuery groupByX() Group by the x column
 * @method     ChildPostazioniQuery groupByY() Group by the y column
 * @method     ChildPostazioniQuery groupByNote() Group by the note column
 *
 * @method     ChildPostazioniQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildPostazioniQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildPostazioniQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildPostazioniQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildPostazioniQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildPostazioniQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildPostazioniQuery leftJoinAssegnamentiPostazione($relationAlias = null) Adds a LEFT JOIN clause to the query using the AssegnamentiPostazione relation
 * @method     ChildPostazioniQuery rightJoinAssegnamentiPostazione($relationAlias = null) Adds a RIGHT JOIN clause to the query using the AssegnamentiPostazione relation
 * @method     ChildPostazioniQuery innerJoinAssegnamentiPostazione($relationAlias = null) Adds a INNER JOIN clause to the query using the AssegnamentiPostazione relation
 *
 * @method     ChildPostazioniQuery joinWithAssegnamentiPostazione($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the AssegnamentiPostazione relation
 *
 * @method     ChildPostazioniQuery leftJoinWithAssegnamentiPostazione() Adds a LEFT JOIN clause and with to the query using the AssegnamentiPostazione relation
 * @method     ChildPostazioniQuery rightJoinWithAssegnamentiPostazione() Adds a RIGHT JOIN clause and with to the query using the AssegnamentiPostazione relation
 * @method     ChildPostazioniQuery innerJoinWithAssegnamentiPostazione() Adds a INNER JOIN clause and with to the query using the AssegnamentiPostazione relation
 *
 * @method     \AssegnamentiPostazioneQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildPostazioni findOne(ConnectionInterface $con = null) Return the first ChildPostazioni matching the query
 * @method     ChildPostazioni findOneOrCreate(ConnectionInterface $con = null) Return the first ChildPostazioni matching the query, or a new ChildPostazioni object populated from the query conditions when no match is found
 *
 * @method     ChildPostazioni findOneByIdPostazione(int $id_postazione) Return the first ChildPostazioni filtered by the id_postazione column
 * @method     ChildPostazioni findOneByFila(string $fila) Return the first ChildPostazioni filtered by the fila column
 * @method     ChildPostazioni findOneByColonna(string $colonna) Return the first ChildPostazioni filtered by the colonna column
 * @method     ChildPostazioni findOneBySettore(string $settore) Return the first ChildPostazioni filtered by the settore column
 * @method     ChildPostazioni findOneByX(int $x) Return the first ChildPostazioni filtered by the x column
 * @method     ChildPostazioni findOneByY(int $y) Return the first ChildPostazioni filtered by the y column
 * @method     ChildPostazioni findOneByNote(string $note) Return the first ChildPostazioni filtered by the note column *

 * @method     ChildPostazioni requirePk($key, ConnectionInterface $con = null) Return the ChildPostazioni by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPostazioni requireOne(ConnectionInterface $con = null) Return the first ChildPostazioni matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildPostazioni requireOneByIdPostazione(int $id_postazione) Return the first ChildPostazioni filtered by the id_postazione column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPostazioni requireOneByFila(string $fila) Return the first ChildPostazioni filtered by the fila column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPostazioni requireOneByColonna(string $colonna) Return the first ChildPostazioni filtered by the colonna column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPostazioni requireOneBySettore(string $settore) Return the first ChildPostazioni filtered by the settore column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPostazioni requireOneByX(int $x) Return the first ChildPostazioni filtered by the x column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPostazioni requireOneByY(int $y) Return the first ChildPostazioni filtered by the y column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPostazioni requireOneByNote(string $note) Return the first ChildPostazioni filtered by the note column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildPostazioni[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildPostazioni objects based on current ModelCriteria
 * @method     ChildPostazioni[]|ObjectCollection findByIdPostazione(int $id_postazione) Return ChildPostazioni objects filtered by the id_postazione column
 * @method     ChildPostazioni[]|ObjectCollection findByFila(string $fila) Return ChildPostazioni objects filtered by the fila column
 * @method     ChildPostazioni[]|ObjectCollection findByColonna(string $colonna) Return ChildPostazioni objects filtered by the colonna column
 * @method     ChildPostazioni[]|ObjectCollection findBySettore(string $settore) Return ChildPostazioni objects filtered by the settore column
 * @method     ChildPostazioni[]|ObjectCollection findByX(int $x) Return ChildPostazioni objects filtered by the x column
 * @method     ChildPostazioni[]|ObjectCollection findByY(int $y) Return ChildPostazioni objects filtered by the y column
 * @method     ChildPostazioni[]|ObjectCollection findByNote(string $note) Return ChildPostazioni objects filtered by the note column
 * @method     ChildPostazioni[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class PostazioniQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\PostazioniQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'dbspiaggie', $modelName = '\\Postazioni', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildPostazioniQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildPostazioniQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildPostazioniQuery) {
            return $criteria;
        }
        $query = new ChildPostazioniQuery();
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
     * @return ChildPostazioni|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(PostazioniTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = PostazioniTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildPostazioni A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id_postazione, fila, colonna, settore, x, y, note FROM postazioni WHERE id_postazione = :p0';
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
            /** @var ChildPostazioni $obj */
            $obj = new ChildPostazioni();
            $obj->hydrate($row);
            PostazioniTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildPostazioni|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildPostazioniQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(PostazioniTableMap::COL_ID_POSTAZIONE, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildPostazioniQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(PostazioniTableMap::COL_ID_POSTAZIONE, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the id_postazione column
     *
     * Example usage:
     * <code>
     * $query->filterByIdPostazione(1234); // WHERE id_postazione = 1234
     * $query->filterByIdPostazione(array(12, 34)); // WHERE id_postazione IN (12, 34)
     * $query->filterByIdPostazione(array('min' => 12)); // WHERE id_postazione > 12
     * </code>
     *
     * @param     mixed $idPostazione The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPostazioniQuery The current query, for fluid interface
     */
    public function filterByIdPostazione($idPostazione = null, $comparison = null)
    {
        if (is_array($idPostazione)) {
            $useMinMax = false;
            if (isset($idPostazione['min'])) {
                $this->addUsingAlias(PostazioniTableMap::COL_ID_POSTAZIONE, $idPostazione['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($idPostazione['max'])) {
                $this->addUsingAlias(PostazioniTableMap::COL_ID_POSTAZIONE, $idPostazione['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PostazioniTableMap::COL_ID_POSTAZIONE, $idPostazione, $comparison);
    }

    /**
     * Filter the query on the fila column
     *
     * Example usage:
     * <code>
     * $query->filterByFila('fooValue');   // WHERE fila = 'fooValue'
     * $query->filterByFila('%fooValue%', Criteria::LIKE); // WHERE fila LIKE '%fooValue%'
     * </code>
     *
     * @param     string $fila The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPostazioniQuery The current query, for fluid interface
     */
    public function filterByFila($fila = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($fila)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PostazioniTableMap::COL_FILA, $fila, $comparison);
    }

    /**
     * Filter the query on the colonna column
     *
     * Example usage:
     * <code>
     * $query->filterByColonna('fooValue');   // WHERE colonna = 'fooValue'
     * $query->filterByColonna('%fooValue%', Criteria::LIKE); // WHERE colonna LIKE '%fooValue%'
     * </code>
     *
     * @param     string $colonna The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPostazioniQuery The current query, for fluid interface
     */
    public function filterByColonna($colonna = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($colonna)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PostazioniTableMap::COL_COLONNA, $colonna, $comparison);
    }

    /**
     * Filter the query on the settore column
     *
     * Example usage:
     * <code>
     * $query->filterBySettore('fooValue');   // WHERE settore = 'fooValue'
     * $query->filterBySettore('%fooValue%', Criteria::LIKE); // WHERE settore LIKE '%fooValue%'
     * </code>
     *
     * @param     string $settore The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPostazioniQuery The current query, for fluid interface
     */
    public function filterBySettore($settore = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($settore)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PostazioniTableMap::COL_SETTORE, $settore, $comparison);
    }

    /**
     * Filter the query on the x column
     *
     * Example usage:
     * <code>
     * $query->filterByX(1234); // WHERE x = 1234
     * $query->filterByX(array(12, 34)); // WHERE x IN (12, 34)
     * $query->filterByX(array('min' => 12)); // WHERE x > 12
     * </code>
     *
     * @param     mixed $x The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPostazioniQuery The current query, for fluid interface
     */
    public function filterByX($x = null, $comparison = null)
    {
        if (is_array($x)) {
            $useMinMax = false;
            if (isset($x['min'])) {
                $this->addUsingAlias(PostazioniTableMap::COL_X, $x['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($x['max'])) {
                $this->addUsingAlias(PostazioniTableMap::COL_X, $x['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PostazioniTableMap::COL_X, $x, $comparison);
    }

    /**
     * Filter the query on the y column
     *
     * Example usage:
     * <code>
     * $query->filterByY(1234); // WHERE y = 1234
     * $query->filterByY(array(12, 34)); // WHERE y IN (12, 34)
     * $query->filterByY(array('min' => 12)); // WHERE y > 12
     * </code>
     *
     * @param     mixed $y The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPostazioniQuery The current query, for fluid interface
     */
    public function filterByY($y = null, $comparison = null)
    {
        if (is_array($y)) {
            $useMinMax = false;
            if (isset($y['min'])) {
                $this->addUsingAlias(PostazioniTableMap::COL_Y, $y['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($y['max'])) {
                $this->addUsingAlias(PostazioniTableMap::COL_Y, $y['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PostazioniTableMap::COL_Y, $y, $comparison);
    }

    /**
     * Filter the query on the note column
     *
     * Example usage:
     * <code>
     * $query->filterByNote('fooValue');   // WHERE note = 'fooValue'
     * $query->filterByNote('%fooValue%', Criteria::LIKE); // WHERE note LIKE '%fooValue%'
     * </code>
     *
     * @param     string $note The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPostazioniQuery The current query, for fluid interface
     */
    public function filterByNote($note = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($note)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PostazioniTableMap::COL_NOTE, $note, $comparison);
    }

    /**
     * Filter the query by a related \AssegnamentiPostazione object
     *
     * @param \AssegnamentiPostazione|ObjectCollection $assegnamentiPostazione the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPostazioniQuery The current query, for fluid interface
     */
    public function filterByAssegnamentiPostazione($assegnamentiPostazione, $comparison = null)
    {
        if ($assegnamentiPostazione instanceof \AssegnamentiPostazione) {
            return $this
                ->addUsingAlias(PostazioniTableMap::COL_ID_POSTAZIONE, $assegnamentiPostazione->getIdPostazione(), $comparison);
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
     * @return $this|ChildPostazioniQuery The current query, for fluid interface
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
     * @param   ChildPostazioni $postazioni Object to remove from the list of results
     *
     * @return $this|ChildPostazioniQuery The current query, for fluid interface
     */
    public function prune($postazioni = null)
    {
        if ($postazioni) {
            $this->addUsingAlias(PostazioniTableMap::COL_ID_POSTAZIONE, $postazioni->getIdPostazione(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the postazioni table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(PostazioniTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            PostazioniTableMap::clearInstancePool();
            PostazioniTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(PostazioniTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(PostazioniTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            PostazioniTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            PostazioniTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // PostazioniQuery
