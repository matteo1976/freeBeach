<?php

namespace Map;

use \Servizi;
use \ServiziQuery;
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
 * This class defines the structure of the 'servizi' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class ServiziTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = '.Map.ServiziTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'dbspiaggie';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'servizi';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\Servizi';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'Servizi';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 8;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 8;

    /**
     * the column name for the id_servizio field
     */
    const COL_ID_SERVIZIO = 'servizi.id_servizio';

    /**
     * the column name for the id_assegnamento_postazione field
     */
    const COL_ID_ASSEGNAMENTO_POSTAZIONE = 'servizi.id_assegnamento_postazione';

    /**
     * the column name for the id_tipo_servizio field
     */
    const COL_ID_TIPO_SERVIZIO = 'servizi.id_tipo_servizio';

    /**
     * the column name for the data_inizio field
     */
    const COL_DATA_INIZIO = 'servizi.data_inizio';

    /**
     * the column name for the data_fine field
     */
    const COL_DATA_FINE = 'servizi.data_fine';

    /**
     * the column name for the qta field
     */
    const COL_QTA = 'servizi.qta';

    /**
     * the column name for the costo_finale field
     */
    const COL_COSTO_FINALE = 'servizi.costo_finale';

    /**
     * the column name for the note field
     */
    const COL_NOTE = 'servizi.note';

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
        self::TYPE_PHPNAME       => array('IdServizio', 'IdAssegnamentoPostazione', 'IdTipoServizio', 'DataInizio', 'DataFine', 'Qta', 'CostoFinale', 'Note', ),
        self::TYPE_CAMELNAME     => array('idServizio', 'idAssegnamentoPostazione', 'idTipoServizio', 'dataInizio', 'dataFine', 'qta', 'costoFinale', 'note', ),
        self::TYPE_COLNAME       => array(ServiziTableMap::COL_ID_SERVIZIO, ServiziTableMap::COL_ID_ASSEGNAMENTO_POSTAZIONE, ServiziTableMap::COL_ID_TIPO_SERVIZIO, ServiziTableMap::COL_DATA_INIZIO, ServiziTableMap::COL_DATA_FINE, ServiziTableMap::COL_QTA, ServiziTableMap::COL_COSTO_FINALE, ServiziTableMap::COL_NOTE, ),
        self::TYPE_FIELDNAME     => array('id_servizio', 'id_assegnamento_postazione', 'id_tipo_servizio', 'data_inizio', 'data_fine', 'qta', 'costo_finale', 'note', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('IdServizio' => 0, 'IdAssegnamentoPostazione' => 1, 'IdTipoServizio' => 2, 'DataInizio' => 3, 'DataFine' => 4, 'Qta' => 5, 'CostoFinale' => 6, 'Note' => 7, ),
        self::TYPE_CAMELNAME     => array('idServizio' => 0, 'idAssegnamentoPostazione' => 1, 'idTipoServizio' => 2, 'dataInizio' => 3, 'dataFine' => 4, 'qta' => 5, 'costoFinale' => 6, 'note' => 7, ),
        self::TYPE_COLNAME       => array(ServiziTableMap::COL_ID_SERVIZIO => 0, ServiziTableMap::COL_ID_ASSEGNAMENTO_POSTAZIONE => 1, ServiziTableMap::COL_ID_TIPO_SERVIZIO => 2, ServiziTableMap::COL_DATA_INIZIO => 3, ServiziTableMap::COL_DATA_FINE => 4, ServiziTableMap::COL_QTA => 5, ServiziTableMap::COL_COSTO_FINALE => 6, ServiziTableMap::COL_NOTE => 7, ),
        self::TYPE_FIELDNAME     => array('id_servizio' => 0, 'id_assegnamento_postazione' => 1, 'id_tipo_servizio' => 2, 'data_inizio' => 3, 'data_fine' => 4, 'qta' => 5, 'costo_finale' => 6, 'note' => 7, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, )
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
        $this->setName('servizi');
        $this->setPhpName('Servizi');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\Servizi');
        $this->setPackage('');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id_servizio', 'IdServizio', 'INTEGER', true, null, null);
        $this->addForeignKey('id_assegnamento_postazione', 'IdAssegnamentoPostazione', 'INTEGER', 'assegnamenti_postazione', 'id_assegnamento_postazione', true, null, null);
        $this->addForeignKey('id_tipo_servizio', 'IdTipoServizio', 'INTEGER', 'tipi_servizio', 'id_tipo_servizio', true, null, null);
        $this->addColumn('data_inizio', 'DataInizio', 'TIMESTAMP', true, null, null);
        $this->addColumn('data_fine', 'DataFine', 'TIMESTAMP', true, null, null);
        $this->addColumn('qta', 'Qta', 'INTEGER', true, null, null);
        $this->addColumn('costo_finale', 'CostoFinale', 'FLOAT', true, null, null);
        $this->addColumn('note', 'Note', 'VARCHAR', false, 100, null);
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
        if ($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('IdServizio', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return null === $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('IdServizio', TableMap::TYPE_PHPNAME, $indexType)] || is_scalar($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('IdServizio', TableMap::TYPE_PHPNAME, $indexType)]) || is_callable([$row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('IdServizio', TableMap::TYPE_PHPNAME, $indexType)], '__toString']) ? (string) $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('IdServizio', TableMap::TYPE_PHPNAME, $indexType)] : $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('IdServizio', TableMap::TYPE_PHPNAME, $indexType)];
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
                : self::translateFieldName('IdServizio', TableMap::TYPE_PHPNAME, $indexType)
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
        return $withPrefix ? ServiziTableMap::CLASS_DEFAULT : ServiziTableMap::OM_CLASS;
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
     * @return array           (Servizi object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = ServiziTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = ServiziTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + ServiziTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = ServiziTableMap::OM_CLASS;
            /** @var Servizi $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            ServiziTableMap::addInstanceToPool($obj, $key);
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
            $key = ServiziTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = ServiziTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var Servizi $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                ServiziTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(ServiziTableMap::COL_ID_SERVIZIO);
            $criteria->addSelectColumn(ServiziTableMap::COL_ID_ASSEGNAMENTO_POSTAZIONE);
            $criteria->addSelectColumn(ServiziTableMap::COL_ID_TIPO_SERVIZIO);
            $criteria->addSelectColumn(ServiziTableMap::COL_DATA_INIZIO);
            $criteria->addSelectColumn(ServiziTableMap::COL_DATA_FINE);
            $criteria->addSelectColumn(ServiziTableMap::COL_QTA);
            $criteria->addSelectColumn(ServiziTableMap::COL_COSTO_FINALE);
            $criteria->addSelectColumn(ServiziTableMap::COL_NOTE);
        } else {
            $criteria->addSelectColumn($alias . '.id_servizio');
            $criteria->addSelectColumn($alias . '.id_assegnamento_postazione');
            $criteria->addSelectColumn($alias . '.id_tipo_servizio');
            $criteria->addSelectColumn($alias . '.data_inizio');
            $criteria->addSelectColumn($alias . '.data_fine');
            $criteria->addSelectColumn($alias . '.qta');
            $criteria->addSelectColumn($alias . '.costo_finale');
            $criteria->addSelectColumn($alias . '.note');
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
        return Propel::getServiceContainer()->getDatabaseMap(ServiziTableMap::DATABASE_NAME)->getTable(ServiziTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(ServiziTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(ServiziTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new ServiziTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a Servizi or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or Servizi object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(ServiziTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \Servizi) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(ServiziTableMap::DATABASE_NAME);
            $criteria->add(ServiziTableMap::COL_ID_SERVIZIO, (array) $values, Criteria::IN);
        }

        $query = ServiziQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            ServiziTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                ServiziTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the servizi table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return ServiziQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a Servizi or Criteria object.
     *
     * @param mixed               $criteria Criteria or Servizi object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(ServiziTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from Servizi object
        }

        if ($criteria->containsKey(ServiziTableMap::COL_ID_SERVIZIO) && $criteria->keyContainsValue(ServiziTableMap::COL_ID_SERVIZIO) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.ServiziTableMap::COL_ID_SERVIZIO.')');
        }


        // Set the correct dbName
        $query = ServiziQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // ServiziTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
ServiziTableMap::buildTableMap();
