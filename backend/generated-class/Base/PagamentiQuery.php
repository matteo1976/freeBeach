<?php

namespace Base;

use \Pagamenti as ChildPagamenti;
use \PagamentiQuery as ChildPagamentiQuery;
use \Exception;
use \PDO;
use Map\PagamentiTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'pagamenti' table.
 *
 *
 *
 * @method     ChildPagamentiQuery orderByIdPagamento($order = Criteria::ASC) Order by the id_pagamento column
 * @method     ChildPagamentiQuery orderByIdCliente($order = Criteria::ASC) Order by the id_cliente column
 * @method     ChildPagamentiQuery orderByData($order = Criteria::ASC) Order by the data column
 * @method     ChildPagamentiQuery orderByImporto($order = Criteria::ASC) Order by the importo column
 *
 * @method     ChildPagamentiQuery groupByIdPagamento() Group by the id_pagamento column
 * @method     ChildPagamentiQuery groupByIdCliente() Group by the id_cliente column
 * @method     ChildPagamentiQuery groupByData() Group by the data column
 * @method     ChildPagamentiQuery groupByImporto() Group by the importo column
 *
 * @method     ChildPagamentiQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildPagamentiQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildPagamentiQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildPagamentiQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildPagamentiQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildPagamentiQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildPagamentiQuery leftJoinClienti($relationAlias = null) Adds a LEFT JOIN clause to the query using the Clienti relation
 * @method     ChildPagamentiQuery rightJoinClienti($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Clienti relation
 * @method     ChildPagamentiQuery innerJoinClienti($relationAlias = null) Adds a INNER JOIN clause to the query using the Clienti relation
 *
 * @method     ChildPagamentiQuery joinWithClienti($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Clienti relation
 *
 * @method     ChildPagamentiQuery leftJoinWithClienti() Adds a LEFT JOIN clause and with to the query using the Clienti relation
 * @method     ChildPagamentiQuery rightJoinWithClienti() Adds a RIGHT JOIN clause and with to the query using the Clienti relation
 * @method     ChildPagamentiQuery innerJoinWithClienti() Adds a INNER JOIN clause and with to the query using the Clienti relation
 *
 * @method     \ClientiQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildPagamenti findOne(ConnectionInterface $con = null) Return the first ChildPagamenti matching the query
 * @method     ChildPagamenti findOneOrCreate(ConnectionInterface $con = null) Return the first ChildPagamenti matching the query, or a new ChildPagamenti object populated from the query conditions when no match is found
 *
 * @method     ChildPagamenti findOneByIdPagamento(int $id_pagamento) Return the first ChildPagamenti filtered by the id_pagamento column
 * @method     ChildPagamenti findOneByIdCliente(int $id_cliente) Return the first ChildPagamenti filtered by the id_cliente column
 * @method     ChildPagamenti findOneByData(string $data) Return the first ChildPagamenti filtered by the data column
 * @method     ChildPagamenti findOneByImporto(double $importo) Return the first ChildPagamenti filtered by the importo column *

 * @method     ChildPagamenti requirePk($key, ConnectionInterface $con = null) Return the ChildPagamenti by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPagamenti requireOne(ConnectionInterface $con = null) Return the first ChildPagamenti matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildPagamenti requireOneByIdPagamento(int $id_pagamento) Return the first ChildPagamenti filtered by the id_pagamento column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPagamenti requireOneByIdCliente(int $id_cliente) Return the first ChildPagamenti filtered by the id_cliente column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPagamenti requireOneByData(string $data) Return the first ChildPagamenti filtered by the data column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPagamenti requireOneByImporto(double $importo) Return the first ChildPagamenti filtered by the importo column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildPagamenti[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildPagamenti objects based on current ModelCriteria
 * @method     ChildPagamenti[]|ObjectCollection findByIdPagamento(int $id_pagamento) Return ChildPagamenti objects filtered by the id_pagamento column
 * @method     ChildPagamenti[]|ObjectCollection findByIdCliente(int $id_cliente) Return ChildPagamenti objects filtered by the id_cliente column
 * @method     ChildPagamenti[]|ObjectCollection findByData(string $data) Return ChildPagamenti objects filtered by the data column
 * @method     ChildPagamenti[]|ObjectCollection findByImporto(double $importo) Return ChildPagamenti objects filtered by the importo column
 * @method     ChildPagamenti[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class PagamentiQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\PagamentiQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'dbspiaggie', $modelName = '\\Pagamenti', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildPagamentiQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildPagamentiQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildPagamentiQuery) {
            return $criteria;
        }
        $query = new ChildPagamentiQuery();
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
     * @return ChildPagamenti|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(PagamentiTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = PagamentiTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildPagamenti A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id_pagamento, id_cliente, data, importo FROM pagamenti WHERE id_pagamento = :p0';
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
            /** @var ChildPagamenti $obj */
            $obj = new ChildPagamenti();
            $obj->hydrate($row);
            PagamentiTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildPagamenti|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildPagamentiQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(PagamentiTableMap::COL_ID_PAGAMENTO, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildPagamentiQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(PagamentiTableMap::COL_ID_PAGAMENTO, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the id_pagamento column
     *
     * Example usage:
     * <code>
     * $query->filterByIdPagamento(1234); // WHERE id_pagamento = 1234
     * $query->filterByIdPagamento(array(12, 34)); // WHERE id_pagamento IN (12, 34)
     * $query->filterByIdPagamento(array('min' => 12)); // WHERE id_pagamento > 12
     * </code>
     *
     * @param     mixed $idPagamento The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPagamentiQuery The current query, for fluid interface
     */
    public function filterByIdPagamento($idPagamento = null, $comparison = null)
    {
        if (is_array($idPagamento)) {
            $useMinMax = false;
            if (isset($idPagamento['min'])) {
                $this->addUsingAlias(PagamentiTableMap::COL_ID_PAGAMENTO, $idPagamento['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($idPagamento['max'])) {
                $this->addUsingAlias(PagamentiTableMap::COL_ID_PAGAMENTO, $idPagamento['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PagamentiTableMap::COL_ID_PAGAMENTO, $idPagamento, $comparison);
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
     * @return $this|ChildPagamentiQuery The current query, for fluid interface
     */
    public function filterByIdCliente($idCliente = null, $comparison = null)
    {
        if (is_array($idCliente)) {
            $useMinMax = false;
            if (isset($idCliente['min'])) {
                $this->addUsingAlias(PagamentiTableMap::COL_ID_CLIENTE, $idCliente['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($idCliente['max'])) {
                $this->addUsingAlias(PagamentiTableMap::COL_ID_CLIENTE, $idCliente['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PagamentiTableMap::COL_ID_CLIENTE, $idCliente, $comparison);
    }

    /**
     * Filter the query on the data column
     *
     * Example usage:
     * <code>
     * $query->filterByData('2011-03-14'); // WHERE data = '2011-03-14'
     * $query->filterByData('now'); // WHERE data = '2011-03-14'
     * $query->filterByData(array('max' => 'yesterday')); // WHERE data > '2011-03-13'
     * </code>
     *
     * @param     mixed $data The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPagamentiQuery The current query, for fluid interface
     */
    public function filterByData($data = null, $comparison = null)
    {
        if (is_array($data)) {
            $useMinMax = false;
            if (isset($data['min'])) {
                $this->addUsingAlias(PagamentiTableMap::COL_DATA, $data['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($data['max'])) {
                $this->addUsingAlias(PagamentiTableMap::COL_DATA, $data['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PagamentiTableMap::COL_DATA, $data, $comparison);
    }

    /**
     * Filter the query on the importo column
     *
     * Example usage:
     * <code>
     * $query->filterByImporto(1234); // WHERE importo = 1234
     * $query->filterByImporto(array(12, 34)); // WHERE importo IN (12, 34)
     * $query->filterByImporto(array('min' => 12)); // WHERE importo > 12
     * </code>
     *
     * @param     mixed $importo The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPagamentiQuery The current query, for fluid interface
     */
    public function filterByImporto($importo = null, $comparison = null)
    {
        if (is_array($importo)) {
            $useMinMax = false;
            if (isset($importo['min'])) {
                $this->addUsingAlias(PagamentiTableMap::COL_IMPORTO, $importo['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($importo['max'])) {
                $this->addUsingAlias(PagamentiTableMap::COL_IMPORTO, $importo['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PagamentiTableMap::COL_IMPORTO, $importo, $comparison);
    }

    /**
     * Filter the query by a related \Clienti object
     *
     * @param \Clienti|ObjectCollection $clienti The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildPagamentiQuery The current query, for fluid interface
     */
    public function filterByClienti($clienti, $comparison = null)
    {
        if ($clienti instanceof \Clienti) {
            return $this
                ->addUsingAlias(PagamentiTableMap::COL_ID_CLIENTE, $clienti->getIdCliente(), $comparison);
        } elseif ($clienti instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(PagamentiTableMap::COL_ID_CLIENTE, $clienti->toKeyValue('PrimaryKey', 'IdCliente'), $comparison);
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
     * @return $this|ChildPagamentiQuery The current query, for fluid interface
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
     * Exclude object from result
     *
     * @param   ChildPagamenti $pagamenti Object to remove from the list of results
     *
     * @return $this|ChildPagamentiQuery The current query, for fluid interface
     */
    public function prune($pagamenti = null)
    {
        if ($pagamenti) {
            $this->addUsingAlias(PagamentiTableMap::COL_ID_PAGAMENTO, $pagamenti->getIdPagamento(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the pagamenti table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(PagamentiTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            PagamentiTableMap::clearInstancePool();
            PagamentiTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(PagamentiTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(PagamentiTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            PagamentiTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            PagamentiTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // PagamentiQuery
