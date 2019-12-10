<?php

namespace Base;

use \Account as ChildAccount;
use \AccountQuery as ChildAccountQuery;
use \Privilegi as ChildPrivilegi;
use \PrivilegiProfilo as ChildPrivilegiProfilo;
use \PrivilegiProfiloQuery as ChildPrivilegiProfiloQuery;
use \PrivilegiQuery as ChildPrivilegiQuery;
use \Profili as ChildProfili;
use \ProfiliQuery as ChildProfiliQuery;
use \Exception;
use \PDO;
use Map\AccountTableMap;
use Map\PrivilegiProfiloTableMap;
use Map\ProfiliTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveRecord\ActiveRecordInterface;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\BadMethodCallException;
use Propel\Runtime\Exception\LogicException;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Parser\AbstractParser;

/**
 * Base class that represents a row from the 'profili' table.
 *
 *
 *
 * @package    propel.generator..Base
 */
abstract class Profili implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\Map\\ProfiliTableMap';


    /**
     * attribute to determine if this object has previously been saved.
     * @var boolean
     */
    protected $new = true;

    /**
     * attribute to determine whether this object has been deleted.
     * @var boolean
     */
    protected $deleted = false;

    /**
     * The columns that have been modified in current object.
     * Tracking modified columns allows us to only update modified columns.
     * @var array
     */
    protected $modifiedColumns = array();

    /**
     * The (virtual) columns that are added at runtime
     * The formatters can add supplementary columns based on a resultset
     * @var array
     */
    protected $virtualColumns = array();

    /**
     * The value for the id_profilo field.
     *
     * @var        int
     */
    protected $id_profilo;

    /**
     * The value for the descrizione field.
     *
     * @var        string
     */
    protected $descrizione;

    /**
     * @var        ObjectCollection|ChildAccount[] Collection to store aggregation of ChildAccount objects.
     */
    protected $collAccounts;
    protected $collAccountsPartial;

    /**
     * @var        ObjectCollection|ChildPrivilegiProfilo[] Collection to store aggregation of ChildPrivilegiProfilo objects.
     */
    protected $collPrivilegiProfilos;
    protected $collPrivilegiProfilosPartial;

    /**
     * @var        ObjectCollection|ChildPrivilegi[] Cross Collection to store aggregation of ChildPrivilegi objects.
     */
    protected $collPrivilegis;

    /**
     * @var bool
     */
    protected $collPrivilegisPartial;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildPrivilegi[]
     */
    protected $privilegisScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildAccount[]
     */
    protected $accountsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildPrivilegiProfilo[]
     */
    protected $privilegiProfilosScheduledForDeletion = null;

    /**
     * Initializes internal state of Base\Profili object.
     */
    public function __construct()
    {
    }

    /**
     * Returns whether the object has been modified.
     *
     * @return boolean True if the object has been modified.
     */
    public function isModified()
    {
        return !!$this->modifiedColumns;
    }

    /**
     * Has specified column been modified?
     *
     * @param  string  $col column fully qualified name (TableMap::TYPE_COLNAME), e.g. Book::AUTHOR_ID
     * @return boolean True if $col has been modified.
     */
    public function isColumnModified($col)
    {
        return $this->modifiedColumns && isset($this->modifiedColumns[$col]);
    }

    /**
     * Get the columns that have been modified in this object.
     * @return array A unique list of the modified column names for this object.
     */
    public function getModifiedColumns()
    {
        return $this->modifiedColumns ? array_keys($this->modifiedColumns) : [];
    }

    /**
     * Returns whether the object has ever been saved.  This will
     * be false, if the object was retrieved from storage or was created
     * and then saved.
     *
     * @return boolean true, if the object has never been persisted.
     */
    public function isNew()
    {
        return $this->new;
    }

    /**
     * Setter for the isNew attribute.  This method will be called
     * by Propel-generated children and objects.
     *
     * @param boolean $b the state of the object.
     */
    public function setNew($b)
    {
        $this->new = (boolean) $b;
    }

    /**
     * Whether this object has been deleted.
     * @return boolean The deleted state of this object.
     */
    public function isDeleted()
    {
        return $this->deleted;
    }

    /**
     * Specify whether this object has been deleted.
     * @param  boolean $b The deleted state of this object.
     * @return void
     */
    public function setDeleted($b)
    {
        $this->deleted = (boolean) $b;
    }

    /**
     * Sets the modified state for the object to be false.
     * @param  string $col If supplied, only the specified column is reset.
     * @return void
     */
    public function resetModified($col = null)
    {
        if (null !== $col) {
            if (isset($this->modifiedColumns[$col])) {
                unset($this->modifiedColumns[$col]);
            }
        } else {
            $this->modifiedColumns = array();
        }
    }

    /**
     * Compares this with another <code>Profili</code> instance.  If
     * <code>obj</code> is an instance of <code>Profili</code>, delegates to
     * <code>equals(Profili)</code>.  Otherwise, returns <code>false</code>.
     *
     * @param  mixed   $obj The object to compare to.
     * @return boolean Whether equal to the object specified.
     */
    public function equals($obj)
    {
        if (!$obj instanceof static) {
            return false;
        }

        if ($this === $obj) {
            return true;
        }

        if (null === $this->getPrimaryKey() || null === $obj->getPrimaryKey()) {
            return false;
        }

        return $this->getPrimaryKey() === $obj->getPrimaryKey();
    }

    /**
     * Get the associative array of the virtual columns in this object
     *
     * @return array
     */
    public function getVirtualColumns()
    {
        return $this->virtualColumns;
    }

    /**
     * Checks the existence of a virtual column in this object
     *
     * @param  string  $name The virtual column name
     * @return boolean
     */
    public function hasVirtualColumn($name)
    {
        return array_key_exists($name, $this->virtualColumns);
    }

    /**
     * Get the value of a virtual column in this object
     *
     * @param  string $name The virtual column name
     * @return mixed
     *
     * @throws PropelException
     */
    public function getVirtualColumn($name)
    {
        if (!$this->hasVirtualColumn($name)) {
            throw new PropelException(sprintf('Cannot get value of inexistent virtual column %s.', $name));
        }

        return $this->virtualColumns[$name];
    }

    /**
     * Set the value of a virtual column in this object
     *
     * @param string $name  The virtual column name
     * @param mixed  $value The value to give to the virtual column
     *
     * @return $this|Profili The current object, for fluid interface
     */
    public function setVirtualColumn($name, $value)
    {
        $this->virtualColumns[$name] = $value;

        return $this;
    }

    /**
     * Logs a message using Propel::log().
     *
     * @param  string  $msg
     * @param  int     $priority One of the Propel::LOG_* logging levels
     * @return boolean
     */
    protected function log($msg, $priority = Propel::LOG_INFO)
    {
        return Propel::log(get_class($this) . ': ' . $msg, $priority);
    }

    /**
     * Export the current object properties to a string, using a given parser format
     * <code>
     * $book = BookQuery::create()->findPk(9012);
     * echo $book->exportTo('JSON');
     *  => {"Id":9012,"Title":"Don Juan","ISBN":"0140422161","Price":12.99,"PublisherId":1234,"AuthorId":5678}');
     * </code>
     *
     * @param  mixed   $parser                 A AbstractParser instance, or a format name ('XML', 'YAML', 'JSON', 'CSV')
     * @param  boolean $includeLazyLoadColumns (optional) Whether to include lazy load(ed) columns. Defaults to TRUE.
     * @return string  The exported data
     */
    public function exportTo($parser, $includeLazyLoadColumns = true)
    {
        if (!$parser instanceof AbstractParser) {
            $parser = AbstractParser::getParser($parser);
        }

        return $parser->fromArray($this->toArray(TableMap::TYPE_PHPNAME, $includeLazyLoadColumns, array(), true));
    }

    /**
     * Clean up internal collections prior to serializing
     * Avoids recursive loops that turn into segmentation faults when serializing
     */
    public function __sleep()
    {
        $this->clearAllReferences();

        $cls = new \ReflectionClass($this);
        $propertyNames = [];
        $serializableProperties = array_diff($cls->getProperties(), $cls->getProperties(\ReflectionProperty::IS_STATIC));

        foreach($serializableProperties as $property) {
            $propertyNames[] = $property->getName();
        }

        return $propertyNames;
    }

    /**
     * Get the [id_profilo] column value.
     *
     * @return int
     */
    public function getIdProfilo()
    {
        return $this->id_profilo;
    }

    /**
     * Get the [descrizione] column value.
     *
     * @return string
     */
    public function getDescrizione()
    {
        return $this->descrizione;
    }

    /**
     * Set the value of [id_profilo] column.
     *
     * @param int $v new value
     * @return $this|\Profili The current object (for fluent API support)
     */
    public function setIdProfilo($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id_profilo !== $v) {
            $this->id_profilo = $v;
            $this->modifiedColumns[ProfiliTableMap::COL_ID_PROFILO] = true;
        }

        return $this;
    } // setIdProfilo()

    /**
     * Set the value of [descrizione] column.
     *
     * @param string $v new value
     * @return $this|\Profili The current object (for fluent API support)
     */
    public function setDescrizione($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->descrizione !== $v) {
            $this->descrizione = $v;
            $this->modifiedColumns[ProfiliTableMap::COL_DESCRIZIONE] = true;
        }

        return $this;
    } // setDescrizione()

    /**
     * Indicates whether the columns in this object are only set to default values.
     *
     * This method can be used in conjunction with isModified() to indicate whether an object is both
     * modified _and_ has some values set which are non-default.
     *
     * @return boolean Whether the columns in this object are only been set with default values.
     */
    public function hasOnlyDefaultValues()
    {
        // otherwise, everything was equal, so return TRUE
        return true;
    } // hasOnlyDefaultValues()

    /**
     * Hydrates (populates) the object variables with values from the database resultset.
     *
     * An offset (0-based "start column") is specified so that objects can be hydrated
     * with a subset of the columns in the resultset rows.  This is needed, for example,
     * for results of JOIN queries where the resultset row includes columns from two or
     * more tables.
     *
     * @param array   $row       The row returned by DataFetcher->fetch().
     * @param int     $startcol  0-based offset column which indicates which restultset column to start with.
     * @param boolean $rehydrate Whether this object is being re-hydrated from the database.
     * @param string  $indexType The index type of $row. Mostly DataFetcher->getIndexType().
                                  One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                            TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *
     * @return int             next starting column
     * @throws PropelException - Any caught Exception will be rewrapped as a PropelException.
     */
    public function hydrate($row, $startcol = 0, $rehydrate = false, $indexType = TableMap::TYPE_NUM)
    {
        try {

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : ProfiliTableMap::translateFieldName('IdProfilo', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id_profilo = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : ProfiliTableMap::translateFieldName('Descrizione', TableMap::TYPE_PHPNAME, $indexType)];
            $this->descrizione = (null !== $col) ? (string) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 2; // 2 = ProfiliTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\Profili'), 0, $e);
        }
    }

    /**
     * Checks and repairs the internal consistency of the object.
     *
     * This method is executed after an already-instantiated object is re-hydrated
     * from the database.  It exists to check any foreign keys to make sure that
     * the objects related to the current object are correct based on foreign key.
     *
     * You can override this method in the stub class, but you should always invoke
     * the base method from the overridden method (i.e. parent::ensureConsistency()),
     * in case your model changes.
     *
     * @throws PropelException
     */
    public function ensureConsistency()
    {
    } // ensureConsistency

    /**
     * Reloads this object from datastore based on primary key and (optionally) resets all associated objects.
     *
     * This will only work if the object has been saved and has a valid primary key set.
     *
     * @param      boolean $deep (optional) Whether to also de-associated any related objects.
     * @param      ConnectionInterface $con (optional) The ConnectionInterface connection to use.
     * @return void
     * @throws PropelException - if this object is deleted, unsaved or doesn't have pk match in db
     */
    public function reload($deep = false, ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("Cannot reload a deleted object.");
        }

        if ($this->isNew()) {
            throw new PropelException("Cannot reload an unsaved object.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(ProfiliTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildProfiliQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->collAccounts = null;

            $this->collPrivilegiProfilos = null;

            $this->collPrivilegis = null;
        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see Profili::setDeleted()
     * @see Profili::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(ProfiliTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildProfiliQuery::create()
                ->filterByPrimaryKey($this->getPrimaryKey());
            $ret = $this->preDelete($con);
            if ($ret) {
                $deleteQuery->delete($con);
                $this->postDelete($con);
                $this->setDeleted(true);
            }
        });
    }

    /**
     * Persists this object to the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All modified related objects will also be persisted in the doSave()
     * method.  This method wraps all precipitate database operations in a
     * single transaction.
     *
     * @param      ConnectionInterface $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @see doSave()
     */
    public function save(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("You cannot save an object that has been deleted.");
        }

        if ($this->alreadyInSave) {
            return 0;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(ProfiliTableMap::DATABASE_NAME);
        }

        return $con->transaction(function () use ($con) {
            $ret = $this->preSave($con);
            $isInsert = $this->isNew();
            if ($isInsert) {
                $ret = $ret && $this->preInsert($con);
            } else {
                $ret = $ret && $this->preUpdate($con);
            }
            if ($ret) {
                $affectedRows = $this->doSave($con);
                if ($isInsert) {
                    $this->postInsert($con);
                } else {
                    $this->postUpdate($con);
                }
                $this->postSave($con);
                ProfiliTableMap::addInstanceToPool($this);
            } else {
                $affectedRows = 0;
            }

            return $affectedRows;
        });
    }

    /**
     * Performs the work of inserting or updating the row in the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All related objects are also updated in this method.
     *
     * @param      ConnectionInterface $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @see save()
     */
    protected function doSave(ConnectionInterface $con)
    {
        $affectedRows = 0; // initialize var to track total num of affected rows
        if (!$this->alreadyInSave) {
            $this->alreadyInSave = true;

            if ($this->isNew() || $this->isModified()) {
                // persist changes
                if ($this->isNew()) {
                    $this->doInsert($con);
                    $affectedRows += 1;
                } else {
                    $affectedRows += $this->doUpdate($con);
                }
                $this->resetModified();
            }

            if ($this->privilegisScheduledForDeletion !== null) {
                if (!$this->privilegisScheduledForDeletion->isEmpty()) {
                    $pks = array();
                    foreach ($this->privilegisScheduledForDeletion as $entry) {
                        $entryPk = [];

                        $entryPk[1] = $this->getIdProfilo();
                        $entryPk[0] = $entry->getIdPrivilegio();
                        $pks[] = $entryPk;
                    }

                    \PrivilegiProfiloQuery::create()
                        ->filterByPrimaryKeys($pks)
                        ->delete($con);

                    $this->privilegisScheduledForDeletion = null;
                }

            }

            if ($this->collPrivilegis) {
                foreach ($this->collPrivilegis as $privilegi) {
                    if (!$privilegi->isDeleted() && ($privilegi->isNew() || $privilegi->isModified())) {
                        $privilegi->save($con);
                    }
                }
            }


            if ($this->accountsScheduledForDeletion !== null) {
                if (!$this->accountsScheduledForDeletion->isEmpty()) {
                    \AccountQuery::create()
                        ->filterByPrimaryKeys($this->accountsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->accountsScheduledForDeletion = null;
                }
            }

            if ($this->collAccounts !== null) {
                foreach ($this->collAccounts as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->privilegiProfilosScheduledForDeletion !== null) {
                if (!$this->privilegiProfilosScheduledForDeletion->isEmpty()) {
                    \PrivilegiProfiloQuery::create()
                        ->filterByPrimaryKeys($this->privilegiProfilosScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->privilegiProfilosScheduledForDeletion = null;
                }
            }

            if ($this->collPrivilegiProfilos !== null) {
                foreach ($this->collPrivilegiProfilos as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            $this->alreadyInSave = false;

        }

        return $affectedRows;
    } // doSave()

    /**
     * Insert the row in the database.
     *
     * @param      ConnectionInterface $con
     *
     * @throws PropelException
     * @see doSave()
     */
    protected function doInsert(ConnectionInterface $con)
    {
        $modifiedColumns = array();
        $index = 0;

        $this->modifiedColumns[ProfiliTableMap::COL_ID_PROFILO] = true;
        if (null !== $this->id_profilo) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . ProfiliTableMap::COL_ID_PROFILO . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(ProfiliTableMap::COL_ID_PROFILO)) {
            $modifiedColumns[':p' . $index++]  = 'id_profilo';
        }
        if ($this->isColumnModified(ProfiliTableMap::COL_DESCRIZIONE)) {
            $modifiedColumns[':p' . $index++]  = 'descrizione';
        }

        $sql = sprintf(
            'INSERT INTO profili (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case 'id_profilo':
                        $stmt->bindValue($identifier, $this->id_profilo, PDO::PARAM_INT);
                        break;
                    case 'descrizione':
                        $stmt->bindValue($identifier, $this->descrizione, PDO::PARAM_STR);
                        break;
                }
            }
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute INSERT statement [%s]', $sql), 0, $e);
        }

        try {
            $pk = $con->lastInsertId();
        } catch (Exception $e) {
            throw new PropelException('Unable to get autoincrement id.', 0, $e);
        }
        $this->setIdProfilo($pk);

        $this->setNew(false);
    }

    /**
     * Update the row in the database.
     *
     * @param      ConnectionInterface $con
     *
     * @return Integer Number of updated rows
     * @see doSave()
     */
    protected function doUpdate(ConnectionInterface $con)
    {
        $selectCriteria = $this->buildPkeyCriteria();
        $valuesCriteria = $this->buildCriteria();

        return $selectCriteria->doUpdate($valuesCriteria, $con);
    }

    /**
     * Retrieves a field from the object by name passed in as a string.
     *
     * @param      string $name name
     * @param      string $type The type of fieldname the $name is of:
     *                     one of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                     TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                     Defaults to TableMap::TYPE_PHPNAME.
     * @return mixed Value of field.
     */
    public function getByName($name, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = ProfiliTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
        $field = $this->getByPosition($pos);

        return $field;
    }

    /**
     * Retrieves a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param      int $pos position in xml schema
     * @return mixed Value of field at $pos
     */
    public function getByPosition($pos)
    {
        switch ($pos) {
            case 0:
                return $this->getIdProfilo();
                break;
            case 1:
                return $this->getDescrizione();
                break;
            default:
                return null;
                break;
        } // switch()
    }

    /**
     * Exports the object as an array.
     *
     * You can specify the key type of the array by passing one of the class
     * type constants.
     *
     * @param     string  $keyType (optional) One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     *                    TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                    Defaults to TableMap::TYPE_PHPNAME.
     * @param     boolean $includeLazyLoadColumns (optional) Whether to include lazy loaded columns. Defaults to TRUE.
     * @param     array $alreadyDumpedObjects List of objects to skip to avoid recursion
     * @param     boolean $includeForeignObjects (optional) Whether to include hydrated related objects. Default to FALSE.
     *
     * @return array an associative array containing the field names (as keys) and field values
     */
    public function toArray($keyType = TableMap::TYPE_PHPNAME, $includeLazyLoadColumns = true, $alreadyDumpedObjects = array(), $includeForeignObjects = false)
    {

        if (isset($alreadyDumpedObjects['Profili'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Profili'][$this->hashCode()] = true;
        $keys = ProfiliTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getIdProfilo(),
            $keys[1] => $this->getDescrizione(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->collAccounts) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'accounts';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'accounts';
                        break;
                    default:
                        $key = 'Accounts';
                }

                $result[$key] = $this->collAccounts->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collPrivilegiProfilos) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'privilegiProfilos';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'privilegi_profilos';
                        break;
                    default:
                        $key = 'PrivilegiProfilos';
                }

                $result[$key] = $this->collPrivilegiProfilos->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
        }

        return $result;
    }

    /**
     * Sets a field from the object by name passed in as a string.
     *
     * @param  string $name
     * @param  mixed  $value field value
     * @param  string $type The type of fieldname the $name is of:
     *                one of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                Defaults to TableMap::TYPE_PHPNAME.
     * @return $this|\Profili
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = ProfiliTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\Profili
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setIdProfilo($value);
                break;
            case 1:
                $this->setDescrizione($value);
                break;
        } // switch()

        return $this;
    }

    /**
     * Populates the object using an array.
     *
     * This is particularly useful when populating an object from one of the
     * request arrays (e.g. $_POST).  This method goes through the column
     * names, checking to see whether a matching key exists in populated
     * array. If so the setByName() method is called for that column.
     *
     * You can specify the key type of the array by additionally passing one
     * of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     * TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     * The default key type is the column's TableMap::TYPE_PHPNAME.
     *
     * @param      array  $arr     An array to populate the object from.
     * @param      string $keyType The type of keys the array uses.
     * @return void
     */
    public function fromArray($arr, $keyType = TableMap::TYPE_PHPNAME)
    {
        $keys = ProfiliTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setIdProfilo($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setDescrizione($arr[$keys[1]]);
        }
    }

     /**
     * Populate the current object from a string, using a given parser format
     * <code>
     * $book = new Book();
     * $book->importFrom('JSON', '{"Id":9012,"Title":"Don Juan","ISBN":"0140422161","Price":12.99,"PublisherId":1234,"AuthorId":5678}');
     * </code>
     *
     * You can specify the key type of the array by additionally passing one
     * of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     * TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     * The default key type is the column's TableMap::TYPE_PHPNAME.
     *
     * @param mixed $parser A AbstractParser instance,
     *                       or a format name ('XML', 'YAML', 'JSON', 'CSV')
     * @param string $data The source data to import from
     * @param string $keyType The type of keys the array uses.
     *
     * @return $this|\Profili The current object, for fluid interface
     */
    public function importFrom($parser, $data, $keyType = TableMap::TYPE_PHPNAME)
    {
        if (!$parser instanceof AbstractParser) {
            $parser = AbstractParser::getParser($parser);
        }

        $this->fromArray($parser->toArray($data), $keyType);

        return $this;
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria()
    {
        $criteria = new Criteria(ProfiliTableMap::DATABASE_NAME);

        if ($this->isColumnModified(ProfiliTableMap::COL_ID_PROFILO)) {
            $criteria->add(ProfiliTableMap::COL_ID_PROFILO, $this->id_profilo);
        }
        if ($this->isColumnModified(ProfiliTableMap::COL_DESCRIZIONE)) {
            $criteria->add(ProfiliTableMap::COL_DESCRIZIONE, $this->descrizione);
        }

        return $criteria;
    }

    /**
     * Builds a Criteria object containing the primary key for this object.
     *
     * Unlike buildCriteria() this method includes the primary key values regardless
     * of whether or not they have been modified.
     *
     * @throws LogicException if no primary key is defined
     *
     * @return Criteria The Criteria object containing value(s) for primary key(s).
     */
    public function buildPkeyCriteria()
    {
        $criteria = ChildProfiliQuery::create();
        $criteria->add(ProfiliTableMap::COL_ID_PROFILO, $this->id_profilo);

        return $criteria;
    }

    /**
     * If the primary key is not null, return the hashcode of the
     * primary key. Otherwise, return the hash code of the object.
     *
     * @return int Hashcode
     */
    public function hashCode()
    {
        $validPk = null !== $this->getIdProfilo();

        $validPrimaryKeyFKs = 0;
        $primaryKeyFKs = [];

        if ($validPk) {
            return crc32(json_encode($this->getPrimaryKey(), JSON_UNESCAPED_UNICODE));
        } elseif ($validPrimaryKeyFKs) {
            return crc32(json_encode($primaryKeyFKs, JSON_UNESCAPED_UNICODE));
        }

        return spl_object_hash($this);
    }

    /**
     * Returns the primary key for this object (row).
     * @return int
     */
    public function getPrimaryKey()
    {
        return $this->getIdProfilo();
    }

    /**
     * Generic method to set the primary key (id_profilo column).
     *
     * @param       int $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setIdProfilo($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {
        return null === $this->getIdProfilo();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param      object $copyObj An object of \Profili (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setDescrizione($this->getDescrizione());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getAccounts() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addAccount($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getPrivilegiProfilos() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addPrivilegiProfilo($relObj->copy($deepCopy));
                }
            }

        } // if ($deepCopy)

        if ($makeNew) {
            $copyObj->setNew(true);
            $copyObj->setIdProfilo(NULL); // this is a auto-increment column, so set to default value
        }
    }

    /**
     * Makes a copy of this object that will be inserted as a new row in table when saved.
     * It creates a new object filling in the simple attributes, but skipping any primary
     * keys that are defined for the table.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param  boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @return \Profili Clone of current object.
     * @throws PropelException
     */
    public function copy($deepCopy = false)
    {
        // we use get_class(), because this might be a subclass
        $clazz = get_class($this);
        $copyObj = new $clazz();
        $this->copyInto($copyObj, $deepCopy);

        return $copyObj;
    }


    /**
     * Initializes a collection based on the name of a relation.
     * Avoids crafting an 'init[$relationName]s' method name
     * that wouldn't work when StandardEnglishPluralizer is used.
     *
     * @param      string $relationName The name of the relation to initialize
     * @return void
     */
    public function initRelation($relationName)
    {
        if ('Account' == $relationName) {
            return $this->initAccounts();
        }
        if ('PrivilegiProfilo' == $relationName) {
            return $this->initPrivilegiProfilos();
        }
    }

    /**
     * Clears out the collAccounts collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addAccounts()
     */
    public function clearAccounts()
    {
        $this->collAccounts = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collAccounts collection loaded partially.
     */
    public function resetPartialAccounts($v = true)
    {
        $this->collAccountsPartial = $v;
    }

    /**
     * Initializes the collAccounts collection.
     *
     * By default this just sets the collAccounts collection to an empty array (like clearcollAccounts());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initAccounts($overrideExisting = true)
    {
        if (null !== $this->collAccounts && !$overrideExisting) {
            return;
        }

        $collectionClassName = AccountTableMap::getTableMap()->getCollectionClassName();

        $this->collAccounts = new $collectionClassName;
        $this->collAccounts->setModel('\Account');
    }

    /**
     * Gets an array of ChildAccount objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildProfili is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildAccount[] List of ChildAccount objects
     * @throws PropelException
     */
    public function getAccounts(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collAccountsPartial && !$this->isNew();
        if (null === $this->collAccounts || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collAccounts) {
                // return empty collection
                $this->initAccounts();
            } else {
                $collAccounts = ChildAccountQuery::create(null, $criteria)
                    ->filterByProfili($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collAccountsPartial && count($collAccounts)) {
                        $this->initAccounts(false);

                        foreach ($collAccounts as $obj) {
                            if (false == $this->collAccounts->contains($obj)) {
                                $this->collAccounts->append($obj);
                            }
                        }

                        $this->collAccountsPartial = true;
                    }

                    return $collAccounts;
                }

                if ($partial && $this->collAccounts) {
                    foreach ($this->collAccounts as $obj) {
                        if ($obj->isNew()) {
                            $collAccounts[] = $obj;
                        }
                    }
                }

                $this->collAccounts = $collAccounts;
                $this->collAccountsPartial = false;
            }
        }

        return $this->collAccounts;
    }

    /**
     * Sets a collection of ChildAccount objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $accounts A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildProfili The current object (for fluent API support)
     */
    public function setAccounts(Collection $accounts, ConnectionInterface $con = null)
    {
        /** @var ChildAccount[] $accountsToDelete */
        $accountsToDelete = $this->getAccounts(new Criteria(), $con)->diff($accounts);


        $this->accountsScheduledForDeletion = $accountsToDelete;

        foreach ($accountsToDelete as $accountRemoved) {
            $accountRemoved->setProfili(null);
        }

        $this->collAccounts = null;
        foreach ($accounts as $account) {
            $this->addAccount($account);
        }

        $this->collAccounts = $accounts;
        $this->collAccountsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Account objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Account objects.
     * @throws PropelException
     */
    public function countAccounts(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collAccountsPartial && !$this->isNew();
        if (null === $this->collAccounts || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collAccounts) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getAccounts());
            }

            $query = ChildAccountQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByProfili($this)
                ->count($con);
        }

        return count($this->collAccounts);
    }

    /**
     * Method called to associate a ChildAccount object to this object
     * through the ChildAccount foreign key attribute.
     *
     * @param  ChildAccount $l ChildAccount
     * @return $this|\Profili The current object (for fluent API support)
     */
    public function addAccount(ChildAccount $l)
    {
        if ($this->collAccounts === null) {
            $this->initAccounts();
            $this->collAccountsPartial = true;
        }

        if (!$this->collAccounts->contains($l)) {
            $this->doAddAccount($l);

            if ($this->accountsScheduledForDeletion and $this->accountsScheduledForDeletion->contains($l)) {
                $this->accountsScheduledForDeletion->remove($this->accountsScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildAccount $account The ChildAccount object to add.
     */
    protected function doAddAccount(ChildAccount $account)
    {
        $this->collAccounts[]= $account;
        $account->setProfili($this);
    }

    /**
     * @param  ChildAccount $account The ChildAccount object to remove.
     * @return $this|ChildProfili The current object (for fluent API support)
     */
    public function removeAccount(ChildAccount $account)
    {
        if ($this->getAccounts()->contains($account)) {
            $pos = $this->collAccounts->search($account);
            $this->collAccounts->remove($pos);
            if (null === $this->accountsScheduledForDeletion) {
                $this->accountsScheduledForDeletion = clone $this->collAccounts;
                $this->accountsScheduledForDeletion->clear();
            }
            $this->accountsScheduledForDeletion[]= clone $account;
            $account->setProfili(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Profili is new, it will return
     * an empty collection; or if this Profili has previously
     * been saved, it will retrieve related Accounts from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Profili.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildAccount[] List of ChildAccount objects
     */
    public function getAccountsJoinClienti(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildAccountQuery::create(null, $criteria);
        $query->joinWith('Clienti', $joinBehavior);

        return $this->getAccounts($query, $con);
    }

    /**
     * Clears out the collPrivilegiProfilos collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addPrivilegiProfilos()
     */
    public function clearPrivilegiProfilos()
    {
        $this->collPrivilegiProfilos = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collPrivilegiProfilos collection loaded partially.
     */
    public function resetPartialPrivilegiProfilos($v = true)
    {
        $this->collPrivilegiProfilosPartial = $v;
    }

    /**
     * Initializes the collPrivilegiProfilos collection.
     *
     * By default this just sets the collPrivilegiProfilos collection to an empty array (like clearcollPrivilegiProfilos());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initPrivilegiProfilos($overrideExisting = true)
    {
        if (null !== $this->collPrivilegiProfilos && !$overrideExisting) {
            return;
        }

        $collectionClassName = PrivilegiProfiloTableMap::getTableMap()->getCollectionClassName();

        $this->collPrivilegiProfilos = new $collectionClassName;
        $this->collPrivilegiProfilos->setModel('\PrivilegiProfilo');
    }

    /**
     * Gets an array of ChildPrivilegiProfilo objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildProfili is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildPrivilegiProfilo[] List of ChildPrivilegiProfilo objects
     * @throws PropelException
     */
    public function getPrivilegiProfilos(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collPrivilegiProfilosPartial && !$this->isNew();
        if (null === $this->collPrivilegiProfilos || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collPrivilegiProfilos) {
                // return empty collection
                $this->initPrivilegiProfilos();
            } else {
                $collPrivilegiProfilos = ChildPrivilegiProfiloQuery::create(null, $criteria)
                    ->filterByProfili($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collPrivilegiProfilosPartial && count($collPrivilegiProfilos)) {
                        $this->initPrivilegiProfilos(false);

                        foreach ($collPrivilegiProfilos as $obj) {
                            if (false == $this->collPrivilegiProfilos->contains($obj)) {
                                $this->collPrivilegiProfilos->append($obj);
                            }
                        }

                        $this->collPrivilegiProfilosPartial = true;
                    }

                    return $collPrivilegiProfilos;
                }

                if ($partial && $this->collPrivilegiProfilos) {
                    foreach ($this->collPrivilegiProfilos as $obj) {
                        if ($obj->isNew()) {
                            $collPrivilegiProfilos[] = $obj;
                        }
                    }
                }

                $this->collPrivilegiProfilos = $collPrivilegiProfilos;
                $this->collPrivilegiProfilosPartial = false;
            }
        }

        return $this->collPrivilegiProfilos;
    }

    /**
     * Sets a collection of ChildPrivilegiProfilo objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $privilegiProfilos A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildProfili The current object (for fluent API support)
     */
    public function setPrivilegiProfilos(Collection $privilegiProfilos, ConnectionInterface $con = null)
    {
        /** @var ChildPrivilegiProfilo[] $privilegiProfilosToDelete */
        $privilegiProfilosToDelete = $this->getPrivilegiProfilos(new Criteria(), $con)->diff($privilegiProfilos);


        //since at least one column in the foreign key is at the same time a PK
        //we can not just set a PK to NULL in the lines below. We have to store
        //a backup of all values, so we are able to manipulate these items based on the onDelete value later.
        $this->privilegiProfilosScheduledForDeletion = clone $privilegiProfilosToDelete;

        foreach ($privilegiProfilosToDelete as $privilegiProfiloRemoved) {
            $privilegiProfiloRemoved->setProfili(null);
        }

        $this->collPrivilegiProfilos = null;
        foreach ($privilegiProfilos as $privilegiProfilo) {
            $this->addPrivilegiProfilo($privilegiProfilo);
        }

        $this->collPrivilegiProfilos = $privilegiProfilos;
        $this->collPrivilegiProfilosPartial = false;

        return $this;
    }

    /**
     * Returns the number of related PrivilegiProfilo objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related PrivilegiProfilo objects.
     * @throws PropelException
     */
    public function countPrivilegiProfilos(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collPrivilegiProfilosPartial && !$this->isNew();
        if (null === $this->collPrivilegiProfilos || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collPrivilegiProfilos) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getPrivilegiProfilos());
            }

            $query = ChildPrivilegiProfiloQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByProfili($this)
                ->count($con);
        }

        return count($this->collPrivilegiProfilos);
    }

    /**
     * Method called to associate a ChildPrivilegiProfilo object to this object
     * through the ChildPrivilegiProfilo foreign key attribute.
     *
     * @param  ChildPrivilegiProfilo $l ChildPrivilegiProfilo
     * @return $this|\Profili The current object (for fluent API support)
     */
    public function addPrivilegiProfilo(ChildPrivilegiProfilo $l)
    {
        if ($this->collPrivilegiProfilos === null) {
            $this->initPrivilegiProfilos();
            $this->collPrivilegiProfilosPartial = true;
        }

        if (!$this->collPrivilegiProfilos->contains($l)) {
            $this->doAddPrivilegiProfilo($l);

            if ($this->privilegiProfilosScheduledForDeletion and $this->privilegiProfilosScheduledForDeletion->contains($l)) {
                $this->privilegiProfilosScheduledForDeletion->remove($this->privilegiProfilosScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildPrivilegiProfilo $privilegiProfilo The ChildPrivilegiProfilo object to add.
     */
    protected function doAddPrivilegiProfilo(ChildPrivilegiProfilo $privilegiProfilo)
    {
        $this->collPrivilegiProfilos[]= $privilegiProfilo;
        $privilegiProfilo->setProfili($this);
    }

    /**
     * @param  ChildPrivilegiProfilo $privilegiProfilo The ChildPrivilegiProfilo object to remove.
     * @return $this|ChildProfili The current object (for fluent API support)
     */
    public function removePrivilegiProfilo(ChildPrivilegiProfilo $privilegiProfilo)
    {
        if ($this->getPrivilegiProfilos()->contains($privilegiProfilo)) {
            $pos = $this->collPrivilegiProfilos->search($privilegiProfilo);
            $this->collPrivilegiProfilos->remove($pos);
            if (null === $this->privilegiProfilosScheduledForDeletion) {
                $this->privilegiProfilosScheduledForDeletion = clone $this->collPrivilegiProfilos;
                $this->privilegiProfilosScheduledForDeletion->clear();
            }
            $this->privilegiProfilosScheduledForDeletion[]= clone $privilegiProfilo;
            $privilegiProfilo->setProfili(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Profili is new, it will return
     * an empty collection; or if this Profili has previously
     * been saved, it will retrieve related PrivilegiProfilos from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Profili.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildPrivilegiProfilo[] List of ChildPrivilegiProfilo objects
     */
    public function getPrivilegiProfilosJoinPrivilegi(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildPrivilegiProfiloQuery::create(null, $criteria);
        $query->joinWith('Privilegi', $joinBehavior);

        return $this->getPrivilegiProfilos($query, $con);
    }

    /**
     * Clears out the collPrivilegis collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addPrivilegis()
     */
    public function clearPrivilegis()
    {
        $this->collPrivilegis = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Initializes the collPrivilegis crossRef collection.
     *
     * By default this just sets the collPrivilegis collection to an empty collection (like clearPrivilegis());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @return void
     */
    public function initPrivilegis()
    {
        $collectionClassName = PrivilegiProfiloTableMap::getTableMap()->getCollectionClassName();

        $this->collPrivilegis = new $collectionClassName;
        $this->collPrivilegisPartial = true;
        $this->collPrivilegis->setModel('\Privilegi');
    }

    /**
     * Checks if the collPrivilegis collection is loaded.
     *
     * @return bool
     */
    public function isPrivilegisLoaded()
    {
        return null !== $this->collPrivilegis;
    }

    /**
     * Gets a collection of ChildPrivilegi objects related by a many-to-many relationship
     * to the current object by way of the privilegi_profilo cross-reference table.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildProfili is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria Optional query object to filter the query
     * @param      ConnectionInterface $con Optional connection object
     *
     * @return ObjectCollection|ChildPrivilegi[] List of ChildPrivilegi objects
     */
    public function getPrivilegis(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collPrivilegisPartial && !$this->isNew();
        if (null === $this->collPrivilegis || null !== $criteria || $partial) {
            if ($this->isNew()) {
                // return empty collection
                if (null === $this->collPrivilegis) {
                    $this->initPrivilegis();
                }
            } else {

                $query = ChildPrivilegiQuery::create(null, $criteria)
                    ->filterByProfili($this);
                $collPrivilegis = $query->find($con);
                if (null !== $criteria) {
                    return $collPrivilegis;
                }

                if ($partial && $this->collPrivilegis) {
                    //make sure that already added objects gets added to the list of the database.
                    foreach ($this->collPrivilegis as $obj) {
                        if (!$collPrivilegis->contains($obj)) {
                            $collPrivilegis[] = $obj;
                        }
                    }
                }

                $this->collPrivilegis = $collPrivilegis;
                $this->collPrivilegisPartial = false;
            }
        }

        return $this->collPrivilegis;
    }

    /**
     * Sets a collection of Privilegi objects related by a many-to-many relationship
     * to the current object by way of the privilegi_profilo cross-reference table.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param  Collection $privilegis A Propel collection.
     * @param  ConnectionInterface $con Optional connection object
     * @return $this|ChildProfili The current object (for fluent API support)
     */
    public function setPrivilegis(Collection $privilegis, ConnectionInterface $con = null)
    {
        $this->clearPrivilegis();
        $currentPrivilegis = $this->getPrivilegis();

        $privilegisScheduledForDeletion = $currentPrivilegis->diff($privilegis);

        foreach ($privilegisScheduledForDeletion as $toDelete) {
            $this->removePrivilegi($toDelete);
        }

        foreach ($privilegis as $privilegi) {
            if (!$currentPrivilegis->contains($privilegi)) {
                $this->doAddPrivilegi($privilegi);
            }
        }

        $this->collPrivilegisPartial = false;
        $this->collPrivilegis = $privilegis;

        return $this;
    }

    /**
     * Gets the number of Privilegi objects related by a many-to-many relationship
     * to the current object by way of the privilegi_profilo cross-reference table.
     *
     * @param      Criteria $criteria Optional query object to filter the query
     * @param      boolean $distinct Set to true to force count distinct
     * @param      ConnectionInterface $con Optional connection object
     *
     * @return int the number of related Privilegi objects
     */
    public function countPrivilegis(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collPrivilegisPartial && !$this->isNew();
        if (null === $this->collPrivilegis || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collPrivilegis) {
                return 0;
            } else {

                if ($partial && !$criteria) {
                    return count($this->getPrivilegis());
                }

                $query = ChildPrivilegiQuery::create(null, $criteria);
                if ($distinct) {
                    $query->distinct();
                }

                return $query
                    ->filterByProfili($this)
                    ->count($con);
            }
        } else {
            return count($this->collPrivilegis);
        }
    }

    /**
     * Associate a ChildPrivilegi to this object
     * through the privilegi_profilo cross reference table.
     *
     * @param ChildPrivilegi $privilegi
     * @return ChildProfili The current object (for fluent API support)
     */
    public function addPrivilegi(ChildPrivilegi $privilegi)
    {
        if ($this->collPrivilegis === null) {
            $this->initPrivilegis();
        }

        if (!$this->getPrivilegis()->contains($privilegi)) {
            // only add it if the **same** object is not already associated
            $this->collPrivilegis->push($privilegi);
            $this->doAddPrivilegi($privilegi);
        }

        return $this;
    }

    /**
     *
     * @param ChildPrivilegi $privilegi
     */
    protected function doAddPrivilegi(ChildPrivilegi $privilegi)
    {
        $privilegiProfilo = new ChildPrivilegiProfilo();

        $privilegiProfilo->setPrivilegi($privilegi);

        $privilegiProfilo->setProfili($this);

        $this->addPrivilegiProfilo($privilegiProfilo);

        // set the back reference to this object directly as using provided method either results
        // in endless loop or in multiple relations
        if (!$privilegi->isProfilisLoaded()) {
            $privilegi->initProfilis();
            $privilegi->getProfilis()->push($this);
        } elseif (!$privilegi->getProfilis()->contains($this)) {
            $privilegi->getProfilis()->push($this);
        }

    }

    /**
     * Remove privilegi of this object
     * through the privilegi_profilo cross reference table.
     *
     * @param ChildPrivilegi $privilegi
     * @return ChildProfili The current object (for fluent API support)
     */
    public function removePrivilegi(ChildPrivilegi $privilegi)
    {
        if ($this->getPrivilegis()->contains($privilegi)) {
            $privilegiProfilo = new ChildPrivilegiProfilo();
            $privilegiProfilo->setPrivilegi($privilegi);
            if ($privilegi->isProfilisLoaded()) {
                //remove the back reference if available
                $privilegi->getProfilis()->removeObject($this);
            }

            $privilegiProfilo->setProfili($this);
            $this->removePrivilegiProfilo(clone $privilegiProfilo);
            $privilegiProfilo->clear();

            $this->collPrivilegis->remove($this->collPrivilegis->search($privilegi));

            if (null === $this->privilegisScheduledForDeletion) {
                $this->privilegisScheduledForDeletion = clone $this->collPrivilegis;
                $this->privilegisScheduledForDeletion->clear();
            }

            $this->privilegisScheduledForDeletion->push($privilegi);
        }


        return $this;
    }

    /**
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear()
    {
        $this->id_profilo = null;
        $this->descrizione = null;
        $this->alreadyInSave = false;
        $this->clearAllReferences();
        $this->resetModified();
        $this->setNew(true);
        $this->setDeleted(false);
    }

    /**
     * Resets all references and back-references to other model objects or collections of model objects.
     *
     * This method is used to reset all php object references (not the actual reference in the database).
     * Necessary for object serialisation.
     *
     * @param      boolean $deep Whether to also clear the references on all referrer objects.
     */
    public function clearAllReferences($deep = false)
    {
        if ($deep) {
            if ($this->collAccounts) {
                foreach ($this->collAccounts as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collPrivilegiProfilos) {
                foreach ($this->collPrivilegiProfilos as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collPrivilegis) {
                foreach ($this->collPrivilegis as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collAccounts = null;
        $this->collPrivilegiProfilos = null;
        $this->collPrivilegis = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(ProfiliTableMap::DEFAULT_STRING_FORMAT);
    }

    /**
     * Code to be run before persisting the object
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preSave(ConnectionInterface $con = null)
    {
        if (is_callable('parent::preSave')) {
            return parent::preSave($con);
        }
        return true;
    }

    /**
     * Code to be run after persisting the object
     * @param ConnectionInterface $con
     */
    public function postSave(ConnectionInterface $con = null)
    {
        if (is_callable('parent::postSave')) {
            parent::postSave($con);
        }
    }

    /**
     * Code to be run before inserting to database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preInsert(ConnectionInterface $con = null)
    {
        if (is_callable('parent::preInsert')) {
            return parent::preInsert($con);
        }
        return true;
    }

    /**
     * Code to be run after inserting to database
     * @param ConnectionInterface $con
     */
    public function postInsert(ConnectionInterface $con = null)
    {
        if (is_callable('parent::postInsert')) {
            parent::postInsert($con);
        }
    }

    /**
     * Code to be run before updating the object in database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preUpdate(ConnectionInterface $con = null)
    {
        if (is_callable('parent::preUpdate')) {
            return parent::preUpdate($con);
        }
        return true;
    }

    /**
     * Code to be run after updating the object in database
     * @param ConnectionInterface $con
     */
    public function postUpdate(ConnectionInterface $con = null)
    {
        if (is_callable('parent::postUpdate')) {
            parent::postUpdate($con);
        }
    }

    /**
     * Code to be run before deleting the object in database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preDelete(ConnectionInterface $con = null)
    {
        if (is_callable('parent::preDelete')) {
            return parent::preDelete($con);
        }
        return true;
    }

    /**
     * Code to be run after deleting the object in database
     * @param ConnectionInterface $con
     */
    public function postDelete(ConnectionInterface $con = null)
    {
        if (is_callable('parent::postDelete')) {
            parent::postDelete($con);
        }
    }


    /**
     * Derived method to catches calls to undefined methods.
     *
     * Provides magic import/export method support (fromXML()/toXML(), fromYAML()/toYAML(), etc.).
     * Allows to define default __call() behavior if you overwrite __call()
     *
     * @param string $name
     * @param mixed  $params
     *
     * @return array|string
     */
    public function __call($name, $params)
    {
        if (0 === strpos($name, 'get')) {
            $virtualColumn = substr($name, 3);
            if ($this->hasVirtualColumn($virtualColumn)) {
                return $this->getVirtualColumn($virtualColumn);
            }

            $virtualColumn = lcfirst($virtualColumn);
            if ($this->hasVirtualColumn($virtualColumn)) {
                return $this->getVirtualColumn($virtualColumn);
            }
        }

        if (0 === strpos($name, 'from')) {
            $format = substr($name, 4);

            return $this->importFrom($format, reset($params));
        }

        if (0 === strpos($name, 'to')) {
            $format = substr($name, 2);
            $includeLazyLoadColumns = isset($params[0]) ? $params[0] : true;

            return $this->exportTo($format, $includeLazyLoadColumns);
        }

        throw new BadMethodCallException(sprintf('Call to undefined method: %s.', $name));
    }

}
