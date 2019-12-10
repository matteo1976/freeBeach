<?php

namespace Base;

use \Clienti as ChildClienti;
use \ClientiQuery as ChildClientiQuery;
use \Exception;
use \PDO;
use Map\ClientiTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'clienti' table.
 *
 *
 *
 * @method     ChildClientiQuery orderByIdCliente($order = Criteria::ASC) Order by the id_cliente column
 * @method     ChildClientiQuery orderByDaSaldare($order = Criteria::ASC) Order by the da_saldare column
 * @method     ChildClientiQuery orderByNote($order = Criteria::ASC) Order by the note column
 * @method     ChildClientiQuery orderByIndirizzo($order = Criteria::ASC) Order by the indirizzo column
 * @method     ChildClientiQuery orderByCap($order = Criteria::ASC) Order by the cap column
 * @method     ChildClientiQuery orderByCitta($order = Criteria::ASC) Order by the citta column
 * @method     ChildClientiQuery orderByProvincia($order = Criteria::ASC) Order by the provincia column
 * @method     ChildClientiQuery orderByStato($order = Criteria::ASC) Order by the stato column
 * @method     ChildClientiQuery orderByCodiceFiscale($order = Criteria::ASC) Order by the codice_fiscale column
 *
 * @method     ChildClientiQuery groupByIdCliente() Group by the id_cliente column
 * @method     ChildClientiQuery groupByDaSaldare() Group by the da_saldare column
 * @method     ChildClientiQuery groupByNote() Group by the note column
 * @method     ChildClientiQuery groupByIndirizzo() Group by the indirizzo column
 * @method     ChildClientiQuery groupByCap() Group by the cap column
 * @method     ChildClientiQuery groupByCitta() Group by the citta column
 * @method     ChildClientiQuery groupByProvincia() Group by the provincia column
 * @method     ChildClientiQuery groupByStato() Group by the stato column
 * @method     ChildClientiQuery groupByCodiceFiscale() Group by the codice_fiscale column
 *
 * @method     ChildClientiQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildClientiQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildClientiQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildClientiQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildClientiQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildClientiQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildClientiQuery leftJoinAccount($relationAlias = null) Adds a LEFT JOIN clause to the query using the Account relation
 * @method     ChildClientiQuery rightJoinAccount($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Account relation
 * @method     ChildClientiQuery innerJoinAccount($relationAlias = null) Adds a INNER JOIN clause to the query using the Account relation
 *
 * @method     ChildClientiQuery joinWithAccount($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Account relation
 *
 * @method     ChildClientiQuery leftJoinWithAccount() Adds a LEFT JOIN clause and with to the query using the Account relation
 * @method     ChildClientiQuery rightJoinWithAccount() Adds a RIGHT JOIN clause and with to the query using the Account relation
 * @method     ChildClientiQuery innerJoinWithAccount() Adds a INNER JOIN clause and with to the query using the Account relation
 *
 * @method     ChildClientiQuery leftJoinAssegnamentiPostazione($relationAlias = null) Adds a LEFT JOIN clause to the query using the AssegnamentiPostazione relation
 * @method     ChildClientiQuery rightJoinAssegnamentiPostazione($relationAlias = null) Adds a RIGHT JOIN clause to the query using the AssegnamentiPostazione relation
 * @method     ChildClientiQuery innerJoinAssegnamentiPostazione($relationAlias = null) Adds a INNER JOIN clause to the query using the AssegnamentiPostazione relation
 *
 * @method     ChildClientiQuery joinWithAssegnamentiPostazione($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the AssegnamentiPostazione relation
 *
 * @method     ChildClientiQuery leftJoinWithAssegnamentiPostazione() Adds a LEFT JOIN clause and with to the query using the AssegnamentiPostazione relation
 * @method     ChildClientiQuery rightJoinWithAssegnamentiPostazione() Adds a RIGHT JOIN clause and with to the query using the AssegnamentiPostazione relation
 * @method     ChildClientiQuery innerJoinWithAssegnamentiPostazione() Adds a INNER JOIN clause and with to the query using the AssegnamentiPostazione relation
 *
 * @method     ChildClientiQuery leftJoinPagamenti($relationAlias = null) Adds a LEFT JOIN clause to the query using the Pagamenti relation
 * @method     ChildClientiQuery rightJoinPagamenti($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Pagamenti relation
 * @method     ChildClientiQuery innerJoinPagamenti($relationAlias = null) Adds a INNER JOIN clause to the query using the Pagamenti relation
 *
 * @method     ChildClientiQuery joinWithPagamenti($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Pagamenti relation
 *
 * @method     ChildClientiQuery leftJoinWithPagamenti() Adds a LEFT JOIN clause and with to the query using the Pagamenti relation
 * @method     ChildClientiQuery rightJoinWithPagamenti() Adds a RIGHT JOIN clause and with to the query using the Pagamenti relation
 * @method     ChildClientiQuery innerJoinWithPagamenti() Adds a INNER JOIN clause and with to the query using the Pagamenti relation
 *
 * @method     ChildClientiQuery leftJoinSchede($relationAlias = null) Adds a LEFT JOIN clause to the query using the Schede relation
 * @method     ChildClientiQuery rightJoinSchede($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Schede relation
 * @method     ChildClientiQuery innerJoinSchede($relationAlias = null) Adds a INNER JOIN clause to the query using the Schede relation
 *
 * @method     ChildClientiQuery joinWithSchede($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Schede relation
 *
 * @method     ChildClientiQuery leftJoinWithSchede() Adds a LEFT JOIN clause and with to the query using the Schede relation
 * @method     ChildClientiQuery rightJoinWithSchede() Adds a RIGHT JOIN clause and with to the query using the Schede relation
 * @method     ChildClientiQuery innerJoinWithSchede() Adds a INNER JOIN clause and with to the query using the Schede relation
 *
 * @method     \AccountQuery|\AssegnamentiPostazioneQuery|\PagamentiQuery|\SchedeQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildClienti findOne(ConnectionInterface $con = null) Return the first ChildClienti matching the query
 * @method     ChildClienti findOneOrCreate(ConnectionInterface $con = null) Return the first ChildClienti matching the query, or a new ChildClienti object populated from the query conditions when no match is found
 *
 * @method     ChildClienti findOneByIdCliente(int $id_cliente) Return the first ChildClienti filtered by the id_cliente column
 * @method     ChildClienti findOneByDaSaldare(string $da_saldare) Return the first ChildClienti filtered by the da_saldare column
 * @method     ChildClienti findOneByNote(string $note) Return the first ChildClienti filtered by the note column
 * @method     ChildClienti findOneByIndirizzo(string $indirizzo) Return the first ChildClienti filtered by the indirizzo column
 * @method     ChildClienti findOneByCap(string $cap) Return the first ChildClienti filtered by the cap column
 * @method     ChildClienti findOneByCitta(string $citta) Return the first ChildClienti filtered by the citta column
 * @method     ChildClienti findOneByProvincia(string $provincia) Return the first ChildClienti filtered by the provincia column
 * @method     ChildClienti findOneByStato(string $stato) Return the first ChildClienti filtered by the stato column
 * @method     ChildClienti findOneByCodiceFiscale(string $codice_fiscale) Return the first ChildClienti filtered by the codice_fiscale column *

 * @method     ChildClienti requirePk($key, ConnectionInterface $con = null) Return the ChildClienti by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildClienti requireOne(ConnectionInterface $con = null) Return the first ChildClienti matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildClienti requireOneByIdCliente(int $id_cliente) Return the first ChildClienti filtered by the id_cliente column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildClienti requireOneByDaSaldare(string $da_saldare) Return the first ChildClienti filtered by the da_saldare column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildClienti requireOneByNote(string $note) Return the first ChildClienti filtered by the note column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildClienti requireOneByIndirizzo(string $indirizzo) Return the first ChildClienti filtered by the indirizzo column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildClienti requireOneByCap(string $cap) Return the first ChildClienti filtered by the cap column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildClienti requireOneByCitta(string $citta) Return the first ChildClienti filtered by the citta column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildClienti requireOneByProvincia(string $provincia) Return the first ChildClienti filtered by the provincia column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildClienti requireOneByStato(string $stato) Return the first ChildClienti filtered by the stato column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildClienti requireOneByCodiceFiscale(string $codice_fiscale) Return the first ChildClienti filtered by the codice_fiscale column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildClienti[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildClienti objects based on current ModelCriteria
 * @method     ChildClienti[]|ObjectCollection findByIdCliente(int $id_cliente) Return ChildClienti objects filtered by the id_cliente column
 * @method     ChildClienti[]|ObjectCollection findByDaSaldare(string $da_saldare) Return ChildClienti objects filtered by the da_saldare column
 * @method     ChildClienti[]|ObjectCollection findByNote(string $note) Return ChildClienti objects filtered by the note column
 * @method     ChildClienti[]|ObjectCollection findByIndirizzo(string $indirizzo) Return ChildClienti objects filtered by the indirizzo column
 * @method     ChildClienti[]|ObjectCollection findByCap(string $cap) Return ChildClienti objects filtered by the cap column
 * @method     ChildClienti[]|ObjectCollection findByCitta(string $citta) Return ChildClienti objects filtered by the citta column
 * @method     ChildClienti[]|ObjectCollection findByProvincia(string $provincia) Return ChildClienti objects filtered by the provincia column
 * @method     ChildClienti[]|ObjectCollection findByStato(string $stato) Return ChildClienti objects filtered by the stato column
 * @method     ChildClienti[]|ObjectCollection findByCodiceFiscale(string $codice_fiscale) Return ChildClienti objects filtered by the codice_fiscale column
 * @method     ChildClienti[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class ClientiQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\ClientiQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'dbspiaggie', $modelName = '\\Clienti', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildClientiQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildClientiQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildClientiQuery) {
            return $criteria;
        }
        $query = new ChildClientiQuery();
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
     * @return ChildClienti|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(ClientiTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = ClientiTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildClienti A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id_cliente, da_saldare, note, indirizzo, cap, citta, provincia, stato, codice_fiscale FROM clienti WHERE id_cliente = :p0';
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
            /** @var ChildClienti $obj */
            $obj = new ChildClienti();
            $obj->hydrate($row);
            ClientiTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildClienti|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildClientiQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(ClientiTableMap::COL_ID_CLIENTE, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildClientiQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(ClientiTableMap::COL_ID_CLIENTE, $keys, Criteria::IN);
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
     * @param     mixed $idCliente The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildClientiQuery The current query, for fluid interface
     */
    public function filterByIdCliente($idCliente = null, $comparison = null)
    {
        if (is_array($idCliente)) {
            $useMinMax = false;
            if (isset($idCliente['min'])) {
                $this->addUsingAlias(ClientiTableMap::COL_ID_CLIENTE, $idCliente['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($idCliente['max'])) {
                $this->addUsingAlias(ClientiTableMap::COL_ID_CLIENTE, $idCliente['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ClientiTableMap::COL_ID_CLIENTE, $idCliente, $comparison);
    }

    /**
     * Filter the query on the da_saldare column
     *
     * Example usage:
     * <code>
     * $query->filterByDaSaldare(1234); // WHERE da_saldare = 1234
     * $query->filterByDaSaldare(array(12, 34)); // WHERE da_saldare IN (12, 34)
     * $query->filterByDaSaldare(array('min' => 12)); // WHERE da_saldare > 12
     * </code>
     *
     * @param     mixed $daSaldare The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildClientiQuery The current query, for fluid interface
     */
    public function filterByDaSaldare($daSaldare = null, $comparison = null)
    {
        if (is_array($daSaldare)) {
            $useMinMax = false;
            if (isset($daSaldare['min'])) {
                $this->addUsingAlias(ClientiTableMap::COL_DA_SALDARE, $daSaldare['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($daSaldare['max'])) {
                $this->addUsingAlias(ClientiTableMap::COL_DA_SALDARE, $daSaldare['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ClientiTableMap::COL_DA_SALDARE, $daSaldare, $comparison);
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
     * @return $this|ChildClientiQuery The current query, for fluid interface
     */
    public function filterByNote($note = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($note)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ClientiTableMap::COL_NOTE, $note, $comparison);
    }

    /**
     * Filter the query on the indirizzo column
     *
     * Example usage:
     * <code>
     * $query->filterByIndirizzo('fooValue');   // WHERE indirizzo = 'fooValue'
     * $query->filterByIndirizzo('%fooValue%', Criteria::LIKE); // WHERE indirizzo LIKE '%fooValue%'
     * </code>
     *
     * @param     string $indirizzo The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildClientiQuery The current query, for fluid interface
     */
    public function filterByIndirizzo($indirizzo = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($indirizzo)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ClientiTableMap::COL_INDIRIZZO, $indirizzo, $comparison);
    }

    /**
     * Filter the query on the cap column
     *
     * Example usage:
     * <code>
     * $query->filterByCap('fooValue');   // WHERE cap = 'fooValue'
     * $query->filterByCap('%fooValue%', Criteria::LIKE); // WHERE cap LIKE '%fooValue%'
     * </code>
     *
     * @param     string $cap The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildClientiQuery The current query, for fluid interface
     */
    public function filterByCap($cap = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($cap)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ClientiTableMap::COL_CAP, $cap, $comparison);
    }

    /**
     * Filter the query on the citta column
     *
     * Example usage:
     * <code>
     * $query->filterByCitta('fooValue');   // WHERE citta = 'fooValue'
     * $query->filterByCitta('%fooValue%', Criteria::LIKE); // WHERE citta LIKE '%fooValue%'
     * </code>
     *
     * @param     string $citta The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildClientiQuery The current query, for fluid interface
     */
    public function filterByCitta($citta = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($citta)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ClientiTableMap::COL_CITTA, $citta, $comparison);
    }

    /**
     * Filter the query on the provincia column
     *
     * Example usage:
     * <code>
     * $query->filterByProvincia('fooValue');   // WHERE provincia = 'fooValue'
     * $query->filterByProvincia('%fooValue%', Criteria::LIKE); // WHERE provincia LIKE '%fooValue%'
     * </code>
     *
     * @param     string $provincia The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildClientiQuery The current query, for fluid interface
     */
    public function filterByProvincia($provincia = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($provincia)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ClientiTableMap::COL_PROVINCIA, $provincia, $comparison);
    }

    /**
     * Filter the query on the stato column
     *
     * Example usage:
     * <code>
     * $query->filterByStato('fooValue');   // WHERE stato = 'fooValue'
     * $query->filterByStato('%fooValue%', Criteria::LIKE); // WHERE stato LIKE '%fooValue%'
     * </code>
     *
     * @param     string $stato The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildClientiQuery The current query, for fluid interface
     */
    public function filterByStato($stato = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($stato)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ClientiTableMap::COL_STATO, $stato, $comparison);
    }

    /**
     * Filter the query on the codice_fiscale column
     *
     * Example usage:
     * <code>
     * $query->filterByCodiceFiscale('fooValue');   // WHERE codice_fiscale = 'fooValue'
     * $query->filterByCodiceFiscale('%fooValue%', Criteria::LIKE); // WHERE codice_fiscale LIKE '%fooValue%'
     * </code>
     *
     * @param     string $codiceFiscale The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildClientiQuery The current query, for fluid interface
     */
    public function filterByCodiceFiscale($codiceFiscale = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($codiceFiscale)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ClientiTableMap::COL_CODICE_FISCALE, $codiceFiscale, $comparison);
    }

    /**
     * Filter the query by a related \Account object
     *
     * @param \Account|ObjectCollection $account the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildClientiQuery The current query, for fluid interface
     */
    public function filterByAccount($account, $comparison = null)
    {
        if ($account instanceof \Account) {
            return $this
                ->addUsingAlias(ClientiTableMap::COL_ID_CLIENTE, $account->getIdCliente(), $comparison);
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
     * @return $this|ChildClientiQuery The current query, for fluid interface
     */
    public function joinAccount($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
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
    public function useAccountQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinAccount($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Account', '\AccountQuery');
    }

    /**
     * Filter the query by a related \AssegnamentiPostazione object
     *
     * @param \AssegnamentiPostazione|ObjectCollection $assegnamentiPostazione the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildClientiQuery The current query, for fluid interface
     */
    public function filterByAssegnamentiPostazione($assegnamentiPostazione, $comparison = null)
    {
        if ($assegnamentiPostazione instanceof \AssegnamentiPostazione) {
            return $this
                ->addUsingAlias(ClientiTableMap::COL_ID_CLIENTE, $assegnamentiPostazione->getIdCliente(), $comparison);
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
     * @return $this|ChildClientiQuery The current query, for fluid interface
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
     * Filter the query by a related \Pagamenti object
     *
     * @param \Pagamenti|ObjectCollection $pagamenti the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildClientiQuery The current query, for fluid interface
     */
    public function filterByPagamenti($pagamenti, $comparison = null)
    {
        if ($pagamenti instanceof \Pagamenti) {
            return $this
                ->addUsingAlias(ClientiTableMap::COL_ID_CLIENTE, $pagamenti->getIdCliente(), $comparison);
        } elseif ($pagamenti instanceof ObjectCollection) {
            return $this
                ->usePagamentiQuery()
                ->filterByPrimaryKeys($pagamenti->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByPagamenti() only accepts arguments of type \Pagamenti or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Pagamenti relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildClientiQuery The current query, for fluid interface
     */
    public function joinPagamenti($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Pagamenti');

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
            $this->addJoinObject($join, 'Pagamenti');
        }

        return $this;
    }

    /**
     * Use the Pagamenti relation Pagamenti object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \PagamentiQuery A secondary query class using the current class as primary query
     */
    public function usePagamentiQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinPagamenti($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Pagamenti', '\PagamentiQuery');
    }

    /**
     * Filter the query by a related \Schede object
     *
     * @param \Schede|ObjectCollection $schede the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildClientiQuery The current query, for fluid interface
     */
    public function filterBySchede($schede, $comparison = null)
    {
        if ($schede instanceof \Schede) {
            return $this
                ->addUsingAlias(ClientiTableMap::COL_ID_CLIENTE, $schede->getIdCliente(), $comparison);
        } elseif ($schede instanceof ObjectCollection) {
            return $this
                ->useSchedeQuery()
                ->filterByPrimaryKeys($schede->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterBySchede() only accepts arguments of type \Schede or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Schede relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildClientiQuery The current query, for fluid interface
     */
    public function joinSchede($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Schede');

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
            $this->addJoinObject($join, 'Schede');
        }

        return $this;
    }

    /**
     * Use the Schede relation Schede object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \SchedeQuery A secondary query class using the current class as primary query
     */
    public function useSchedeQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinSchede($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Schede', '\SchedeQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildClienti $clienti Object to remove from the list of results
     *
     * @return $this|ChildClientiQuery The current query, for fluid interface
     */
    public function prune($clienti = null)
    {
        if ($clienti) {
            $this->addUsingAlias(ClientiTableMap::COL_ID_CLIENTE, $clienti->getIdCliente(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the clienti table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(ClientiTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            ClientiTableMap::clearInstancePool();
            ClientiTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(ClientiTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(ClientiTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            ClientiTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            ClientiTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // ClientiQuery
