<?php

namespace Map;

use \DisponibilitaPostazione;
use \DisponibilitaPostazioneQuery;
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
 * This class defines the structure of the 'disponibilita_postazione' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class DisponibilitaPostazioneTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = '.Map.DisponibilitaPostazioneTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'dbspiaggie';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'disponibilita_postazione';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\DisponibilitaPostazione';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'DisponibilitaPostazione';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 4;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 4;

    /**
     * the column name for the id_disponibilita_postazione field
     */
    const COL_ID_DISPONIBILITA_POSTAZIONE = 'disponibilita_postazione.id_disponibilita_postazione';

    /**
     * the column name for the id_assegnamento_postazione field
     */
    const COL_ID_ASSEGNAMENTO_POSTAZIONE = 'disponibilita_postazione.id_assegnamento_postazione';

    /**
     * the column name for the data_inizio field
     */
    const COL_DATA_INIZIO = 'disponibilita_postazione.data_inizio';

    /**
     * the column name for the data_fine field
     */
    const COL_DATA_FINE = 'disponibilita_postazione.data_fine';

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
        self::TYPE_PHPNAME       => array('IdDisponibilitaPostazione', 'IdAssegnamentoPostazione', 'DataInizio', 'DataFine', ),
        self::TYPE_CAMELNAME     => array('idDisponibilitaPostazione', 'idAssegnamentoPostazione', 'dataInizio', 'dataFine', ),
        self::TYPE_COLNAME       => array(DisponibilitaPostazioneTableMap::COL_ID_DISPONIBILITA_POSTAZIONE, DisponibilitaPostazioneTableMap::COL_ID_ASSEGNAMENTO_POSTAZIONE, DisponibilitaPostazioneTableMap::COL_DATA_INIZIO, DisponibilitaPostazioneTableMap::COL_DATA_FINE, ),
        self::TYPE_FIELDNAME     => array('id_disponibilita_postazione', 'id_assegnamento_postazione', 'data_inizio', 'data_fine', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('IdDisponibilitaPostazione' => 0, 'IdAssegnamentoPostazione' => 1, 'DataInizio' => 2, 'DataFine' => 3, ),
        self::TYPE_CAMELNAME     => array('idDisponibilitaPostazione' => 0, 'idAssegnamentoPostazione' => 1, 'dataInizio' => 2, 'dataFine' => 3, ),
        self::TYPE_COLNAME       => array(DisponibilitaPostazioneTableMap::COL_ID_DISPONIBILITA_POSTAZIONE => 0, DisponibilitaPostazioneTableMap::COL_ID_ASSEGNAMENTO_POSTAZIONE => 1, DisponibilitaPostazioneTableMap::COL_DATA_INIZIO => 2, DisponibilitaPostazioneTableMap::COL_DATA_FINE => 3, ),
        self::TYPE_FIELDNAME     => array('id_disponibilita_postazione' => 0, 'id_assegnamento_postazione' => 1, 'data_inizio' => 2, 'data_fine' => 3, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, )
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
        $this->setName('disponibilita_postazione');
        $this->setPhpName('DisponibilitaPostazione');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\DisponibilitaPostazione');
        $this->setPackage('');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id_disponibilita_postazione', 'IdDisponibilitaPostazione', 'INTEGER', true, null, null);
        $this->addForeignKey('id_assegnamento_postazione', 'IdAssegnamentoPostazione', 'INTEGER', 'assegnamenti_postazione', 'id_assegnamento_postazione', true, null, null);
        $this->addColumn('data_inizio', 'DataInizio', 'TIMESTAMP', true, null, null);
        $this->addColumn('data_fine', 'DataFine', 'TIMESTAMP', true, null, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('AssegnamentiPostazione', '\\AssegnamentiPostazione', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':id_assegnamento_postazione',
    1 => ':id_assegnamento_postazione',
  ),
), null, null, null, false);
        $this->addRelation('SubaffittiPostazione', '\\SubaffittiPostazione', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':id_disponibilita_postazioni',
    1 => ':id_disponibilita_postazione',
  ),
), null, null, 'SubaffittiPostaziones', false);
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
        if ($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('IdDisponibilitaPostazione', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return null === $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('IdDisponibilitaPostazione', TableMap::TYPE_PHPNAME, $indexType)] || is_scalar($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('IdDisponibilitaPostazione', TableMap::TYPE_PHPNAME, $indexType)]) || is_callable([$row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('IdDisponibilitaPostazione', TableMap::TYPE_PHPNAME, $indexType)], '__toString']) ? (string) $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('IdDisponibilitaPostazione', TableMap::TYPE_PHPNAME, $indexType)] : $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('IdDisponibilitaPostazione', TableMap::TYPE_PHPNAME, $indexType)];
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
                : self::translateFieldName('IdDisponibilitaPostazione', TableMap::TYPE_PHPNAME, $indexType)
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
        return $withPrefix ? DisponibilitaPostazioneTableMap::CLASS_DEFAULT : DisponibilitaPostazioneTableMap::OM_CLASS;
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
     * @return array           (DisponibilitaPostazione object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = DisponibilitaPostazioneTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = DisponibilitaPostazioneTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + DisponibilitaPostazioneTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = DisponibilitaPostazioneTableMap::OM_CLASS;
            /** @var DisponibilitaPostazione $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            DisponibilitaPostazioneTableMap::addInstanceToPool($obj, $key);
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
            $key = DisponibilitaPostazioneTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = DisponibilitaPostazioneTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var DisponibilitaPostazione $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                DisponibilitaPostazioneTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(DisponibilitaPostazioneTableMap::COL_ID_DISPONIBILITA_POSTAZIONE);
            $criteria->addSelectColumn(DisponibilitaPostazioneTableMap::COL_ID_ASSEGNAMENTO_POSTAZIONE);
            $criteria->addSelectColumn(DisponibilitaPostazioneTableMap::COL_DATA_INIZIO);
            $criteria->addSelectColumn(DisponibilitaPostazioneTableMap::COL_DATA_FINE);
        } else {
            $criteria->addSelectColumn($alias . '.id_disponibilita_postazione');
            $criteria->addSelectColumn($alias . '.id_assegnamento_postazione');
            $criteria->addSelectColumn($alias . '.data_inizio');
            $criteria->addSelectColumn($alias . '.data_fine');
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
        return Propel::getServiceContainer()->getDatabaseMap(DisponibilitaPostazioneTableMap::DATABASE_NAME)->getTable(DisponibilitaPostazioneTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(DisponibilitaPostazioneTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(DisponibilitaPostazioneTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new DisponibilitaPostazioneTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a DisponibilitaPostazione or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or DisponibilitaPostazione object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(DisponibilitaPostazioneTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \DisponibilitaPostazione) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(DisponibilitaPostazioneTableMap::DATABASE_NAME);
            $criteria->add(DisponibilitaPostazioneTableMap::COL_ID_DISPONIBILITA_POSTAZIONE, (array) $values, Criteria::IN);
        }

        $query = DisponibilitaPostazioneQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            DisponibilitaPostazioneTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                DisponibilitaPostazioneTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the disponibilita_postazione table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return DisponibilitaPostazioneQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a DisponibilitaPostazione or Criteria object.
     *
     * @param mixed               $criteria Criteria or DisponibilitaPostazione object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(DisponibilitaPostazioneTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from DisponibilitaPostazione object
        }

        if ($criteria->containsKey(DisponibilitaPostazioneTableMap::COL_ID_DISPONIBILITA_POSTAZIONE) && $criteria->keyContainsValue(DisponibilitaPostazioneTableMap::COL_ID_DISPONIBILITA_POSTAZIONE) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.DisponibilitaPostazioneTableMap::COL_ID_DISPONIBILITA_POSTAZIONE.')');
        }


        // Set the correct dbName
        $query = DisponibilitaPostazioneQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // DisponibilitaPostazioneTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
DisponibilitaPostazioneTableMap::buildTableMap();
