<?php

namespace Map;

use \Schede;
use \SchedeQuery;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\InstancePoolTrait;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\DataFetcher\DataFetcherInterface;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\RelationMap;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Map\TableMapTrait;


/**
 * This class defines the structure of the 'schede' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class SchedeTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = '.Map.SchedeTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'dbspiaggie';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'schede';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\Schede';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'Schede';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 5;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 5;

    /**
     * the column name for the id_scheda field
     */
    const COL_ID_SCHEDA = 'schede.id_scheda';

    /**
     * the column name for the id_cliente field
     */
    const COL_ID_CLIENTE = 'schede.id_cliente';

    /**
     * the column name for the codice_scheda field
     */
    const COL_CODICE_SCHEDA = 'schede.codice_scheda';

    /**
     * the column name for the importo_scheda field
     */
    const COL_IMPORTO_SCHEDA = 'schede.importo_scheda';

    /**
     * the column name for the data_rilascio field
     */
    const COL_DATA_RILASCIO = 'schede.data_rilascio';

    /**
     * The default string format for model objects of the related table
     */
    const DEFAULT_STRING_FORMAT = 'YAML';

    /**
     * holds an array of fieldnames
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldNames[self::TYPE_PHPNAME][0] = 'Id'
     */
    protected static $fieldNames = array (
        self::TYPE_PHPNAME       => array('IdScheda', 'IdCliente', 'CodiceScheda', 'ImportoScheda', 'DataRilascio', ),
        self::TYPE_CAMELNAME     => array('idScheda', 'idCliente', 'codiceScheda', 'importoScheda', 'dataRilascio', ),
        self::TYPE_COLNAME       => array(SchedeTableMap::COL_ID_SCHEDA, SchedeTableMap::COL_ID_CLIENTE, SchedeTableMap::COL_CODICE_SCHEDA, SchedeTableMap::COL_IMPORTO_SCHEDA, SchedeTableMap::COL_DATA_RILASCIO, ),
        self::TYPE_FIELDNAME     => array('id_scheda', 'id_cliente', 'codice_scheda', 'importo_scheda', 'data_rilascio', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('IdScheda' => 0, 'IdCliente' => 1, 'CodiceScheda' => 2, 'ImportoScheda' => 3, 'DataRilascio' => 4, ),
        self::TYPE_CAMELNAME     => array('idScheda' => 0, 'idCliente' => 1, 'codiceScheda' => 2, 'importoScheda' => 3, 'dataRilascio' => 4, ),
        self::TYPE_COLNAME       => array(SchedeTableMap::COL_ID_SCHEDA => 0, SchedeTableMap::COL_ID_CLIENTE => 1, SchedeTableMap::COL_CODICE_SCHEDA => 2, SchedeTableMap::COL_IMPORTO_SCHEDA => 3, SchedeTableMap::COL_DATA_RILASCIO => 4, ),
        self::TYPE_FIELDNAME     => array('id_scheda' => 0, 'id_cliente' => 1, 'codice_scheda' => 2, 'importo_scheda' => 3, 'data_rilascio' => 4, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, )
    );

    /**
     * Initialize the table attributes and columns
     * Relations are not initialized by this method since they are lazy loaded
     *
     * @return void
     * @throws PropelException
     */
    public function initialize()
    {
        // attributes
        $this->setName('schede');
        $this->setPhpName('Schede');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\Schede');
        $this->setPackage('');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id_scheda', 'IdScheda', 'INTEGER', true, null, null);
        $this->addForeignKey('id_cliente', 'IdCliente', 'INTEGER', 'clienti', 'id_cliente', false, null, null);
        $this->addColumn('codice_scheda', 'CodiceScheda', 'VARCHAR', true, 45, null);
        $this->addColumn('importo_scheda', 'ImportoScheda', 'FLOAT', false, null, null);
        $this->addColumn('data_rilascio', 'DataRilascio', 'TIMESTAMP', false, null, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Clienti', '\\Clienti', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':id_cliente',
    1 => ':id_cliente',
  ),
), null, null, null, false);
    } // buildRelations()

    /**
     * Retrieves a string version of the primary key from the DB resultset row that can be used to uniquely identify a row in this table.
     *
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, a serialize()d version of the primary key will be returned.
     *
     * @param array  $row       resultset row.
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM
     *
     * @return string The primary key hash of the row
     */
    public static function getPrimaryKeyHashFromRow($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        // If the PK cannot be derived from the row, return NULL.
        if ($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('IdScheda', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return null === $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('IdScheda', TableMap::TYPE_PHPNAME, $indexType)] || is_scalar($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('IdScheda', TableMap::TYPE_PHPNAME, $indexType)]) || is_callable([$row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('IdScheda', TableMap::TYPE_PHPNAME, $indexType)], '__toString']) ? (string) $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('IdScheda', TableMap::TYPE_PHPNAME, $indexType)] : $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('IdScheda', TableMap::TYPE_PHPNAME, $indexType)];
    }

    /**
     * Retrieves the primary key from the DB resultset row
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, an array of the primary key columns will be returned.
     *
     * @param array  $row       resultset row.
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM
     *
     * @return mixed The primary key of the row
     */
    public static function getPrimaryKeyFromRow($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        return (int) $row[
            $indexType == TableMap::TYPE_NUM
                ? 0 + $offset
                : self::translateFieldName('IdScheda', TableMap::TYPE_PHPNAME, $indexType)
        ];
    }

    /**
     * The class that the tableMap will make instances of.
     *
     * If $withPrefix is true, the returned path
     * uses a dot-path notation which is translated into a path
     * relative to a location on the PHP include_path.
     * (e.g. path.to.MyClass -> 'path/to/MyClass.php')
     *
     * @param boolean $withPrefix Whether or not to return the path with the class name
     * @return string path.to.ClassName
     */
    public static function getOMClass($withPrefix = true)
    {
        return $withPrefix ? SchedeTableMap::CLASS_DEFAULT : SchedeTableMap::OM_CLASS;
    }

    /**
     * Populates an object of the default type or an object that inherit from the default.
     *
     * @param array  $row       row returned by DataFetcher->fetch().
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType The index type of $row. Mostly DataFetcher->getIndexType().
                                 One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     * @return array           (Schede object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = SchedeTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = SchedeTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + SchedeTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = SchedeTableMap::OM_CLASS;
            /** @var Schede $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            SchedeTableMap::addInstanceToPool($obj, $key);
        }

        return array($obj, $col);
    }

    /**
     * The returned array will contain objects of the default type or
     * objects that inherit from the default.
     *
     * @param DataFetcherInterface $dataFetcher
     * @return array
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function populateObjects(DataFetcherInterface $dataFetcher)
    {
        $results = array();

        // set the class once to avoid overhead in the loop
        $cls = static::getOMClass(false);
        // populate the object(s)
        while ($row = $dataFetcher->fetch()) {
            $key = SchedeTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = SchedeTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var Schede $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                SchedeTableMap::addInstanceToPool($obj, $key);
            } // if key exists
        }

        return $results;
    }
    /**
     * Add all the columns needed to create a new object.
     *
     * Note: any columns that were marked with lazyLoad="true" in the
     * XML schema will not be added to the select list and only loaded
     * on demand.
     *
     * @param Criteria $criteria object containing the columns to add.
     * @param string   $alias    optional table alias
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function addSelectColumns(Criteria $criteria, $alias = null)
    {
        if (null === $alias) {
            $criteria->addSelectColumn(SchedeTableMap::COL_ID_SCHEDA);
            $criteria->addSelectColumn(SchedeTableMap::COL_ID_CLIENTE);
            $criteria->addSelectColumn(SchedeTableMap::COL_CODICE_SCHEDA);
            $criteria->addSelectColumn(SchedeTableMap::COL_IMPORTO_SCHEDA);
            $criteria->addSelectColumn(SchedeTableMap::COL_DATA_RILASCIO);
        } else {
            $criteria->addSelectColumn($alias . '.id_scheda');
            $criteria->addSelectColumn($alias . '.id_cliente');
            $criteria->addSelectColumn($alias . '.codice_scheda');
            $criteria->addSelectColumn($alias . '.importo_scheda');
            $criteria->addSelectColumn($alias . '.data_rilascio');
        }
    }

    /**
     * Returns the TableMap related to this object.
     * This method is not needed for general use but a specific application could have a need.
     * @return TableMap
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function getTableMap()
    {
        return Propel::getServiceContainer()->getDatabaseMap(SchedeTableMap::DATABASE_NAME)->getTable(SchedeTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(SchedeTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(SchedeTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new SchedeTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a Schede or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or Schede object or primary key or array of primary keys
     *              which is used to create the DELETE statement
     * @param  ConnectionInterface $con the connection to use
     * @return int             The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                         if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
     public static function doDelete($values, ConnectionInterface $con = null)
     {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(SchedeTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \Schede) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(SchedeTableMap::DATABASE_NAME);
            $criteria->add(SchedeTableMap::COL_ID_SCHEDA, (array) $values, Criteria::IN);
        }

        $query = SchedeQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            SchedeTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                SchedeTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the schede table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return SchedeQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a Schede or Criteria object.
     *
     * @param mixed               $criteria Criteria or Schede object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(SchedeTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from Schede object
        }

        if ($criteria->containsKey(SchedeTableMap::COL_ID_SCHEDA) && $criteria->keyContainsValue(SchedeTableMap::COL_ID_SCHEDA) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.SchedeTableMap::COL_ID_SCHEDA.')');
        }


        // Set the correct dbName
        $query = SchedeQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // SchedeTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
SchedeTableMap::buildTableMap();
