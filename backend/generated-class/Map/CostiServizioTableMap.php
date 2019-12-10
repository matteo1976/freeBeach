<?php

namespace Map;

use \CostiServizio;
use \CostiServizioQuery;
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
 * This class defines the structure of the 'costi_servizio' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class CostiServizioTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = '.Map.CostiServizioTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'dbspiaggie';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'costi_servizio';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\CostiServizio';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'CostiServizio';

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
     * the column name for the id_costo field
     */
    const COL_ID_COSTO = 'costi_servizio.id_costo';

    /**
     * the column name for the id_tipo_servizio field
     */
    const COL_ID_TIPO_SERVIZIO = 'costi_servizio.id_tipo_servizio';

    /**
     * the column name for the inizio_periodo field
     */
    const COL_INIZIO_PERIODO = 'costi_servizio.inizio_periodo';

    /**
     * the column name for the fine_periodo field
     */
    const COL_FINE_PERIODO = 'costi_servizio.fine_periodo';

    /**
     * the column name for the costo field
     */
    const COL_COSTO = 'costi_servizio.costo';

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
        self::TYPE_PHPNAME       => array('IdCosto', 'IdTipoServizio', 'InizioPeriodo', 'FinePeriodo', 'Costo', ),
        self::TYPE_CAMELNAME     => array('idCosto', 'idTipoServizio', 'inizioPeriodo', 'finePeriodo', 'costo', ),
        self::TYPE_COLNAME       => array(CostiServizioTableMap::COL_ID_COSTO, CostiServizioTableMap::COL_ID_TIPO_SERVIZIO, CostiServizioTableMap::COL_INIZIO_PERIODO, CostiServizioTableMap::COL_FINE_PERIODO, CostiServizioTableMap::COL_COSTO, ),
        self::TYPE_FIELDNAME     => array('id_costo', 'id_tipo_servizio', 'inizio_periodo', 'fine_periodo', 'costo', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('IdCosto' => 0, 'IdTipoServizio' => 1, 'InizioPeriodo' => 2, 'FinePeriodo' => 3, 'Costo' => 4, ),
        self::TYPE_CAMELNAME     => array('idCosto' => 0, 'idTipoServizio' => 1, 'inizioPeriodo' => 2, 'finePeriodo' => 3, 'costo' => 4, ),
        self::TYPE_COLNAME       => array(CostiServizioTableMap::COL_ID_COSTO => 0, CostiServizioTableMap::COL_ID_TIPO_SERVIZIO => 1, CostiServizioTableMap::COL_INIZIO_PERIODO => 2, CostiServizioTableMap::COL_FINE_PERIODO => 3, CostiServizioTableMap::COL_COSTO => 4, ),
        self::TYPE_FIELDNAME     => array('id_costo' => 0, 'id_tipo_servizio' => 1, 'inizio_periodo' => 2, 'fine_periodo' => 3, 'costo' => 4, ),
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
        $this->setName('costi_servizio');
        $this->setPhpName('CostiServizio');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\CostiServizio');
        $this->setPackage('');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id_costo', 'IdCosto', 'INTEGER', true, null, null);
        $this->addForeignKey('id_tipo_servizio', 'IdTipoServizio', 'INTEGER', 'tipi_servizio', 'id_tipo_servizio', true, null, null);
        $this->addColumn('inizio_periodo', 'InizioPeriodo', 'DATE', false, null, null);
        $this->addColumn('fine_periodo', 'FinePeriodo', 'DATE', false, null, null);
        $this->addColumn('costo', 'Costo', 'FLOAT', true, null, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('TipiServizio', '\\TipiServizio', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':id_tipo_servizio',
    1 => ':id_tipo_servizio',
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
        if ($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('IdCosto', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return null === $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('IdCosto', TableMap::TYPE_PHPNAME, $indexType)] || is_scalar($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('IdCosto', TableMap::TYPE_PHPNAME, $indexType)]) || is_callable([$row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('IdCosto', TableMap::TYPE_PHPNAME, $indexType)], '__toString']) ? (string) $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('IdCosto', TableMap::TYPE_PHPNAME, $indexType)] : $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('IdCosto', TableMap::TYPE_PHPNAME, $indexType)];
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
                : self::translateFieldName('IdCosto', TableMap::TYPE_PHPNAME, $indexType)
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
        return $withPrefix ? CostiServizioTableMap::CLASS_DEFAULT : CostiServizioTableMap::OM_CLASS;
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
     * @return array           (CostiServizio object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = CostiServizioTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = CostiServizioTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + CostiServizioTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = CostiServizioTableMap::OM_CLASS;
            /** @var CostiServizio $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            CostiServizioTableMap::addInstanceToPool($obj, $key);
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
            $key = CostiServizioTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = CostiServizioTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var CostiServizio $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                CostiServizioTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(CostiServizioTableMap::COL_ID_COSTO);
            $criteria->addSelectColumn(CostiServizioTableMap::COL_ID_TIPO_SERVIZIO);
            $criteria->addSelectColumn(CostiServizioTableMap::COL_INIZIO_PERIODO);
            $criteria->addSelectColumn(CostiServizioTableMap::COL_FINE_PERIODO);
            $criteria->addSelectColumn(CostiServizioTableMap::COL_COSTO);
        } else {
            $criteria->addSelectColumn($alias . '.id_costo');
            $criteria->addSelectColumn($alias . '.id_tipo_servizio');
            $criteria->addSelectColumn($alias . '.inizio_periodo');
            $criteria->addSelectColumn($alias . '.fine_periodo');
            $criteria->addSelectColumn($alias . '.costo');
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
        return Propel::getServiceContainer()->getDatabaseMap(CostiServizioTableMap::DATABASE_NAME)->getTable(CostiServizioTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(CostiServizioTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(CostiServizioTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new CostiServizioTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a CostiServizio or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or CostiServizio object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(CostiServizioTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \CostiServizio) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(CostiServizioTableMap::DATABASE_NAME);
            $criteria->add(CostiServizioTableMap::COL_ID_COSTO, (array) $values, Criteria::IN);
        }

        $query = CostiServizioQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            CostiServizioTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                CostiServizioTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the costi_servizio table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return CostiServizioQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a CostiServizio or Criteria object.
     *
     * @param mixed               $criteria Criteria or CostiServizio object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(CostiServizioTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from CostiServizio object
        }

        if ($criteria->containsKey(CostiServizioTableMap::COL_ID_COSTO) && $criteria->keyContainsValue(CostiServizioTableMap::COL_ID_COSTO) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.CostiServizioTableMap::COL_ID_COSTO.')');
        }


        // Set the correct dbName
        $query = CostiServizioQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // CostiServizioTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
CostiServizioTableMap::buildTableMap();
