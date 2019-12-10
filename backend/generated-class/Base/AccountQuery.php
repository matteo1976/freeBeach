<?php

namespace Base;

use \Account as ChildAccount;
use \AccountQuery as ChildAccountQuery;
use \Exception;
use \PDO;
use Map\AccountTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'account' table.
 *
 *
 *
 * @method     ChildAccountQuery orderByIdAccount($order = Criteria::ASC) Order by the id_account column
 * @method     ChildAccountQuery orderByIdCliente($order = Criteria::ASC) Order by the id_cliente column
 * @method     ChildAccountQuery orderByIdProfilo($order = Criteria::ASC) Order by the id_profilo column
 * @method     ChildAccountQuery orderByEmail($order = Criteria::ASC) Order by the email column
 * @method     ChildAccountQuery orderByPassword($order = Criteria::ASC) Order by the password column
 * @method     ChildAccountQuery orderByNome($order = Criteria::ASC) Order by the nome column
 * @method     ChildAccountQuery orderByIndirizzo($order = Criteria::ASC) Order by the indirizzo column
 * @method     ChildAccountQuery orderByTelefono($order = Criteria::ASC) Order by the telefono column
 * @method     ChildAccountQuery orderByAbilitato($order = Criteria::ASC) Order by the abilitato column
 *
 * @method     ChildAccountQuery groupByIdAccount() Group by the id_account column
 * @method     ChildAccountQuery groupByIdCliente() Group by the id_cliente column
 * @method     ChildAccountQuery groupByIdProfilo() Group by the id_profilo column
 * @method     ChildAccountQuery groupByEmail() Group by the email column
 * @method     ChildAccountQuery groupByPassword() Group by the password column
 * @method     ChildAccountQuery groupByNome() Group by the nome column
 * @method     ChildAccountQuery groupByIndirizzo() Group by the indirizzo column
 * @method     ChildAccountQuery groupByTelefono() Group by the telefono column
 * @method     ChildAccountQuery groupByAbilitato() Group by the abilitato column
 *
 * @method     ChildAccountQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildAccountQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildAccountQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildAccountQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildAccountQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildAccountQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildAccountQuery leftJoinClienti($relationAlias = null) Adds a LEFT JOIN clause to the query using the Clienti relation
 * @method     ChildAccountQuery rightJoinClienti($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Clienti relation
 * @method     ChildAccountQuery innerJoinClienti($relationAlias = null) Adds a INNER JOIN clause to the query using the Clienti relation
 *
 * @method     ChildAccountQuery joinWithClienti($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Clienti relation
 *
 * @method     ChildAccountQuery leftJoinWithClienti() Adds a LEFT JOIN clause and with to the query using the Clienti relation
 * @method     ChildAccountQuery rightJoinWithClienti() Adds a RIGHT JOIN clause and with to the query using the Clienti relation
 * @method     ChildAccountQuery innerJoinWithClienti() Adds a INNER JOIN clause and with to the query using the Clienti relation
 *
 * @method     ChildAccountQuery leftJoinProfili($relationAlias = null) Adds a LEFT JOIN clause to the query using the Profili relation
 * @method     ChildAccountQuery rightJoinProfili($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Profili relation
 * @method     ChildAccountQuery innerJoinProfili($relationAlias = null) Adds a INNER JOIN clause to the query using the Profili relation
 *
 * @method     ChildAccountQuery joinWithProfili($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Profili relation
 *
 * @method     ChildAccountQuery leftJoinWithProfili() Adds a LEFT JOIN clause and with to the query using the Profili relation
 * @method     ChildAccountQuery rightJoinWithProfili() Adds a RIGHT JOIN clause and with to the query using the Profili relation
 * @method     ChildAccountQuery innerJoinWithProfili() Adds a INNER JOIN clause and with to the query using the Profili relation
 *
 * @method     \ClientiQuery|\ProfiliQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildAccount findOne(ConnectionInterface $con = null) Return the first ChildAccount matching the query
 * @method     ChildAccount findOneOrCreate(ConnectionInterface $con = null) Return the first ChildAccount matching the query, or a new ChildAccount object populated from the query conditions when no match is found
 *
 * @method     ChildAccount findOneByIdAccount(int $id_account) Return the first ChildAccount filtered by the id_account column
 * @method     ChildAccount findOneByIdCliente(int $id_cliente) Return the first ChildAccount filtered by the id_cliente column
 * @method     ChildAccount findOneByIdProfilo(int $id_profilo) Return the first ChildAccount filtered by the id_profilo column
 * @method     ChildAccount findOneByEmail(string $email) Return the first ChildAccount filtered by the email column
 * @method     ChildAccount findOneByPassword(string $password) Return the first ChildAccount filtered by the password column
 * @method     ChildAccount findOneByNome(string $nome) Return the first ChildAccount filtered by the nome column
 * @method     ChildAccount findOneByIndirizzo(string $indirizzo) Return the first ChildAccount filtered by the indirizzo column
 * @method     ChildAccount findOneByTelefono(string $telefono) Return the first ChildAccount filtered by the telefono column
 * @method     ChildAccount findOneByAbilitato(boolean $abilitato) Return the first ChildAccount filtered by the abilitato column *

 * @method     ChildAccount requirePk($key, ConnectionInterface $con = null) Return the ChildAccount by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAccount requireOne(ConnectionInterface $con = null) Return the first ChildAccount matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildAccount requireOneByIdAccount(int $id_account) Return the first ChildAccount filtered by the id_account column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAccount requireOneByIdCliente(int $id_cliente) Return the first ChildAccount filtered by the id_cliente column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAccount requireOneByIdProfilo(int $id_profilo) Return the first ChildAccount filtered by the id_profilo column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAccount requireOneByEmail(string $email) Return the first ChildAccount filtered by the email column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAccount requireOneByPassword(string $password) Return the first ChildAccount filtered by the password column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAccount requireOneByNome(string $nome) Return the first ChildAccount filtered by the nome column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAccount requireOneByIndirizzo(string $indirizzo) Return the first ChildAccount filtered by the indirizzo column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAccount requireOneByTelefono(string $telefono) Return the first ChildAccount filtered by the telefono column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAccount requireOneByAbilitato(boolean $abilitato) Return the first ChildAccount filtered by the abilitato column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildAccount[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildAccount objects based on current ModelCriteria
 * @method     ChildAccount[]|ObjectCollection findByIdAccount(int $id_account) Return ChildAccount objects filtered by the id_account column
 * @method     ChildAccount[]|ObjectCollection findByIdCliente(int $id_cliente) Return ChildAccount objects filtered by the id_cliente column
 * @method     ChildAccount[]|ObjectCollection findByIdProfilo(int $id_profilo) Return ChildAccount objects filtered by the id_profilo column
 * @method     ChildAccount[]|ObjectCollection findByEmail(string $email) Return ChildAccount objects filtered by the email column
 * @method     ChildAccount[]|ObjectCollection findByPassword(string $password) Return ChildAccount objects filtered by the password column
 * @method     ChildAccount[]|ObjectCollection findByNome(string $nome) Return ChildAccount objects filtered by the nome column
 * @method     ChildAccount[]|ObjectCollection findByIndirizzo(string $indirizzo) Return ChildAccount objects filtered by the indirizzo column
 * @method     ChildAccount[]|ObjectCollection findByTelefono(string $telefono) Return ChildAccount objects filtered by the telefono column
 * @method     ChildAccount[]|ObjectCollection findByAbilitato(boolean $abilitato) Return ChildAccount objects filtered by the abilitato column
 * @method     ChildAccount[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class AccountQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\AccountQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'dbspiaggie', $modelName = '\\Account', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildAccountQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildAccountQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildAccountQuery) {
            return $criteria;
        }
        $query = new ChildAccountQuery();
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
     * @return ChildAccount|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(AccountTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = AccountTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildAccount A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id_account, id_cliente, id_profilo, email, password, nome, indirizzo, telefono, abilitato FROM account WHERE id_account = :p0';
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
            /** @var ChildAccount $obj */
            $obj = new ChildAccount();
            $obj->hydrate($row);
            AccountTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildAccount|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildAccountQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(AccountTableMap::COL_ID_ACCOUNT, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildAccountQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(AccountTableMap::COL_ID_ACCOUNT, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the id_account column
     *
     * Example usage:
     * <code>
     * $query->filterByIdAccount(1234); // WHERE id_account = 1234
     * $query->filterByIdAccount(array(12, 34)); // WHERE id_account IN (12, 34)
     * $query->filterByIdAccount(array('min' => 12)); // WHERE id_account > 12
     * </code>
     *
     * @param     mixed $idAccount The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAccountQuery The current query, for fluid interface
     */
    public function filterByIdAccount($idAccount = null, $comparison = null)
    {
        if (is_array($idAccount)) {
            $useMinMax = false;
            if (isset($idAccount['min'])) {
                $this->addUsingAlias(AccountTableMap::COL_ID_ACCOUNT, $idAccount['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($idAccount['max'])) {
                $this->addUsingAlias(AccountTableMap::COL_ID_ACCOUNT, $idAccount['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AccountTableMap::COL_ID_ACCOUNT, $idAccount, $comparison);
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
     * @return $this|ChildAccountQuery The current query, for fluid interface
     */
    public function filterByIdCliente($idCliente = null, $comparison = null)
    {
        if (is_array($idCliente)) {
            $useMinMax = false;
            if (isset($idCliente['min'])) {
                $this->addUsingAlias(AccountTableMap::COL_ID_CLIENTE, $idCliente['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($idCliente['max'])) {
                $this->addUsingAlias(AccountTableMap::COL_ID_CLIENTE, $idCliente['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AccountTableMap::COL_ID_CLIENTE, $idCliente, $comparison);
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
     * @return $this|ChildAccountQuery The current query, for fluid interface
     */
    public function filterByIdProfilo($idProfilo = null, $comparison = null)
    {
        if (is_array($idProfilo)) {
            $useMinMax = false;
            if (isset($idProfilo['min'])) {
                $this->addUsingAlias(AccountTableMap::COL_ID_PROFILO, $idProfilo['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($idProfilo['max'])) {
                $this->addUsingAlias(AccountTableMap::COL_ID_PROFILO, $idProfilo['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AccountTableMap::COL_ID_PROFILO, $idProfilo, $comparison);
    }

    /**
     * Filter the query on the email column
     *
     * Example usage:
     * <code>
     * $query->filterByEmail('fooValue');   // WHERE email = 'fooValue'
     * $query->filterByEmail('%fooValue%', Criteria::LIKE); // WHERE email LIKE '%fooValue%'
     * </code>
     *
     * @param     string $email The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAccountQuery The current query, for fluid interface
     */
    public function filterByEmail($email = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($email)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AccountTableMap::COL_EMAIL, $email, $comparison);
    }

    /**
     * Filter the query on the password column
     *
     * Example usage:
     * <code>
     * $query->filterByPassword('fooValue');   // WHERE password = 'fooValue'
     * $query->filterByPassword('%fooValue%', Criteria::LIKE); // WHERE password LIKE '%fooValue%'
     * </code>
     *
     * @param     string $password The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAccountQuery The current query, for fluid interface
     */
    public function filterByPassword($password = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($password)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AccountTableMap::COL_PASSWORD, $password, $comparison);
    }

    /**
     * Filter the query on the nome column
     *
     * Example usage:
     * <code>
     * $query->filterByNome('fooValue');   // WHERE nome = 'fooValue'
     * $query->filterByNome('%fooValue%', Criteria::LIKE); // WHERE nome LIKE '%fooValue%'
     * </code>
     *
     * @param     string $nome The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAccountQuery The current query, for fluid interface
     */
    public function filterByNome($nome = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($nome)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AccountTableMap::COL_NOME, $nome, $comparison);
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
     * @return $this|ChildAccountQuery The current query, for fluid interface
     */
    public function filterByIndirizzo($indirizzo = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($indirizzo)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AccountTableMap::COL_INDIRIZZO, $indirizzo, $comparison);
    }

    /**
     * Filter the query on the telefono column
     *
     * Example usage:
     * <code>
     * $query->filterByTelefono('fooValue');   // WHERE telefono = 'fooValue'
     * $query->filterByTelefono('%fooValue%', Criteria::LIKE); // WHERE telefono LIKE '%fooValue%'
     * </code>
     *
     * @param     string $telefono The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAccountQuery The current query, for fluid interface
     */
    public function filterByTelefono($telefono = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($telefono)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AccountTableMap::COL_TELEFONO, $telefono, $comparison);
    }

    /**
     * Filter the query on the abilitato column
     *
     * Example usage:
     * <code>
     * $query->filterByAbilitato(true); // WHERE abilitato = true
     * $query->filterByAbilitato('yes'); // WHERE abilitato = true
     * </code>
     *
     * @param     boolean|string $abilitato The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAccountQuery The current query, for fluid interface
     */
    public function filterByAbilitato($abilitato = null, $comparison = null)
    {
        if (is_string($abilitato)) {
            $abilitato = in_array(strtolower($abilitato), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(AccountTableMap::COL_ABILITATO, $abilitato, $comparison);
    }

    /**
     * Filter the query by a related \Clienti object
     *
     * @param \Clienti|ObjectCollection $clienti The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildAccountQuery The current query, for fluid interface
     */
    public function filterByClienti($clienti, $comparison = null)
    {
        if ($clienti instanceof \Clienti) {
            return $this
                ->addUsingAlias(AccountTableMap::COL_ID_CLIENTE, $clienti->getIdCliente(), $comparison);
        } elseif ($clienti instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(AccountTableMap::COL_ID_CLIENTE, $clienti->toKeyValue('PrimaryKey', 'IdCliente'), $comparison);
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
     * @return $this|ChildAccountQuery The current query, for fluid interface
     */
    public function joinClienti($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
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
    public function useClientiQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinClienti($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Clienti', '\ClientiQuery');
    }

    /**
     * Filter the query by a related \Profili object
     *
     * @param \Profili|ObjectCollection $profili The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildAccountQuery The current query, for fluid interface
     */
    public function filterByProfili($profili, $comparison = null)
    {
        if ($profili instanceof \Profili) {
            return $this
                ->addUsingAlias(AccountTableMap::COL_ID_PROFILO, $profili->getIdProfilo(), $comparison);
        } elseif ($profili instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(AccountTableMap::COL_ID_PROFILO, $profili->toKeyValue('PrimaryKey', 'IdProfilo'), $comparison);
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
     * @return $this|ChildAccountQuery The current query, for fluid interface
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
     * @param   ChildAccount $account Object to remove from the list of results
     *
     * @return $this|ChildAccountQuery The current query, for fluid interface
     */
    public function prune($account = null)
    {
        if ($account) {
            $this->addUsingAlias(AccountTableMap::COL_ID_ACCOUNT, $account->getIdAccount(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the account table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(AccountTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            AccountTableMap::clearInstancePool();
            AccountTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(AccountTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(AccountTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            AccountTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            AccountTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // AccountQuery
