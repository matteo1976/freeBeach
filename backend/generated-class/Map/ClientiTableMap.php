<?php

namespace Map;

use \Clienti;
use \ClientiQuery;
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
 * This class defines the structure of the 'clienti' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class ClientiTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = '.Map.ClientiTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'dbspiaggie';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'clienti';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\Clienti';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'Clienti';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 9;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 9;

    /**
     * the column name for the id_cliente field
     */
    const COL_ID_CLIENTE = 'clienti.id_cliente';

    /**
     * the column name for the da_saldare field
     */
    const COL_DA_SALDARE = 'clienti.da_saldare';

    /**
     * the column name for the note field
     */
    const COL_NOTE = 'clienti.note';

    /**
     * the column name for the indirizzo field
     */
    const COL_INDIRIZZO = 'clienti.indirizzo';

    /**
     * the column name for the cap field
     */
    const COL_CAP = 'clienti.cap';

    /**
     * the column name for the citta field
     */
    const COL_CITTA = 'clienti.citta';

    /**
     * the column name for the provincia field
     */
    const COL_PROVINCIA = 'clienti.provincia';

    /**
     * the column name for the stato field
     */
    const COL_STATO = 'clienti.stato';

    /**
     * the column name for the codice_fiscale field
     */
    const COL_CODICE_FISCALE = 'clienti.codice_fiscale';

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
        self::TYPE_PHPNAME       => array('IdCliente', 'DaSaldare', 'Note', 'Indirizzo', 'Cap', 'Citta', 'Provincia', 'Stato', 'CodiceFiscale', ),
        self::TYPE_CAMELNAME     => array('idCliente', 'daSaldare', 'note', 'indirizzo', 'cap', 'citta', 'provincia', 'stato', 'codiceFiscale', ),
        self::TYPE_COLNAME       => array(ClientiTableMap::COL_ID_CLIENTE, ClientiTableMap::COL_DA_SALDARE, ClientiTableMap::COL_NOTE, ClientiTableMap::COL_INDIRIZZO, ClientiTableMap::COL_CAP, ClientiTableMap::COL_CITTA, ClientiTableMap::COL_PROVINCIA, ClientiTableMap::COL_STATO, ClientiTableMap::COL_CODICE_FISCALE, ),
        self::TYPE_FIELDNAME     => array('id_cliente', 'da_saldare', 'note', 'indirizzo', 'cap', 'citta', 'provincia', 'stato', 'codice_fiscale', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('IdCliente' => 0, 'DaSaldare' => 1, 'Note' => 2, 'Indirizzo' => 3, 'Cap' => 4, 'Citta' => 5, 'Provincia' => 6, 'Stato' => 7, 'CodiceFiscale' => 8, ),
        self::TYPE_CAMELNAME     => array('idCliente' => 0, 'daSaldare' => 1, 'note' => 2, 'indirizzo' => 3, 'cap' => 4, 'citta' => 5, 'provincia' => 6, 'stato' => 7, 'codiceFiscale' => 8, ),
        self::TYPE_COLNAME       => array(ClientiTableMap::COL_ID_CLIENTE => 0, ClientiTableMap::COL_DA_SALDARE => 1, ClientiTableMap::COL_NOTE => 2, ClientiTableMap::COL_INDIRIZZO => 3, ClientiTableMap::COL_CAP => 4, ClientiTableMap::COL_CITTA => 5, ClientiTableMap::COL_PROVINCIA => 6, ClientiTableMap::COL_STATO => 7, ClientiTableMap::COL_CODICE_FISCALE => 8, ),
        self::TYPE_FIELDNAME     => array('id_cliente' => 0, 'da_saldare' => 1, 'note' => 2, 'indirizzo' => 3, 'cap' => 4, 'citta' => 5, 'provincia' => 6, 'stato' => 7, 'codice_fiscale' => 8, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, )
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
        $this->setName('clienti');
        $this->setPhpName('Clienti');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\Clienti');
        $this->setPackage('');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id_cliente', 'IdCliente', 'INTEGER', true, null, null);
        $this->addColumn('da_saldare', 'DaSaldare', 'DECIMAL', false, 5, null);
        $this->addColumn('note', 'Note', 'VARCHAR', false, 100, null);
        $this->addColumn('indirizzo', 'Indirizzo', 'VARCHAR', false, 100, null);
        $this->addColumn('cap', 'Cap', 'VARCHAR', false, 10, null);
        $this->addColumn('citta', 'Citta', 'VARCHAR', false, 45, null);
        $this->addColumn('provincia', 'Provincia', 'VARCHAR', false, 45, null);
        $this->addColumn('stato', 'Stato', 'VARCHAR', false, 45, null);
        $this->addColumn('codice_fiscale', 'CodiceFiscale', 'VARCHAR', false, 16, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Account', '\\Account', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':id_cliente',
    1 => ':id_cliente',
  ),
), null, null, 'Accounts', false);
        $this->addRelation('AssegnamentiPostazione', '\\AssegnamentiPostazione', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':id_cliente',
    1 => ':id_cliente',
  ),
), null, null, 'AssegnamentiPostaziones', false);
        $this->addRelation('Pagamenti', '\\Pagamenti', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':id_cliente',
    1 => ':id_cliente',
  ),
), null, null, 'Pagamentis', false);
        $this->addRelation('Schede', '\\Schede', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':id_cliente',
    1 => ':id_cliente',
  ),
), null, null, 'Schedes', false);
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
        if ($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('IdCliente', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return null === $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('IdCliente', TableMap::TYPE_PHPNAME, $indexType)] || is_scalar($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('IdCliente', TableMap::TYPE_PHPNAME, $indexType)]) || is_callable([$row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('IdCliente', TableMap::TYPE_PHPNAME, $indexType)], '__toString']) ? (string) $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('IdCliente', TableMap::TYPE_PHPNAME, $indexType)] : $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('IdCliente', TableMap::TYPE_PHPNAME, $indexType)];
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
                : self::translateFieldName('IdCliente', TableMap::TYPE_PHPNAME, $indexType)
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
        return $withPrefix ? ClientiTableMap::CLASS_DEFAULT : ClientiTableMap::OM_CLASS;
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
     * @return array           (Clienti object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = ClientiTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = ClientiTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + ClientiTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = ClientiTableMap::OM_CLASS;
            /** @var Clienti $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            ClientiTableMap::addInstanceToPool($obj, $key);
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
            $key = ClientiTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = ClientiTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var Clienti $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                ClientiTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(ClientiTableMap::COL_ID_CLIENTE);
            $criteria->addSelectColumn(ClientiTableMap::COL_DA_SALDARE);
            $criteria->addSelectColumn(ClientiTableMap::COL_NOTE);
            $criteria->addSelectColumn(ClientiTableMap::COL_INDIRIZZO);
            $criteria->addSelectColumn(ClientiTableMap::COL_CAP);
            $criteria->addSelectColumn(ClientiTableMap::COL_CITTA);
            $criteria->addSelectColumn(ClientiTableMap::COL_PROVINCIA);
            $criteria->addSelectColumn(ClientiTableMap::COL_STATO);
            $criteria->addSelectColumn(ClientiTableMap::COL_CODICE_FISCALE);
        } else {
            $criteria->addSelectColumn($alias . '.id_cliente');
            $criteria->addSelectColumn($alias . '.da_saldare');
            $criteria->addSelectColumn($alias . '.note');
            $criteria->addSelectColumn($alias . '.indirizzo');
            $criteria->addSelectColumn($alias . '.cap');
            $criteria->addSelectColumn($alias . '.citta');
            $criteria->addSelectColumn($alias . '.provincia');
            $criteria->addSelectColumn($alias . '.stato');
            $criteria->addSelectColumn($alias . '.codice_fiscale');
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
        return Propel::getServiceContainer()->getDatabaseMap(ClientiTableMap::DATABASE_NAME)->getTable(ClientiTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(ClientiTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(ClientiTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new ClientiTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a Clienti or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or Clienti object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(ClientiTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \Clienti) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(ClientiTableMap::DATABASE_NAME);
            $criteria->add(ClientiTableMap::COL_ID_CLIENTE, (array) $values, Criteria::IN);
        }

        $query = ClientiQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            ClientiTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                ClientiTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the clienti table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return ClientiQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a Clienti or Criteria object.
     *
     * @param mixed               $criteria Criteria or Clienti object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(ClientiTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from Clienti object
        }

        if ($criteria->containsKey(ClientiTableMap::COL_ID_CLIENTE) && $criteria->keyContainsValue(ClientiTableMap::COL_ID_CLIENTE) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.ClientiTableMap::COL_ID_CLIENTE.')');
        }


        // Set the correct dbName
        $query = ClientiQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // ClientiTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
ClientiTableMap::buildTableMap();
