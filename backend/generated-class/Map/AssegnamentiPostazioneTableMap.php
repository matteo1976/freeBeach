<?php

namespace Map;

use \AssegnamentiPostazione;
use \AssegnamentiPostazioneQuery;
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
 * This class defines the structure of the 'assegnamenti_postazione' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class AssegnamentiPostazioneTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = '.Map.AssegnamentiPostazioneTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'dbspiaggie';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'assegnamenti_postazione';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\AssegnamentiPostazione';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'AssegnamentiPostazione';

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
     * the column name for the id_assegnamento_postazione field
     */
    const COL_ID_ASSEGNAMENTO_POSTAZIONE = 'assegnamenti_postazione.id_assegnamento_postazione';

    /**
     * the column name for the id_cliente field
     */
    const COL_ID_CLIENTE = 'assegnamenti_postazione.id_cliente';

    /**
     * the column name for the id_postazione field
     */
    const COL_ID_POSTAZIONE = 'assegnamenti_postazione.id_postazione';

    /**
     * the column name for the id_abbonamento field
     */
    const COL_ID_ABBONAMENTO = 'assegnamenti_postazione.id_abbonamento';

    /**
     * the column name for the data_inizio field
     */
    const COL_DATA_INIZIO = 'assegnamenti_postazione.data_inizio';

    /**
     * the column name for the data_fine field
     */
    const COL_DATA_FINE = 'assegnamenti_postazione.data_fine';

    /**
     * the column name for the autorizzati field
     */
    const COL_AUTORIZZATI = 'assegnamenti_postazione.autorizzati';

    /**
     * the column name for the note field
     */
    const COL_NOTE = 'assegnamenti_postazione.note';

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
        self::TYPE_PHPNAME       => array('IdAssegnamentoPostazione', 'IdCliente', 'IdPostazione', 'IdAbbonamento', 'DataInizio', 'DataFine', 'Autorizzati', 'Note', ),
        self::TYPE_CAMELNAME     => array('idAssegnamentoPostazione', 'idCliente', 'idPostazione', 'idAbbonamento', 'dataInizio', 'dataFine', 'autorizzati', 'note', ),
        self::TYPE_COLNAME       => array(AssegnamentiPostazioneTableMap::COL_ID_ASSEGNAMENTO_POSTAZIONE, AssegnamentiPostazioneTableMap::COL_ID_CLIENTE, AssegnamentiPostazioneTableMap::COL_ID_POSTAZIONE, AssegnamentiPostazioneTableMap::COL_ID_ABBONAMENTO, AssegnamentiPostazioneTableMap::COL_DATA_INIZIO, AssegnamentiPostazioneTableMap::COL_DATA_FINE, AssegnamentiPostazioneTableMap::COL_AUTORIZZATI, AssegnamentiPostazioneTableMap::COL_NOTE, ),
        self::TYPE_FIELDNAME     => array('id_assegnamento_postazione', 'id_cliente', 'id_postazione', 'id_abbonamento', 'data_inizio', 'data_fine', 'autorizzati', 'note', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('IdAssegnamentoPostazione' => 0, 'IdCliente' => 1, 'IdPostazione' => 2, 'IdAbbonamento' => 3, 'DataInizio' => 4, 'DataFine' => 5, 'Autorizzati' => 6, 'Note' => 7, ),
        self::TYPE_CAMELNAME     => array('idAssegnamentoPostazione' => 0, 'idCliente' => 1, 'idPostazione' => 2, 'idAbbonamento' => 3, 'dataInizio' => 4, 'dataFine' => 5, 'autorizzati' => 6, 'note' => 7, ),
        self::TYPE_COLNAME       => array(AssegnamentiPostazioneTableMap::COL_ID_ASSEGNAMENTO_POSTAZIONE => 0, AssegnamentiPostazioneTableMap::COL_ID_CLIENTE => 1, AssegnamentiPostazioneTableMap::COL_ID_POSTAZIONE => 2, AssegnamentiPostazioneTableMap::COL_ID_ABBONAMENTO => 3, AssegnamentiPostazioneTableMap::COL_DATA_INIZIO => 4, AssegnamentiPostazioneTableMap::COL_DATA_FINE => 5, AssegnamentiPostazioneTableMap::COL_AUTORIZZATI => 6, AssegnamentiPostazioneTableMap::COL_NOTE => 7, ),
        self::TYPE_FIELDNAME     => array('id_assegnamento_postazione' => 0, 'id_cliente' => 1, 'id_postazione' => 2, 'id_abbonamento' => 3, 'data_inizio' => 4, 'data_fine' => 5, 'autorizzati' => 6, 'note' => 7, ),
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
        $this->setName('assegnamenti_postazione');
        $this->setPhpName('AssegnamentiPostazione');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\AssegnamentiPostazione');
        $this->setPackage('');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id_assegnamento_postazione', 'IdAssegnamentoPostazione', 'INTEGER', true, null, null);
        $this->addForeignKey('id_cliente', 'IdCliente', 'INTEGER', 'clienti', 'id_cliente', true, null, null);
        $this->addForeignKey('id_postazione', 'IdPostazione', 'INTEGER', 'postazioni', 'id_postazione', true, null, null);
        $this->addForeignKey('id_abbonamento', 'IdAbbonamento', 'INTEGER', 'abbonamenti', 'id_abbonamento', true, null, null);
        $this->addColumn('data_inizio', 'DataInizio', 'TIMESTAMP', true, null, null);
        $this->addColumn('data_fine', 'DataFine', 'TIMESTAMP', true, null, null);
        $this->addColumn('autorizzati', 'Autorizzati', 'VARCHAR', false, 100, null);
        $this->addColumn('note', 'Note', 'VARCHAR', false, 100, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Postazioni', '\\Postazioni', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':id_postazione',
    1 => ':id_postazione',
  ),
), null, null, null, false);
        $this->addRelation('Clienti', '\\Clienti', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':id_cliente',
    1 => ':id_cliente',
  ),
), null, null, null, false);
        $this->addRelation('Abbonamenti', '\\Abbonamenti', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':id_abbonamento',
    1 => ':id_abbonamento',
  ),
), null, null, null, false);
        $this->addRelation('DisponibilitaPostazione', '\\DisponibilitaPostazione', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':id_assegnamento_postazione',
    1 => ':id_assegnamento_postazione',
  ),
), null, null, 'DisponibilitaPostaziones', false);
        $this->addRelation('Servizi', '\\Servizi', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':id_assegnamento_postazione',
    1 => ':id_assegnamento_postazione',
  ),
), null, null, 'Servizis', false);
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
        if ($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('IdAssegnamentoPostazione', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return null === $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('IdAssegnamentoPostazione', TableMap::TYPE_PHPNAME, $indexType)] || is_scalar($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('IdAssegnamentoPostazione', TableMap::TYPE_PHPNAME, $indexType)]) || is_callable([$row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('IdAssegnamentoPostazione', TableMap::TYPE_PHPNAME, $indexType)], '__toString']) ? (string) $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('IdAssegnamentoPostazione', TableMap::TYPE_PHPNAME, $indexType)] : $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('IdAssegnamentoPostazione', TableMap::TYPE_PHPNAME, $indexType)];
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
                : self::translateFieldName('IdAssegnamentoPostazione', TableMap::TYPE_PHPNAME, $indexType)
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
        return $withPrefix ? AssegnamentiPostazioneTableMap::CLASS_DEFAULT : AssegnamentiPostazioneTableMap::OM_CLASS;
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
     * @return array           (AssegnamentiPostazione object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = AssegnamentiPostazioneTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = AssegnamentiPostazioneTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + AssegnamentiPostazioneTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = AssegnamentiPostazioneTableMap::OM_CLASS;
            /** @var AssegnamentiPostazione $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            AssegnamentiPostazioneTableMap::addInstanceToPool($obj, $key);
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
            $key = AssegnamentiPostazioneTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = AssegnamentiPostazioneTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var AssegnamentiPostazione $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                AssegnamentiPostazioneTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(AssegnamentiPostazioneTableMap::COL_ID_ASSEGNAMENTO_POSTAZIONE);
            $criteria->addSelectColumn(AssegnamentiPostazioneTableMap::COL_ID_CLIENTE);
            $criteria->addSelectColumn(AssegnamentiPostazioneTableMap::COL_ID_POSTAZIONE);
            $criteria->addSelectColumn(AssegnamentiPostazioneTableMap::COL_ID_ABBONAMENTO);
            $criteria->addSelectColumn(AssegnamentiPostazioneTableMap::COL_DATA_INIZIO);
            $criteria->addSelectColumn(AssegnamentiPostazioneTableMap::COL_DATA_FINE);
            $criteria->addSelectColumn(AssegnamentiPostazioneTableMap::COL_AUTORIZZATI);
            $criteria->addSelectColumn(AssegnamentiPostazioneTableMap::COL_NOTE);
        } else {
            $criteria->addSelectColumn($alias . '.id_assegnamento_postazione');
            $criteria->addSelectColumn($alias . '.id_cliente');
            $criteria->addSelectColumn($alias . '.id_postazione');
            $criteria->addSelectColumn($alias . '.id_abbonamento');
            $criteria->addSelectColumn($alias . '.data_inizio');
            $criteria->addSelectColumn($alias . '.data_fine');
            $criteria->addSelectColumn($alias . '.autorizzati');
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
        return Propel::getServiceContainer()->getDatabaseMap(AssegnamentiPostazioneTableMap::DATABASE_NAME)->getTable(AssegnamentiPostazioneTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(AssegnamentiPostazioneTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(AssegnamentiPostazioneTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new AssegnamentiPostazioneTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a AssegnamentiPostazione or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or AssegnamentiPostazione object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(AssegnamentiPostazioneTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \AssegnamentiPostazione) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(AssegnamentiPostazioneTableMap::DATABASE_NAME);
            $criteria->add(AssegnamentiPostazioneTableMap::COL_ID_ASSEGNAMENTO_POSTAZIONE, (array) $values, Criteria::IN);
        }

        $query = AssegnamentiPostazioneQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            AssegnamentiPostazioneTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                AssegnamentiPostazioneTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the assegnamenti_postazione table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return AssegnamentiPostazioneQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a AssegnamentiPostazione or Criteria object.
     *
     * @param mixed               $criteria Criteria or AssegnamentiPostazione object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(AssegnamentiPostazioneTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from AssegnamentiPostazione object
        }

        if ($criteria->containsKey(AssegnamentiPostazioneTableMap::COL_ID_ASSEGNAMENTO_POSTAZIONE) && $criteria->keyContainsValue(AssegnamentiPostazioneTableMap::COL_ID_ASSEGNAMENTO_POSTAZIONE) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.AssegnamentiPostazioneTableMap::COL_ID_ASSEGNAMENTO_POSTAZIONE.')');
        }


        // Set the correct dbName
        $query = AssegnamentiPostazioneQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // AssegnamentiPostazioneTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
AssegnamentiPostazioneTableMap::buildTableMap();
