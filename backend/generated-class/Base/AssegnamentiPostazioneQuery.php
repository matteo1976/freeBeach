<?php

namespace Base;

use \AssegnamentiPostazione as ChildAssegnamentiPostazione;
use \AssegnamentiPostazioneQuery as ChildAssegnamentiPostazioneQuery;
use \Exception;
use \PDO;
use Map\AssegnamentiPostazioneTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'assegnamenti_postazione' table.
 *
 *
 *
 * @method     ChildAssegnamentiPostazioneQuery orderByIdAssegnamentoPostazione($order = Criteria::ASC) Order by the id_assegnamento_postazione column
 * @method     ChildAssegnamentiPostazioneQuery orderByIdCliente($order = Criteria::ASC) Order by the id_cliente column
 * @method     ChildAssegnamentiPostazioneQuery orderByIdPostazione($order = Criteria::ASC) Order by the id_postazione column
 * @method     ChildAssegnamentiPostazioneQuery orderByIdAbbonamento($order = Criteria::ASC) Order by the id_abbonamento column
 * @method     ChildAssegnamentiPostazioneQuery orderByDataInizio($order = Criteria::ASC) Order by the data_inizio column
 * @method     ChildAssegnamentiPostazioneQuery orderByDataFine($order = Criteria::ASC) Order by the data_fine column
 * @method     ChildAssegnamentiPostazioneQuery orderByAutorizzati($order = Criteria::ASC) Order by the autorizzati column
 * @method     ChildAssegnamentiPostazioneQuery orderByNote($order = Criteria::ASC) Order by the note column
 *
 * @method     ChildAssegnamentiPostazioneQuery groupByIdAssegnamentoPostazione() Group by the id_assegnamento_postazione column
 * @method     ChildAssegnamentiPostazioneQuery groupByIdCliente() Group by the id_cliente column
 * @method     ChildAssegnamentiPostazioneQuery groupByIdPostazione() Group by the id_postazione column
 * @method     ChildAssegnamentiPostazioneQuery groupByIdAbbonamento() Group by the id_abbonamento column
 * @method     ChildAssegnamentiPostazioneQuery groupByDataInizio() Group by the data_inizio column
 * @method     ChildAssegnamentiPostazioneQuery groupByDataFine() Group by the data_fine column
 * @method     ChildAssegnamentiPostazioneQuery groupByAutorizzati() Group by the autorizzati column
 * @method     ChildAssegnamentiPostazioneQuery groupByNote() Group by the note column
 *
 * @method     ChildAssegnamentiPostazioneQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildAssegnamentiPostazioneQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildAssegnamentiPostazioneQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildAssegnamentiPostazioneQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildAssegnamentiPostazioneQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildAssegnamentiPostazioneQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildAssegnamentiPostazioneQuery leftJoinPostazioni($relationAlias = null) Adds a LEFT JOIN clause to the query using the Postazioni relation
 * @method     ChildAssegnamentiPostazioneQuery rightJoinPostazioni($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Postazioni relation
 * @method     ChildAssegnamentiPostazioneQuery innerJoinPostazioni($relationAlias = null) Adds a INNER JOIN clause to the query using the Postazioni relation
 *
 * @method     ChildAssegnamentiPostazioneQuery joinWithPostazioni($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Postazioni relation
 *
 * @method     ChildAssegnamentiPostazioneQuery leftJoinWithPostazioni() Adds a LEFT JOIN clause and with to the query using the Postazioni relation
 * @method     ChildAssegnamentiPostazioneQuery rightJoinWithPostazioni() Adds a RIGHT JOIN clause and with to the query using the Postazioni relation
 * @method     ChildAssegnamentiPostazioneQuery innerJoinWithPostazioni() Adds a INNER JOIN clause and with to the query using the Postazioni relation
 *
 * @method     ChildAssegnamentiPostazioneQuery leftJoinClienti($relationAlias = null) Adds a LEFT JOIN clause to the query using the Clienti relation
 * @method     ChildAssegnamentiPostazioneQuery rightJoinClienti($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Clienti relation
 * @method     ChildAssegnamentiPostazioneQuery innerJoinClienti($relationAlias = null) Adds a INNER JOIN clause to the query using the Clienti relation
 *
 * @method     ChildAssegnamentiPostazioneQuery joinWithClienti($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Clienti relation
 *
 * @method     ChildAssegnamentiPostazioneQuery leftJoinWithClienti() Adds a LEFT JOIN clause and with to the query using the Clienti relation
 * @method     ChildAssegnamentiPostazioneQuery rightJoinWithClienti() Adds a RIGHT JOIN clause and with to the query using the Clienti relation
 * @method     ChildAssegnamentiPostazioneQuery innerJoinWithClienti() Adds a INNER JOIN clause and with to the query using the Clienti relation
 *
 * @method     ChildAssegnamentiPostazioneQuery leftJoinAbbonamenti($relationAlias = null) Adds a LEFT JOIN clause to the query using the Abbonamenti relation
 * @method     ChildAssegnamentiPostazioneQuery rightJoinAbbonamenti($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Abbonamenti relation
 * @method     ChildAssegnamentiPostazioneQuery innerJoinAbbonamenti($relationAlias = null) Adds a INNER JOIN clause to the query using the Abbonamenti relation
 *
 * @method     ChildAssegnamentiPostazioneQuery joinWithAbbonamenti($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Abbonamenti relation
 *
 * @method     ChildAssegnamentiPostazioneQuery leftJoinWithAbbonamenti() Adds a LEFT JOIN clause and with to the query using the Abbonamenti relation
 * @method     ChildAssegnamentiPostazioneQuery rightJoinWithAbbonamenti() Adds a RIGHT JOIN clause and with to the query using the Abbonamenti relation
 * @method     ChildAssegnamentiPostazioneQuery innerJoinWithAbbonamenti() Adds a INNER JOIN clause and with to the query using the Abbonamenti relation
 *
 * @method     ChildAssegnamentiPostazioneQuery leftJoinDisponibilitaPostazione($relationAlias = null) Adds a LEFT JOIN clause to the query using the DisponibilitaPostazione relation
 * @method     ChildAssegnamentiPostazioneQuery rightJoinDisponibilitaPostazione($relationAlias = null) Adds a RIGHT JOIN clause to the query using the DisponibilitaPostazione relation
 * @method     ChildAssegnamentiPostazioneQuery innerJoinDisponibilitaPostazione($relationAlias = null) Adds a INNER JOIN clause to the query using the DisponibilitaPostazione relation
 *
 * @method     ChildAssegnamentiPostazioneQuery joinWithDisponibilitaPostazione($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the DisponibilitaPostazione relation
 *
 * @method     ChildAssegnamentiPostazioneQuery leftJoinWithDisponibilitaPostazione() Adds a LEFT JOIN clause and with to the query using the DisponibilitaPostazione relation
 * @method     ChildAssegnamentiPostazioneQuery rightJoinWithDisponibilitaPostazione() Adds a RIGHT JOIN clause and with to the query using the DisponibilitaPostazione relation
 * @method     ChildAssegnamentiPostazioneQuery innerJoinWithDisponibilitaPostazione() Adds a INNER JOIN clause and with to the query using the DisponibilitaPostazione relation
 *
 * @method     ChildAssegnamentiPostazioneQuery leftJoinServizi($relationAlias = null) Adds a LEFT JOIN clause to the query using the Servizi relation
 * @method     ChildAssegnamentiPostazioneQuery rightJoinServizi($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Servizi relation
 * @method     ChildAssegnamentiPostazioneQuery innerJoinServizi($relationAlias = null) Adds a INNER JOIN clause to the query using the Servizi relation
 *
 * @method     ChildAssegnamentiPostazioneQuery joinWithServizi($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Servizi relation
 *
 * @method     ChildAssegnamentiPostazioneQuery leftJoinWithServizi() Adds a LEFT JOIN clause and with to the query using the Servizi relation
 * @method     ChildAssegnamentiPostazioneQuery rightJoinWithServizi() Adds a RIGHT JOIN clause and with to the query using the Servizi relation
 * @method     ChildAssegnamentiPostazioneQuery innerJoinWithServizi() Adds a INNER JOIN clause and with to the query using the Servizi relation
 *
 * @method     \PostazioniQuery|\ClientiQuery|\AbbonamentiQuery|\DisponibilitaPostazioneQuery|\ServiziQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildAssegnamentiPostazione findOne(ConnectionInterface $con = null) Return the first ChildAssegnamentiPostazione matching the query
 * @method     ChildAssegnamentiPostazione findOneOrCreate(ConnectionInterface $con = null) Return the first ChildAssegnamentiPostazione matching the query, or a new ChildAssegnamentiPostazione object populated from the query conditions when no match is found
 *
 * @method     ChildAssegnamentiPostazione findOneByIdAssegnamentoPostazione(int $id_assegnamento_postazione) Return the first ChildAssegnamentiPostazione filtered by the id_assegnamento_postazione column
 * @method     ChildAssegnamentiPostazione findOneByIdCliente(int $id_cliente) Return the first ChildAssegnamentiPostazione filtered by the id_cliente column
 * @method     ChildAssegnamentiPostazione findOneByIdPostazione(int $id_postazione) Return the first ChildAssegnamentiPostazione filtered by the id_postazione column
 * @method     ChildAssegnamentiPostazione findOneByIdAbbonamento(int $id_abbonamento) Return the first ChildAssegnamentiPostazione filtered by the id_abbonamento column
 * @method     ChildAssegnamentiPostazione findOneByDataInizio(string $data_inizio) Return the first ChildAssegnamentiPostazione filtered by the data_inizio column
 * @method     ChildAssegnamentiPostazione findOneByDataFine(string $data_fine) Return the first ChildAssegnamentiPostazione filtered by the data_fine column
 * @method     ChildAssegnamentiPostazione findOneByAutorizzati(string $autorizzati) Return the first ChildAssegnamentiPostazione filtered by the autorizzati column
 * @method     ChildAssegnamentiPostazione findOneByNote(string $note) Return the first ChildAssegnamentiPostazione filtered by the note column *

 * @method     ChildAssegnamentiPostazione requirePk($key, ConnectionInterface $con = null) Return the ChildAssegnamentiPostazione by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAssegnamentiPostazione requireOne(ConnectionInterface $con = null) Return the first ChildAssegnamentiPostazione matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildAssegnamentiPostazione requireOneByIdAssegnamentoPostazione(int $id_assegnamento_postazione) Return the first ChildAssegnamentiPostazione filtered by the id_assegnamento_postazione column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAssegnamentiPostazione requireOneByIdCliente(int $id_cliente) Return the first ChildAssegnamentiPostazione filtered by the id_cliente column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAssegnamentiPostazione requireOneByIdPostazione(int $id_postazione) Return the first ChildAssegnamentiPostazione filtered by the id_postazione column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAssegnamentiPostazione requireOneByIdAbbonamento(int $id_abbonamento) Return the first ChildAssegnamentiPostazione filtered by the id_abbonamento column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAssegnamentiPostazione requireOneByDataInizio(string $data_inizio) Return the first ChildAssegnamentiPostazione filtered by the data_inizio column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAssegnamentiPostazione requireOneByDataFine(string $data_fine) Return the first ChildAssegnamentiPostazione filtered by the data_fine column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAssegnamentiPostazione requireOneByAutorizzati(string $autorizzati) Return the first ChildAssegnamentiPostazione filtered by the autorizzati column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAssegnamentiPostazione requireOneByNote(string $note) Return the first ChildAssegnamentiPostazione filtered by the note column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildAssegnamentiPostazione[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildAssegnamentiPostazione objects based on current ModelCriteria
 * @method     ChildAssegnamentiPostazione[]|ObjectCollection findByIdAssegnamentoPostazione(int $id_assegnamento_postazione) Return ChildAssegnamentiPostazione objects filtered by the id_assegnamento_postazione column
 * @method     ChildAssegnamentiPostazione[]|ObjectCollection findByIdCliente(int $id_cliente) Return ChildAssegnamentiPostazione objects filtered by the id_cliente column
 * @method     ChildAssegnamentiPostazione[]|ObjectCollection findByIdPostazione(int $id_postazione) Return ChildAssegnamentiPostazione objects filtered by the id_postazione column
 * @method     ChildAssegnamentiPostazione[]|ObjectCollection findByIdAbbonamento(int $id_abbonamento) Return ChildAssegnamentiPostazione objects filtered by the id_abbonamento column
 * @method     ChildAssegnamentiPostazione[]|ObjectCollection findByDataInizio(string $data_inizio) Return ChildAssegnamentiPostazione objects filtered by the data_inizio column
 * @method     ChildAssegnamentiPostazione[]|ObjectCollection findByDataFine(string $data_fine) Return ChildAssegnamentiPostazione objects filtered by the data_fine column
 * @method     ChildAssegnamentiPostazione[]|ObjectCollection findByAutorizzati(string $autorizzati) Return ChildAssegnamentiPostazione objects filtered by the autorizzati column
 * @method     ChildAssegnamentiPostazione[]|ObjectCollection findByNote(string $note) Return ChildAssegnamentiPostazione objects filtered by the note column
 * @method     ChildAssegnamentiPostazione[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class AssegnamentiPostazioneQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\AssegnamentiPostazioneQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'dbspiaggie', $modelName = '\\AssegnamentiPostazione', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildAssegnamentiPostazioneQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildAssegnamentiPostazioneQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildAssegnamentiPostazioneQuery) {
            return $criteria;
        }
        $query = new ChildAssegnamentiPostazioneQuery();
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
     * @return ChildAssegnamentiPostazione|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(AssegnamentiPostazioneTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = AssegnamentiPostazioneTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildAssegnamentiPostazione A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id_assegnamento_postazione, id_cliente, id_postazione, id_abbonamento, data_inizio, data_fine, autorizzati, note FROM assegnamenti_postazione WHERE id_assegnamento_postazione = :p0';
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
            /** @var ChildAssegnamentiPostazione $obj */
            $obj = new ChildAssegnamentiPostazione();
            $obj->hydrate($row);
            AssegnamentiPostazioneTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildAssegnamentiPostazione|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildAssegnamentiPostazioneQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(AssegnamentiPostazioneTableMap::COL_ID_ASSEGNAMENTO_POSTAZIONE, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildAssegnamentiPostazioneQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(AssegnamentiPostazioneTableMap::COL_ID_ASSEGNAMENTO_POSTAZIONE, $keys, Criteria::IN);
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
     * @param     mixed $idAssegnamentoPostazione The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAssegnamentiPostazioneQuery The current query, for fluid interface
     */
    public function filterByIdAssegnamentoPostazione($idAssegnamentoPostazione = null, $comparison = null)
    {
        if (is_array($idAssegnamentoPostazione)) {
            $useMinMax = false;
            if (isset($idAssegnamentoPostazione['min'])) {
                $this->addUsingAlias(AssegnamentiPostazioneTableMap::COL_ID_ASSEGNAMENTO_POSTAZIONE, $idAssegnamentoPostazione['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($idAssegnamentoPostazione['max'])) {
                $this->addUsingAlias(AssegnamentiPostazioneTableMap::COL_ID_ASSEGNAMENTO_POSTAZIONE, $idAssegnamentoPostazione['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AssegnamentiPostazioneTableMap::COL_ID_ASSEGNAMENTO_POSTAZIONE, $idAssegnamentoPostazione, $comparison);
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
     * @return $this|ChildAssegnamentiPostazioneQuery The current query, for fluid interface
     */
    public function filterByIdCliente($idCliente = null, $comparison = null)
    {
        if (is_array($idCliente)) {
            $useMinMax = false;
            if (isset($idCliente['min'])) {
                $this->addUsingAlias(AssegnamentiPostazioneTableMap::COL_ID_CLIENTE, $idCliente['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($idCliente['max'])) {
                $this->addUsingAlias(AssegnamentiPostazioneTableMap::COL_ID_CLIENTE, $idCliente['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AssegnamentiPostazioneTableMap::COL_ID_CLIENTE, $idCliente, $comparison);
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
     * @see       filterByPostazioni()
     *
     * @param     mixed $idPostazione The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAssegnamentiPostazioneQuery The current query, for fluid interface
     */
    public function filterByIdPostazione($idPostazione = null, $comparison = null)
    {
        if (is_array($idPostazione)) {
            $useMinMax = false;
            if (isset($idPostazione['min'])) {
                $this->addUsingAlias(AssegnamentiPostazioneTableMap::COL_ID_POSTAZIONE, $idPostazione['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($idPostazione['max'])) {
                $this->addUsingAlias(AssegnamentiPostazioneTableMap::COL_ID_POSTAZIONE, $idPostazione['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AssegnamentiPostazioneTableMap::COL_ID_POSTAZIONE, $idPostazione, $comparison);
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
     * @see       filterByAbbonamenti()
     *
     * @param     mixed $idAbbonamento The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAssegnamentiPostazioneQuery The current query, for fluid interface
     */
    public function filterByIdAbbonamento($idAbbonamento = null, $comparison = null)
    {
        if (is_array($idAbbonamento)) {
            $useMinMax = false;
            if (isset($idAbbonamento['min'])) {
                $this->addUsingAlias(AssegnamentiPostazioneTableMap::COL_ID_ABBONAMENTO, $idAbbonamento['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($idAbbonamento['max'])) {
                $this->addUsingAlias(AssegnamentiPostazioneTableMap::COL_ID_ABBONAMENTO, $idAbbonamento['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AssegnamentiPostazioneTableMap::COL_ID_ABBONAMENTO, $idAbbonamento, $comparison);
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
     * @return $this|ChildAssegnamentiPostazioneQuery The current query, for fluid interface
     */
    public function filterByDataInizio($dataInizio = null, $comparison = null)
    {
        if (is_array($dataInizio)) {
            $useMinMax = false;
            if (isset($dataInizio['min'])) {
                $this->addUsingAlias(AssegnamentiPostazioneTableMap::COL_DATA_INIZIO, $dataInizio['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($dataInizio['max'])) {
                $this->addUsingAlias(AssegnamentiPostazioneTableMap::COL_DATA_INIZIO, $dataInizio['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AssegnamentiPostazioneTableMap::COL_DATA_INIZIO, $dataInizio, $comparison);
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
     * @return $this|ChildAssegnamentiPostazioneQuery The current query, for fluid interface
     */
    public function filterByDataFine($dataFine = null, $comparison = null)
    {
        if (is_array($dataFine)) {
            $useMinMax = false;
            if (isset($dataFine['min'])) {
                $this->addUsingAlias(AssegnamentiPostazioneTableMap::COL_DATA_FINE, $dataFine['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($dataFine['max'])) {
                $this->addUsingAlias(AssegnamentiPostazioneTableMap::COL_DATA_FINE, $dataFine['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AssegnamentiPostazioneTableMap::COL_DATA_FINE, $dataFine, $comparison);
    }

    /**
     * Filter the query on the autorizzati column
     *
     * Example usage:
     * <code>
     * $query->filterByAutorizzati('fooValue');   // WHERE autorizzati = 'fooValue'
     * $query->filterByAutorizzati('%fooValue%', Criteria::LIKE); // WHERE autorizzati LIKE '%fooValue%'
     * </code>
     *
     * @param     string $autorizzati The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAssegnamentiPostazioneQuery The current query, for fluid interface
     */
    public function filterByAutorizzati($autorizzati = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($autorizzati)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AssegnamentiPostazioneTableMap::COL_AUTORIZZATI, $autorizzati, $comparison);
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
     * @return $this|ChildAssegnamentiPostazioneQuery The current query, for fluid interface
     */
    public function filterByNote($note = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($note)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AssegnamentiPostazioneTableMap::COL_NOTE, $note, $comparison);
    }

    /**
     * Filter the query by a related \Postazioni object
     *
     * @param \Postazioni|ObjectCollection $postazioni The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildAssegnamentiPostazioneQuery The current query, for fluid interface
     */
    public function filterByPostazioni($postazioni, $comparison = null)
    {
        if ($postazioni instanceof \Postazioni) {
            return $this
                ->addUsingAlias(AssegnamentiPostazioneTableMap::COL_ID_POSTAZIONE, $postazioni->getIdPostazione(), $comparison);
        } elseif ($postazioni instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(AssegnamentiPostazioneTableMap::COL_ID_POSTAZIONE, $postazioni->toKeyValue('PrimaryKey', 'IdPostazione'), $comparison);
        } else {
            throw new PropelException('filterByPostazioni() only accepts arguments of type \Postazioni or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Postazioni relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildAssegnamentiPostazioneQuery The current query, for fluid interface
     */
    public function joinPostazioni($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Postazioni');

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
            $this->addJoinObject($join, 'Postazioni');
        }

        return $this;
    }

    /**
     * Use the Postazioni relation Postazioni object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \PostazioniQuery A secondary query class using the current class as primary query
     */
    public function usePostazioniQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinPostazioni($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Postazioni', '\PostazioniQuery');
    }

    /**
     * Filter the query by a related \Clienti object
     *
     * @param \Clienti|ObjectCollection $clienti The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildAssegnamentiPostazioneQuery The current query, for fluid interface
     */
    public function filterByClienti($clienti, $comparison = null)
    {
        if ($clienti instanceof \Clienti) {
            return $this
                ->addUsingAlias(AssegnamentiPostazioneTableMap::COL_ID_CLIENTE, $clienti->getIdCliente(), $comparison);
        } elseif ($clienti instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(AssegnamentiPostazioneTableMap::COL_ID_CLIENTE, $clienti->toKeyValue('PrimaryKey', 'IdCliente'), $comparison);
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
     * @return $this|ChildAssegnamentiPostazioneQuery The current query, for fluid interface
     */
    public function joinClienti($relationAlias = null, $joinType = Criteria::INNER_JOIN)
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
    public function useClientiQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinClienti($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Clienti', '\ClientiQuery');
    }

    /**
     * Filter the query by a related \Abbonamenti object
     *
     * @param \Abbonamenti|ObjectCollection $abbonamenti The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildAssegnamentiPostazioneQuery The current query, for fluid interface
     */
    public function filterByAbbonamenti($abbonamenti, $comparison = null)
    {
        if ($abbonamenti instanceof \Abbonamenti) {
            return $this
                ->addUsingAlias(AssegnamentiPostazioneTableMap::COL_ID_ABBONAMENTO, $abbonamenti->getIdAbbonamento(), $comparison);
        } elseif ($abbonamenti instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(AssegnamentiPostazioneTableMap::COL_ID_ABBONAMENTO, $abbonamenti->toKeyValue('PrimaryKey', 'IdAbbonamento'), $comparison);
        } else {
            throw new PropelException('filterByAbbonamenti() only accepts arguments of type \Abbonamenti or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Abbonamenti relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildAssegnamentiPostazioneQuery The current query, for fluid interface
     */
    public function joinAbbonamenti($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Abbonamenti');

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
            $this->addJoinObject($join, 'Abbonamenti');
        }

        return $this;
    }

    /**
     * Use the Abbonamenti relation Abbonamenti object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \AbbonamentiQuery A secondary query class using the current class as primary query
     */
    public function useAbbonamentiQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinAbbonamenti($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Abbonamenti', '\AbbonamentiQuery');
    }

    /**
     * Filter the query by a related \DisponibilitaPostazione object
     *
     * @param \DisponibilitaPostazione|ObjectCollection $disponibilitaPostazione the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildAssegnamentiPostazioneQuery The current query, for fluid interface
     */
    public function filterByDisponibilitaPostazione($disponibilitaPostazione, $comparison = null)
    {
        if ($disponibilitaPostazione instanceof \DisponibilitaPostazione) {
            return $this
                ->addUsingAlias(AssegnamentiPostazioneTableMap::COL_ID_ASSEGNAMENTO_POSTAZIONE, $disponibilitaPostazione->getIdAssegnamentoPostazione(), $comparison);
        } elseif ($disponibilitaPostazione instanceof ObjectCollection) {
            return $this
                ->useDisponibilitaPostazioneQuery()
                ->filterByPrimaryKeys($disponibilitaPostazione->getPrimaryKeys())
                ->endUse();
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
     * @return $this|ChildAssegnamentiPostazioneQuery The current query, for fluid interface
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
     * Filter the query by a related \Servizi object
     *
     * @param \Servizi|ObjectCollection $servizi the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildAssegnamentiPostazioneQuery The current query, for fluid interface
     */
    public function filterByServizi($servizi, $comparison = null)
    {
        if ($servizi instanceof \Servizi) {
            return $this
                ->addUsingAlias(AssegnamentiPostazioneTableMap::COL_ID_ASSEGNAMENTO_POSTAZIONE, $servizi->getIdAssegnamentoPostazione(), $comparison);
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
     * @return $this|ChildAssegnamentiPostazioneQuery The current query, for fluid interface
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
     * @param   ChildAssegnamentiPostazione $assegnamentiPostazione Object to remove from the list of results
     *
     * @return $this|ChildAssegnamentiPostazioneQuery The current query, for fluid interface
     */
    public function prune($assegnamentiPostazione = null)
    {
        if ($assegnamentiPostazione) {
            $this->addUsingAlias(AssegnamentiPostazioneTableMap::COL_ID_ASSEGNAMENTO_POSTAZIONE, $assegnamentiPostazione->getIdAssegnamentoPostazione(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the assegnamenti_postazione table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(AssegnamentiPostazioneTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            AssegnamentiPostazioneTableMap::clearInstancePool();
            AssegnamentiPostazioneTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(AssegnamentiPostazioneTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(AssegnamentiPostazioneTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            AssegnamentiPostazioneTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            AssegnamentiPostazioneTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // AssegnamentiPostazioneQuery
