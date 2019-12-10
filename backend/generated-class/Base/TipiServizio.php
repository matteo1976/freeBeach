<?php

namespace Base;

use \CostiServizio as ChildCostiServizio;
use \CostiServizioQuery as ChildCostiServizioQuery;
use \Servizi as ChildServizi;
use \ServiziQuery as ChildServiziQuery;
use \TipiServizio as ChildTipiServizio;
use \TipiServizioQuery as ChildTipiServizioQuery;
use \Exception;
use \PDO;
use Map\CostiServizioTableMap;
use Map\ServiziTableMap;
use Map\TipiServizioTableMap;
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
 * Base class that represents a row from the 'tipi_servizio' table.
 *
 *
 *
 * @package    propel.generator..Base
 */
abstract class TipiServizio implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\Map\\TipiServizioTableMap';


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
     * The value for the id_tipo_servizio field.
     *
     * @var        int
     */
    protected $id_tipo_servizio;

    /**
     * The value for the descrizione field.
     *
     * @var        string
     */
    protected $descrizione;

    /**
     * @var        ObjectCollection|ChildCostiServizio[] Collection to store aggregation of ChildCostiServizio objects.
     */
    protected $collCostiServizios;
    protected $collCostiServiziosPartial;

    /**
     * @var        ObjectCollection|ChildServizi[] Collection to store aggregation of ChildServizi objects.
     */
    protected $collServizis;
    protected $collServizisPartial;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildCostiServizio[]
     */
    protected $costiServiziosScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildServizi[]
     */
    protected $servizisScheduledForDeletion = null;

    /**
     * Initializes internal state of Base\TipiServizio object.
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
     * Compares this with another <code>TipiServizio</code> instance.  If
     * <code>obj</code> is an instance of <code>TipiServizio</code>, delegates to
     * <code>equals(TipiServizio)</code>.  Otherwise, returns <code>false</code>.
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
     * @return $this|TipiServizio The current object, for fluid interface
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
     * Get the [id_tipo_servizio] column value.
     *
     * @return int
     */
    public function getIdTipoServizio()
    {
        return $this->id_tipo_servizio;
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
     * Set the value of [id_tipo_servizio] column.
     *
     * @param int $v new value
     * @return $this|\TipiServizio The current object (for fluent API support)
     */
    public function setIdTipoServizio($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id_tipo_servizio !== $v) {
            $this->id_tipo_servizio = $v;
            $this->modifiedColumns[TipiServizioTableMap::COL_ID_TIPO_SERVIZIO] = true;
        }

        return $this;
    } // setIdTipoServizio()

    /**
     * Set the value of [descrizione] column.
     *
     * @param string $v new value
     * @return $this|\TipiServizio The current object (for fluent API support)
     */
    public function setDescrizione($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->descrizione !== $v) {
            $this->descrizione = $v;
            $this->modifiedColumns[TipiServizioTableMap::COL_DESCRIZIONE] = true;
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

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : TipiServizioTableMap::translateFieldName('IdTipoServizio', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id_tipo_servizio = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : TipiServizioTableMap::translateFieldName('Descrizione', TableMap::TYPE_PHPNAME, $indexType)];
            $this->descrizione = (null !== $col) ? (string) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 2; // 2 = TipiServizioTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\TipiServizio'), 0, $e);
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
            $con = Propel::getServiceContainer()->getReadConnection(TipiServizioTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildTipiServizioQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->collCostiServizios = null;

            $this->collServizis = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see TipiServizio::setDeleted()
     * @see TipiServizio::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(TipiServizioTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildTipiServizioQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(TipiServizioTableMap::DATABASE_NAME);
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
                TipiServizioTableMap::addInstanceToPool($this);
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

            if ($this->costiServiziosScheduledForDeletion !== null) {
                if (!$this->costiServiziosScheduledForDeletion->isEmpty()) {
                    \CostiServizioQuery::create()
                        ->filterByPrimaryKeys($this->costiServiziosScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->costiServiziosScheduledForDeletion = null;
                }
            }

            if ($this->collCostiServizios !== null) {
                foreach ($this->collCostiServizios as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->servizisScheduledForDeletion !== null) {
                if (!$this->servizisScheduledForDeletion->isEmpty()) {
                    \ServiziQuery::create()
                        ->filterByPrimaryKeys($this->servizisScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->servizisScheduledForDeletion = null;
                }
            }

            if ($this->collServizis !== null) {
                foreach ($this->collServizis as $referrerFK) {
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

        $this->modifiedColumns[TipiServizioTableMap::COL_ID_TIPO_SERVIZIO] = true;
        if (null !== $this->id_tipo_servizio) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . TipiServizioTableMap::COL_ID_TIPO_SERVIZIO . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(TipiServizioTableMap::COL_ID_TIPO_SERVIZIO)) {
            $modifiedColumns[':p' . $index++]  = 'id_tipo_servizio';
        }
        if ($this->isColumnModified(TipiServizioTableMap::COL_DESCRIZIONE)) {
            $modifiedColumns[':p' . $index++]  = 'descrizione';
        }

        $sql = sprintf(
            'INSERT INTO tipi_servizio (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case 'id_tipo_servizio':
                        $stmt->bindValue($identifier, $this->id_tipo_servizio, PDO::PARAM_INT);
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
        $this->setIdTipoServizio($pk);

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
        $pos = TipiServizioTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getIdTipoServizio();
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

        if (isset($alreadyDumpedObjects['TipiServizio'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['TipiServizio'][$this->hashCode()] = true;
        $keys = TipiServizioTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getIdTipoServizio(),
            $keys[1] => $this->getDescrizione(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->collCostiServizios) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'costiServizios';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'costi_servizios';
                        break;
                    default:
                        $key = 'CostiServizios';
                }

                $result[$key] = $this->collCostiServizios->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collServizis) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'servizis';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'servizis';
                        break;
                    default:
                        $key = 'Servizis';
                }

                $result[$key] = $this->collServizis->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
     * @return $this|\TipiServizio
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = TipiServizioTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\TipiServizio
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setIdTipoServizio($value);
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
        $keys = TipiServizioTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setIdTipoServizio($arr[$keys[0]]);
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
     * @return $this|\TipiServizio The current object, for fluid interface
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
        $criteria = new Criteria(TipiServizioTableMap::DATABASE_NAME);

        if ($this->isColumnModified(TipiServizioTableMap::COL_ID_TIPO_SERVIZIO)) {
            $criteria->add(TipiServizioTableMap::COL_ID_TIPO_SERVIZIO, $this->id_tipo_servizio);
        }
        if ($this->isColumnModified(TipiServizioTableMap::COL_DESCRIZIONE)) {
            $criteria->add(TipiServizioTableMap::COL_DESCRIZIONE, $this->descrizione);
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
        $criteria = ChildTipiServizioQuery::create();
        $criteria->add(TipiServizioTableMap::COL_ID_TIPO_SERVIZIO, $this->id_tipo_servizio);

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
        $validPk = null !== $this->getIdTipoServizio();

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
        return $this->getIdTipoServizio();
    }

    /**
     * Generic method to set the primary key (id_tipo_servizio column).
     *
     * @param       int $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setIdTipoServizio($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {
        return null === $this->getIdTipoServizio();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param      object $copyObj An object of \TipiServizio (or compatible) type.
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

            foreach ($this->getCostiServizios() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addCostiServizio($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getServizis() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addServizi($relObj->copy($deepCopy));
                }
            }

        } // if ($deepCopy)

        if ($makeNew) {
            $copyObj->setNew(true);
            $copyObj->setIdTipoServizio(NULL); // this is a auto-increment column, so set to default value
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
     * @return \TipiServizio Clone of current object.
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
        if ('CostiServizio' == $relationName) {
            return $this->initCostiServizios();
        }
        if ('Servizi' == $relationName) {
            return $this->initServizis();
        }
    }

    /**
     * Clears out the collCostiServizios collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addCostiServizios()
     */
    public function clearCostiServizios()
    {
        $this->collCostiServizios = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collCostiServizios collection loaded partially.
     */
    public function resetPartialCostiServizios($v = true)
    {
        $this->collCostiServiziosPartial = $v;
    }

    /**
     * Initializes the collCostiServizios collection.
     *
     * By default this just sets the collCostiServizios collection to an empty array (like clearcollCostiServizios());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initCostiServizios($overrideExisting = true)
    {
        if (null !== $this->collCostiServizios && !$overrideExisting) {
            return;
        }

        $collectionClassName = CostiServizioTableMap::getTableMap()->getCollectionClassName();

        $this->collCostiServizios = new $collectionClassName;
        $this->collCostiServizios->setModel('\CostiServizio');
    }

    /**
     * Gets an array of ChildCostiServizio objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildTipiServizio is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildCostiServizio[] List of ChildCostiServizio objects
     * @throws PropelException
     */
    public function getCostiServizios(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collCostiServiziosPartial && !$this->isNew();
        if (null === $this->collCostiServizios || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collCostiServizios) {
                // return empty collection
                $this->initCostiServizios();
            } else {
                $collCostiServizios = ChildCostiServizioQuery::create(null, $criteria)
                    ->filterByTipiServizio($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collCostiServiziosPartial && count($collCostiServizios)) {
                        $this->initCostiServizios(false);

                        foreach ($collCostiServizios as $obj) {
                            if (false == $this->collCostiServizios->contains($obj)) {
                                $this->collCostiServizios->append($obj);
                            }
                        }

                        $this->collCostiServiziosPartial = true;
                    }

                    return $collCostiServizios;
                }

                if ($partial && $this->collCostiServizios) {
                    foreach ($this->collCostiServizios as $obj) {
                        if ($obj->isNew()) {
                            $collCostiServizios[] = $obj;
                        }
                    }
                }

                $this->collCostiServizios = $collCostiServizios;
                $this->collCostiServiziosPartial = false;
            }
        }

        return $this->collCostiServizios;
    }

    /**
     * Sets a collection of ChildCostiServizio objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $costiServizios A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildTipiServizio The current object (for fluent API support)
     */
    public function setCostiServizios(Collection $costiServizios, ConnectionInterface $con = null)
    {
        /** @var ChildCostiServizio[] $costiServiziosToDelete */
        $costiServiziosToDelete = $this->getCostiServizios(new Criteria(), $con)->diff($costiServizios);


        $this->costiServiziosScheduledForDeletion = $costiServiziosToDelete;

        foreach ($costiServiziosToDelete as $costiServizioRemoved) {
            $costiServizioRemoved->setTipiServizio(null);
        }

        $this->collCostiServizios = null;
        foreach ($costiServizios as $costiServizio) {
            $this->addCostiServizio($costiServizio);
        }

        $this->collCostiServizios = $costiServizios;
        $this->collCostiServiziosPartial = false;

        return $this;
    }

    /**
     * Returns the number of related CostiServizio objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related CostiServizio objects.
     * @throws PropelException
     */
    public function countCostiServizios(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collCostiServiziosPartial && !$this->isNew();
        if (null === $this->collCostiServizios || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collCostiServizios) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getCostiServizios());
            }

            $query = ChildCostiServizioQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByTipiServizio($this)
                ->count($con);
        }

        return count($this->collCostiServizios);
    }

    /**
     * Method called to associate a ChildCostiServizio object to this object
     * through the ChildCostiServizio foreign key attribute.
     *
     * @param  ChildCostiServizio $l ChildCostiServizio
     * @return $this|\TipiServizio The current object (for fluent API support)
     */
    public function addCostiServizio(ChildCostiServizio $l)
    {
        if ($this->collCostiServizios === null) {
            $this->initCostiServizios();
            $this->collCostiServiziosPartial = true;
        }

        if (!$this->collCostiServizios->contains($l)) {
            $this->doAddCostiServizio($l);

            if ($this->costiServiziosScheduledForDeletion and $this->costiServiziosScheduledForDeletion->contains($l)) {
                $this->costiServiziosScheduledForDeletion->remove($this->costiServiziosScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildCostiServizio $costiServizio The ChildCostiServizio object to add.
     */
    protected function doAddCostiServizio(ChildCostiServizio $costiServizio)
    {
        $this->collCostiServizios[]= $costiServizio;
        $costiServizio->setTipiServizio($this);
    }

    /**
     * @param  ChildCostiServizio $costiServizio The ChildCostiServizio object to remove.
     * @return $this|ChildTipiServizio The current object (for fluent API support)
     */
    public function removeCostiServizio(ChildCostiServizio $costiServizio)
    {
        if ($this->getCostiServizios()->contains($costiServizio)) {
            $pos = $this->collCostiServizios->search($costiServizio);
            $this->collCostiServizios->remove($pos);
            if (null === $this->costiServiziosScheduledForDeletion) {
                $this->costiServiziosScheduledForDeletion = clone $this->collCostiServizios;
                $this->costiServiziosScheduledForDeletion->clear();
            }
            $this->costiServiziosScheduledForDeletion[]= clone $costiServizio;
            $costiServizio->setTipiServizio(null);
        }

        return $this;
    }

    /**
     * Clears out the collServizis collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addServizis()
     */
    public function clearServizis()
    {
        $this->collServizis = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collServizis collection loaded partially.
     */
    public function resetPartialServizis($v = true)
    {
        $this->collServizisPartial = $v;
    }

    /**
     * Initializes the collServizis collection.
     *
     * By default this just sets the collServizis collection to an empty array (like clearcollServizis());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initServizis($overrideExisting = true)
    {
        if (null !== $this->collServizis && !$overrideExisting) {
            return;
        }

        $collectionClassName = ServiziTableMap::getTableMap()->getCollectionClassName();

        $this->collServizis = new $collectionClassName;
        $this->collServizis->setModel('\Servizi');
    }

    /**
     * Gets an array of ChildServizi objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildTipiServizio is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildServizi[] List of ChildServizi objects
     * @throws PropelException
     */
    public function getServizis(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collServizisPartial && !$this->isNew();
        if (null === $this->collServizis || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collServizis) {
                // return empty collection
                $this->initServizis();
            } else {
                $collServizis = ChildServiziQuery::create(null, $criteria)
                    ->filterByTipiServizio($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collServizisPartial && count($collServizis)) {
                        $this->initServizis(false);

                        foreach ($collServizis as $obj) {
                            if (false == $this->collServizis->contains($obj)) {
                                $this->collServizis->append($obj);
                            }
                        }

                        $this->collServizisPartial = true;
                    }

                    return $collServizis;
                }

                if ($partial && $this->collServizis) {
                    foreach ($this->collServizis as $obj) {
                        if ($obj->isNew()) {
                            $collServizis[] = $obj;
                        }
                    }
                }

                $this->collServizis = $collServizis;
                $this->collServizisPartial = false;
            }
        }

        return $this->collServizis;
    }

    /**
     * Sets a collection of ChildServizi objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $servizis A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildTipiServizio The current object (for fluent API support)
     */
    public function setServizis(Collection $servizis, ConnectionInterface $con = null)
    {
        /** @var ChildServizi[] $servizisToDelete */
        $servizisToDelete = $this->getServizis(new Criteria(), $con)->diff($servizis);


        $this->servizisScheduledForDeletion = $servizisToDelete;

        foreach ($servizisToDelete as $serviziRemoved) {
            $serviziRemoved->setTipiServizio(null);
        }

        $this->collServizis = null;
        foreach ($servizis as $servizi) {
            $this->addServizi($servizi);
        }

        $this->collServizis = $servizis;
        $this->collServizisPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Servizi objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Servizi objects.
     * @throws PropelException
     */
    public function countServizis(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collServizisPartial && !$this->isNew();
        if (null === $this->collServizis || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collServizis) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getServizis());
            }

            $query = ChildServiziQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByTipiServizio($this)
                ->count($con);
        }

        return count($this->collServizis);
    }

    /**
     * Method called to associate a ChildServizi object to this object
     * through the ChildServizi foreign key attribute.
     *
     * @param  ChildServizi $l ChildServizi
     * @return $this|\TipiServizio The current object (for fluent API support)
     */
    public function addServizi(ChildServizi $l)
    {
        if ($this->collServizis === null) {
            $this->initServizis();
            $this->collServizisPartial = true;
        }

        if (!$this->collServizis->contains($l)) {
            $this->doAddServizi($l);

            if ($this->servizisScheduledForDeletion and $this->servizisScheduledForDeletion->contains($l)) {
                $this->servizisScheduledForDeletion->remove($this->servizisScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildServizi $servizi The ChildServizi object to add.
     */
    protected function doAddServizi(ChildServizi $servizi)
    {
        $this->collServizis[]= $servizi;
        $servizi->setTipiServizio($this);
    }

    /**
     * @param  ChildServizi $servizi The ChildServizi object to remove.
     * @return $this|ChildTipiServizio The current object (for fluent API support)
     */
    public function removeServizi(ChildServizi $servizi)
    {
        if ($this->getServizis()->contains($servizi)) {
            $pos = $this->collServizis->search($servizi);
            $this->collServizis->remove($pos);
            if (null === $this->servizisScheduledForDeletion) {
                $this->servizisScheduledForDeletion = clone $this->collServizis;
                $this->servizisScheduledForDeletion->clear();
            }
            $this->servizisScheduledForDeletion[]= clone $servizi;
            $servizi->setTipiServizio(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this TipiServizio is new, it will return
     * an empty collection; or if this TipiServizio has previously
     * been saved, it will retrieve related Servizis from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in TipiServizio.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildServizi[] List of ChildServizi objects
     */
    public function getServizisJoinAssegnamentiPostazione(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildServiziQuery::create(null, $criteria);
        $query->joinWith('AssegnamentiPostazione', $joinBehavior);

        return $this->getServizis($query, $con);
    }

    /**
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear()
    {
        $this->id_tipo_servizio = null;
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
            if ($this->collCostiServizios) {
                foreach ($this->collCostiServizios as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collServizis) {
                foreach ($this->collServizis as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collCostiServizios = null;
        $this->collServizis = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(TipiServizioTableMap::DEFAULT_STRING_FORMAT);
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
