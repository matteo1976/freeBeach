<?php

namespace Base;

use \Servizi as ChildServizi;
use \ServiziQuery as ChildServiziQuery;
use \Exception;
use \PDO;
use Map\ServiziTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'servizi' table.
 *
 *
 *
 * @method     ChildServiziQuery orderByIdServizio($order = Criteria::ASC) Order by the id_servizio column
 * @method     ChildServiziQuery orderByIdAssegnamentoPostazione($order = Criteria::ASC) Order by the id_assegnamento_postazione column
 * @method     ChildServiziQuery orderByIdTipoServizio($order = Criteria::ASC) Order by the id_tipo_servizio column
 * @method     ChildServiziQuery orderByDataInizio($order = Criteria::ASC) Order by the data_inizio column
 * @method     ChildServiziQuery orderByDataFine($order = Criteria::ASC) Order by the data_fine column
 * @method     ChildServiziQuery orderByQta($order = Criteria::ASC) Order by the qta column
 * @method     ChildServiziQuery orderByCostoFinale($order = Criteria::ASC) Order by the costo_finale column
 * @method     ChildServiziQuery orderByNote($order = Criteria::ASC) Order by the note column
 *
 * @method     ChildServiziQuery groupByIdServizio() Group by the id_servizio column
 * @method     ChildServiziQuery groupByIdAssegnamentoPostazione() Group by the id_assegnamento_postazione column
 * @method     ChildServiziQuery groupByIdTipoServizio() Group by the id_tipo_servizio column
 * @method     ChildServiziQuery groupByDataInizio() Group by the data_inizio column
 * @method     ChildServiziQuery groupByDataFine() Group by the data_fine column
 * @method     ChildServiziQuery groupByQta() Group by the qta column
 * @method     ChildServiziQuery groupByCostoFinale() Group by the costo_finale column
 * @method     ChildServiziQuery groupByNote() Group by the note column
 *
 * @method     ChildServiziQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildServiziQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildServiziQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildServiziQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildServiziQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildServiziQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildServiziQuery leftJoinAssegnamentiPostazione($relationAlias = null) Adds a LEFT JOIN clause to the query using the AssegnamentiPostazione relation
 * @method     ChildServiziQuery rightJoinAssegnamentiPostazione($relationAlias = null) Adds a RIGHT JOIN clause to the query using the AssegnamentiPostazione relation
 * @method     ChildServiziQuery innerJoinAssegnamentiPostazione($relationAlias = null) Adds a INNER JOIN clause to the query using the AssegnamentiPostazione relation
 *
 * @method     ChildServiziQuery joinWithAssegnamentiPostazione($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the AssegnamentiPostazione relation
 *
 * @method     ChildServiziQuery leftJoinWithAssegnamentiPostazione() Adds a LEFT JOIN clause and with to the query using the AssegnamentiPostazione relation
 * @method     ChildServiziQuery rightJoinWithAssegnamentiPostazione() Adds a RIGHT JOIN clause and with to the query using the AssegnamentiPostazione relation
 * @method     ChildServiziQuery innerJoinWithAssegnamentiPostazione() Adds a INNER JOIN clause and with to the query using the AssegnamentiPostazione relation
 *
 * @method     ChildServiziQuery leftJoinTipiServizio($relationAlias = null) Adds a LEFT JOIN clause to the query using the TipiServizio relation
 * @method     ChildServiziQuery rightJoinTipiServizio($relationAlias = null) Adds a RIGHT JOIN clause to the query using the TipiServizio relation
 * @method     ChildServiziQuery innerJoinTipiServizio($relationAlias = null) Adds a INNER JOIN clause to the query using the TipiServizio relation
 *
 * @method     ChildServiziQuery joinWithTipiServizio($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the TipiServizio relation
 *
 * @method     ChildServiziQuery leftJoinWithTipiServizio() Adds a LEFT JOIN clause and with to the query using the TipiServizio relation
 * @method     ChildServiziQuery rightJoinWithTipiServizio() Adds a RIGHT JOIN clause and with to the query using the TipiServizio relation
 * @method     ChildServiziQuery innerJoinWithTipiServizio() Adds a INNER JOIN clause and with to the query using the TipiServizio relation
 *
 * @method     \AssegnamentiPostazioneQuery|\TipiServizioQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildServizi findOne(ConnectionInterface $con = null) Return the first ChildServizi matching the query
 * @method     ChildServizi findOneOrCreate(ConnectionInterface $con = null) Return the first ChildServizi matching the query, or a new ChildServizi object populated from the query conditions when no match is found
 *
 * @method     ChildServizi findOneByIdServizio(int $id_servizio) Return the first ChildServizi filtered by the id_servizio column
 * @method     ChildServizi findOneByIdAssegnamentoPostazione(int $id_assegnamento_postazione) Return the first ChildServizi filtered by the id_assegnamento_postazione column
 * @method     ChildServizi findOneByIdTipoServizio(int $id_tipo_servizio) Return the first ChildServizi filtered by the id_tipo_servizio column
 * @method     ChildServizi findOneByDataInizio(string $data_inizio) Return the first ChildServizi filtered by the data_inizio column
 * @method     ChildServizi findOneByDataFine(string $data_fine) Return the first ChildServizi filtered by the data_fine column
 * @method     ChildServizi findOneByQta(int $qta) Return the first ChildServizi filtered by the qta column
 * @method     ChildServizi findOneByCostoFinale(double $costo_finale) Return the first ChildServizi filtered by the costo_finale column
 * @method     ChildServizi findOneByNote(string $note) Return the first ChildServizi filtered by the note column *

 * @method     ChildServizi requirePk($key, ConnectionInterface $con = null) Return the ChildServizi by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildServizi requireOne(ConnectionInterface $con = null) Return the first ChildServizi matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildServizi requireOneByIdServizio(int $id_servizio) Return the first ChildServizi filtered by the id_servizio column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildServizi requireOneByIdAssegnamentoPostazione(int $id_assegnamento_postazione) Return the first ChildServizi filtered by the id_assegnamento_postazione column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildServizi requireOneByIdTipoServizio(int $id_tipo_servizio) Return the first ChildServizi filtered by the id_tipo_servizio column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildServizi requireOneByDataInizio(string $data_inizio) Return the first ChildServizi filtered by the data_inizio column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildServizi requireOneByDataFine(string $data_fine) Return the first ChildServizi filtered by the data_fine column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildServizi requireOneByQta(int $qta) Return the first ChildServizi filtered by the qta column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildServizi requireOneByCostoFinale(double $costo_finale) Return the first ChildServizi filtered by the costo_finale column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildServizi requireOneByNote(string $note) Return the first ChildServizi filtered by the note column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildServizi[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildServizi objects based on current ModelCriteria
 * @method     ChildServizi[]|ObjectCollection findByIdServizio(int $id_servizio) Return ChildServizi objects filtered by the id_servizio column
 * @method     ChildServizi[]|ObjectCollection findByIdAssegnamentoPostazione(int $id_assegnamento_postazione) Return ChildServizi objects filtered by the id_assegnamento_postazione column
 * @method     ChildServizi[]|ObjectCollection findByIdTipoServizio(int $id_tipo_servizio) Return ChildServizi objects filtered by the id_tipo_servizio column
 * @method     ChildServizi[]|ObjectCollection findByDataInizio(string $data_inizio) Return ChildServizi objects filtered by the data_inizio column
 * @method     ChildServizi[]|ObjectCollection findByDataFine(string $data_fine) Return ChildServizi objects filtered by the data_fine column
 * @method     ChildServizi[]|ObjectCollection findByQta(int $qta) Return ChildServizi objects filtered by the qta column
 * @method     ChildServizi[]|ObjectCollection findByCostoFinale(double $costo_finale) Return ChildServizi objects filtered by the costo_finale column
 * @method     ChildServizi[]|ObjectCollection findByNote(string $note) Return ChildServizi objects filtered by the note column
 * @method     ChildServizi[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class ServiziQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\ServiziQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'dbspiaggie', $modelName = '\\Servizi', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildServiziQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildServiziQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildServiziQuery) {
            return $criteria;
        }
        $query = new ChildServiziQuery();
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
     * @return ChildServizi|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(ServiziTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = ServiziTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildServizi A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id_servizio, id_assegnamento_postazione, id_tipo_servizio, data_inizio, data_fine, qta, costo_finale, note FROM servizi WHERE id_servizio = :p0';
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
            /** @var ChildServizi $obj */
            $obj = new ChildServizi();
            $obj->hydrate($row);
            ServiziTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildServizi|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildServiziQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(ServiziTableMap::COL_ID_SERVIZIO, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildServiziQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(ServiziTableMap::COL_ID_SERVIZIO, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the id_servizio column
     *
     * Example usage:
     * <code>
     * $query->filterByIdServizio(1234); // WHERE id_servizio = 1234
     * $query->filterByIdServizio(array(12, 34)); // WHERE id_servizio IN (12, 34)
     * $query->filterByIdServizio(array('min' => 12)); // WHERE id_servizio > 12
     * </code>
     *
     * @param     mixed $idServizio The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildServiziQuery The current query, for fluid interface
     */
    public function filterByIdServizio($idServizio = null, $comparison = null)
    {
        if (is_array($idServizio)) {
            $useMinMax = false;
            if (isset($idServizio['min'])) {
                $this->addUsingAlias(ServiziTableMap::COL_ID_SERVIZIO, $idServizio['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($idServizio['max'])) {
                $this->addUsingAlias(ServiziTableMap::COL_ID_SERVIZIO, $idServizio['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ServiziTableMap::COL_ID_SERVIZIO, $idServizio, $comparison);
    }

    /**
     * Filter the query on the id_assegnamento_postazione column
     *
     * Example usage:
     * <code>
     * $query->filterByIdAssegnamentoPostazione(1234); // WHERE id_assegnamento_postazione = 1234
     * $query->filterByIdAssegnamentoPostazione(array(12, 34)); // WHERE id_assegnamento_postazione IN (12, 34)
     * $query->filterByIdAssegnamentoPostazione(array('min' => 12)); // WHERE id_assegnamento_postazione > 12
     * </code>
     *
     * @see       filterByAssegnamentiPostazione()
     *
     * @param     mixed $idAssegnamentoPostazione The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildServiziQuery The current query, for fluid interface
     */
    public function filterByIdAssegnamentoPostazione($idAssegnamentoPostazione = null, $comparison = null)
    {
        if (is_array($idAssegnamentoPostazione)) {
            $useMinMax = false;
            if (isset($idAssegnamentoPostazione['min'])) {
                $this->addUsingAlias(ServiziTableMap::COL_ID_ASSEGNAMENTO_POSTAZIONE, $idAssegnamentoPostazione['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($idAssegnamentoPostazione['max'])) {
                $this->addUsingAlias(ServiziTableMap::COL_ID_ASSEGNAMENTO_POSTAZIONE, $idAssegnamentoPostazione['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ServiziTableMap::COL_ID_ASSEGNAMENTO_POSTAZIONE, $idAssegnamentoPostazione, $comparison);
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
     * @return $this|ChildServiziQuery The current query, for fluid interface
     */
    public function filterByIdTipoServizio($idTipoServizio = null, $comparison = null)
    {
        if (is_array($idTipoServizio)) {
            $useMinMax = false;
            if (isset($idTipoServizio['min'])) {
                $this->addUsingAlias(ServiziTableMap::COL_ID_TIPO_SERVIZIO, $idTipoServizio['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($idTipoServizio['max'])) {
                $this->addUsingAlias(ServiziTableMap::COL_ID_TIPO_SERVIZIO, $idTipoServizio['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ServiziTableMap::COL_ID_TIPO_SERVIZIO, $idTipoServizio, $comparison);
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
     * @return $this|ChildServiziQuery The current query, for fluid interface
     */
    public function filterByDataInizio($dataInizio = null, $comparison = null)
    {
        if (is_array($dataInizio)) {
            $useMinMax = false;
            if (isset($dataInizio['min'])) {
                $this->addUsingAlias(ServiziTableMap::COL_DATA_INIZIO, $dataInizio['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($dataInizio['max'])) {
                $this->addUsingAlias(ServiziTableMap::COL_DATA_INIZIO, $dataInizio['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ServiziTableMap::COL_DATA_INIZIO, $dataInizio, $comparison);
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
     * @return $this|ChildServiziQuery The current query, for fluid interface
     */
    public function filterByDataFine($dataFine = null, $comparison = null)
    {
        if (is_array($dataFine)) {
            $useMinMax = false;
            if (isset($dataFine['min'])) {
                $this->addUsingAlias(ServiziTableMap::COL_DATA_FINE, $dataFine['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($dataFine['max'])) {
                $this->addUsingAlias(ServiziTableMap::COL_DATA_FINE, $dataFine['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ServiziTableMap::COL_DATA_FINE, $dataFine, $comparison);
    }

    /**
     * Filter the query on the qta column
     *
     * Example usage:
     * <code>
     * $query->filterByQta(1234); // WHERE qta = 1234
     * $query->filterByQta(array(12, 34)); // WHERE qta IN (12, 34)
     * $query->filterByQta(array('min' => 12)); // WHERE qta > 12
     * </code>
     *
     * @param     mixed $qta The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildServiziQuery The current query, for fluid interface
     */
    public function filterByQta($qta = null, $comparison = null)
    {
        if (is_array($qta)) {
            $useMinMax = false;
            if (isset($qta['min'])) {
                $this->addUsingAlias(ServiziTableMap::COL_QTA, $qta['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($qta['max'])) {
                $this->addUsingAlias(ServiziTableMap::COL_QTA, $qta['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ServiziTableMap::COL_QTA, $qta, $comparison);
    }

    /**
     * Filter the query on the costo_finale column
     *
     * Example usage:
     * <code>
     * $query->filterByCostoFinale(1234); // WHERE costo_finale = 1234
     * $query->filterByCostoFinale(array(12, 34)); // WHERE costo_finale IN (12, 34)
     * $query->filterByCostoFinale(array('min' => 12)); // WHERE costo_finale > 12
     * </code>
     *
     * @param     mixed $costoFinale The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildServiziQuery The current query, for fluid interface
     */
    public function filterByCostoFinale($costoFinale = null, $comparison = null)
    {
        if (is_array($costoFinale)) {
            $useMinMax = false;
            if (isset($costoFinale['min'])) {
                $this->addUsingAlias(ServiziTableMap::COL_COSTO_FINALE, $costoFinale['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($costoFinale['max'])) {
                $this->addUsingAlias(ServiziTableMap::COL_COSTO_FINALE, $costoFinale['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ServiziTableMap::COL_COSTO_FINALE, $costoFinale, $comparison);
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
     * @return $this|ChildServiziQuery The current query, for fluid interface
     */
    public function filterByNote($note = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($note)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ServiziTableMap::COL_NOTE, $note, $comparison);
    }

    /**
     * Filter the query by a related \AssegnamentiPostazione object
     *
     * @param \AssegnamentiPostazione|ObjectCollection $assegnamentiPostazione The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildServiziQuery The current query, for fluid interface
     */
    public function filterByAssegnamentiPostazione($assegnamentiPostazione, $comparison = null)
    {
        if ($assegnamentiPostazione instanceof \AssegnamentiPostazione) {
            return $this
                ->addUsingAlias(ServiziTableMap::COL_ID_ASSEGNAMENTO_POSTAZIONE, $assegnamentiPostazione->getIdAssegnamentoPostazione(), $comparison);
        } elseif ($assegnamentiPostazione instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(ServiziTableMap::COL_ID_ASSEGNAMENTO_POSTAZIONE, $assegnamentiPostazione->toKeyValue('PrimaryKey', 'IdAssegnamentoPostazione'), $comparison);
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
     * @return $this|ChildServiziQuery The current query, for fluid interface
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
     * Filter the query by a related \TipiServizio object
     *
     * @param \TipiServizio|ObjectCollection $tipiServizio The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildServiziQuery The current query, for fluid interface
     */
    public function filterByTipiServizio($tipiServizio, $comparison = null)
    {
        if ($tipiServizio instanceof \TipiServizio) {
            return $this
                ->addUsingAlias(ServiziTableMap::COL_ID_TIPO_SERVIZIO, $tipiServizio->getIdTipoServizio(), $comparison);
        } elseif ($tipiServizio instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(ServiziTableMap::COL_ID_TIPO_SERVIZIO, $tipiServizio->toKeyValue('PrimaryKey', 'IdTipoServizio'), $comparison);
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
     * @return $this|ChildServiziQuery The current query, for fluid interface
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
     * @param   ChildServizi $servizi Object to remove from the list of results
     *
     * @return $this|ChildServiziQuery The current query, for fluid interface
     */
    public function prune($servizi = null)
    {
        if ($servizi) {
            $this->addUsingAlias(ServiziTableMap::COL_ID_SERVIZIO, $servizi->getIdServizio(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the servizi table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(ServiziTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            ServiziTableMap::clearInstancePool();
            ServiziTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(ServiziTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(ServiziTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            ServiziTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            ServiziTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // ServiziQuery
