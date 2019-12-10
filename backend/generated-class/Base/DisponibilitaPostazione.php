<?php

namespace Base;

use \AssegnamentiPostazione as ChildAssegnamentiPostazione;
use \AssegnamentiPostazioneQuery as ChildAssegnamentiPostazioneQuery;
use \DisponibilitaPostazione as ChildDisponibilitaPostazione;
use \DisponibilitaPostazioneQuery as ChildDisponibilitaPostazioneQuery;
use \SubaffittiPostazione as ChildSubaffittiPostazione;
use \SubaffittiPostazioneQuery as ChildSubaffittiPostazioneQuery;
use \DateTime;
use \Exception;
use \PDO;
use Map\DisponibilitaPostazioneTableMap;
use Map\SubaffittiPostazioneTableMap;
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
use Propel\Runtime\Util\PropelDateTime;

/**
 * Base class that represents a row from the 'disponibilita_postazione' table.
 *
 *
 *
 * @package    propel.generator..Base
 */
abstract class DisponibilitaPostazione implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\Map\\DisponibilitaPostazioneTableMap';


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
     * The value for the id_disponibilita_postazione field.
     *
     * @var        int
     */
    protected $id_disponibilita_postazione;

    /**
     * The value for the id_assegnamento_postazione field.
     *
     * @var        int
     */
    protected $id_assegnamento_postazione;

    /**
     * The value for the data_inizio field.
     *
     * @var        DateTime
     */
    protected $data_inizio;

    /**
     * The value for the data_fine field.
     *
     * @var        DateTime
     */
    protected $data_fine;

    /**
     * @var        ChildAssegnamentiPostazione
     */
    protected $aAssegnamentiPostazione;

    /**
     * @var        ObjectCollection|ChildSubaffittiPostazione[] Collection to store aggregation of ChildSubaffittiPostazione objects.
     */
    protected $collSubaffittiPostaziones;
    protected $collSubaffittiPostazionesPartial;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildSubaffittiPostazione[]
     */
    protected $subaffittiPostazionesScheduledForDeletion = null;

    /**
     * Initializes internal state of Base\DisponibilitaPostazione object.
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
     * Compares this with another <code>DisponibilitaPostazione</code> instance.  If
     * <code>obj</code> is an instance of <code>DisponibilitaPostazione</code>, delegates to
     * <code>equals(DisponibilitaPostazione)</code>.  Otherwise, returns <code>false</code>.
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
     * @return $this|DisponibilitaPostazione The current object, for fluid interface
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
     * Get the [id_disponibilita_postazione] column value.
     *
     * @return int
     */
    public function getIdDisponibilitaPostazione()
    {
        return $this->id_disponibilita_postazione;
    }

    /**
     * Get the [id_assegnamento_postazione] column value.
     *
     * @return int
     */
    public function getIdAssegnamentoPostazione()
    {
        return $this->id_assegnamento_postazione;
    }

    /**
     * Get the [optionally formatted] temporal [data_inizio] column value.
     *
     *
     * @param      string $format The date/time format string (either date()-style or strftime()-style).
     *                            If format is NULL, then the raw DateTime object will be returned.
     *
     * @return string|DateTime Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00 00:00:00
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getDataInizio($format = NULL)
    {
        if ($format === null) {
            return $this->data_inizio;
        } else {
            return $this->data_inizio instanceof \DateTimeInterface ? $this->data_inizio->format($format) : null;
        }
    }

    /**
     * Get the [optionally formatted] temporal [data_fine] column value.
     *
     *
     * @param      string $format The date/time format string (either date()-style or strftime()-style).
     *                            If format is NULL, then the raw DateTime object will be returned.
     *
     * @return string|DateTime Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00 00:00:00
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getDataFine($format = NULL)
    {
        if ($format === null) {
            return $this->data_fine;
        } else {
            return $this->data_fine instanceof \DateTimeInterface ? $this->data_fine->format($format) : null;
        }
    }

    /**
     * Set the value of [id_disponibilita_postazione] column.
     *
     * @param int $v new value
     * @return $this|\DisponibilitaPostazione The current object (for fluent API support)
     */
    public function setIdDisponibilitaPostazione($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id_disponibilita_postazione !== $v) {
            $this->id_disponibilita_postazione = $v;
            $this->modifiedColumns[DisponibilitaPostazioneTableMap::COL_ID_DISPONIBILITA_POSTAZIONE] = true;
        }

        return $this;
    } // setIdDisponibilitaPostazione()

    /**
     * Set the value of [id_assegnamento_postazione] column.
     *
     * @param int $v new value
     * @return $this|\DisponibilitaPostazione The current object (for fluent API support)
     */
    public function setIdAssegnamentoPostazione($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id_assegnamento_postazione !== $v) {
            $this->id_assegnamento_postazione = $v;
            $this->modifiedColumns[DisponibilitaPostazioneTableMap::COL_ID_ASSEGNAMENTO_POSTAZIONE] = true;
        }

        if ($this->aAssegnamentiPostazione !== null && $this->aAssegnamentiPostazione->getIdAssegnamentoPostazione() !== $v) {
            $this->aAssegnamentiPostazione = null;
        }

        return $this;
    } // setIdAssegnamentoPostazione()

    /**
     * Sets the value of [data_inizio] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTimeInterface value.
     *               Empty strings are treated as NULL.
     * @return $this|\DisponibilitaPostazione The current object (for fluent API support)
     */
    public function setDataInizio($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->data_inizio !== null || $dt !== null) {
            if ($this->data_inizio === null || $dt === null || $dt->format("Y-m-d H:i:s.u") !== $this->data_inizio->format("Y-m-d H:i:s.u")) {
                $this->data_inizio = $dt === null ? null : clone $dt;
                $this->modifiedColumns[DisponibilitaPostazioneTableMap::COL_DATA_INIZIO] = true;
            }
        } // if either are not null

        return $this;
    } // setDataInizio()

    /**
     * Sets the value of [data_fine] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTimeInterface value.
     *               Empty strings are treated as NULL.
     * @return $this|\DisponibilitaPostazione The current object (for fluent API support)
     */
    public function setDataFine($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->data_fine !== null || $dt !== null) {
            if ($this->data_fine === null || $dt === null || $dt->format("Y-m-d H:i:s.u") !== $this->data_fine->format("Y-m-d H:i:s.u")) {
                $this->data_fine = $dt === null ? null : clone $dt;
                $this->modifiedColumns[DisponibilitaPostazioneTableMap::COL_DATA_FINE] = true;
            }
        } // if either are not null

        return $this;
    } // setDataFine()

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

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : DisponibilitaPostazioneTableMap::translateFieldName('IdDisponibilitaPostazione', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id_disponibilita_postazione = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : DisponibilitaPostazioneTableMap::translateFieldName('IdAssegnamentoPostazione', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id_assegnamento_postazione = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : DisponibilitaPostazioneTableMap::translateFieldName('DataInizio', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->data_inizio = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : DisponibilitaPostazioneTableMap::translateFieldName('DataFine', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->data_fine = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 4; // 4 = DisponibilitaPostazioneTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\DisponibilitaPostazione'), 0, $e);
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
        if ($this->aAssegnamentiPostazione !== null && $this->id_assegnamento_postazione !== $this->aAssegnamentiPostazione->getIdAssegnamentoPostazione()) {
            $this->aAssegnamentiPostazione = null;
        }
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
            $con = Propel::getServiceContainer()->getReadConnection(DisponibilitaPostazioneTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildDisponibilitaPostazioneQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aAssegnamentiPostazione = null;
            $this->collSubaffittiPostaziones = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see DisponibilitaPostazione::setDeleted()
     * @see DisponibilitaPostazione::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(DisponibilitaPostazioneTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildDisponibilitaPostazioneQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(DisponibilitaPostazioneTableMap::DATABASE_NAME);
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
                DisponibilitaPostazioneTableMap::addInstanceToPool($this);
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

            // We call the save method on the following object(s) if they
            // were passed to this object by their corresponding set
            // method.  This object relates to these object(s) by a
            // foreign key reference.

            if ($this->aAssegnamentiPostazione !== null) {
                if ($this->aAssegnamentiPostazione->isModified() || $this->aAssegnamentiPostazione->isNew()) {
                    $affectedRows += $this->aAssegnamentiPostazione->save($con);
                }
                $this->setAssegnamentiPostazione($this->aAssegnamentiPostazione);
            }

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

            if ($this->subaffittiPostazionesScheduledForDeletion !== null) {
                if (!$this->subaffittiPostazionesScheduledForDeletion->isEmpty()) {
                    \SubaffittiPostazioneQuery::create()
                        ->filterByPrimaryKeys($this->subaffittiPostazionesScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->subaffittiPostazionesScheduledForDeletion = null;
                }
            }

            if ($this->collSubaffittiPostaziones !== null) {
                foreach ($this->collSubaffittiPostaziones as $referrerFK) {
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

        $this->modifiedColumns[DisponibilitaPostazioneTableMap::COL_ID_DISPONIBILITA_POSTAZIONE] = true;
        if (null !== $this->id_disponibilita_postazione) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . DisponibilitaPostazioneTableMap::COL_ID_DISPONIBILITA_POSTAZIONE . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(DisponibilitaPostazioneTableMap::COL_ID_DISPONIBILITA_POSTAZIONE)) {
            $modifiedColumns[':p' . $index++]  = 'id_disponibilita_postazione';
        }
        if ($this->isColumnModified(DisponibilitaPostazioneTableMap::COL_ID_ASSEGNAMENTO_POSTAZIONE)) {
            $modifiedColumns[':p' . $index++]  = 'id_assegnamento_postazione';
        }
        if ($this->isColumnModified(DisponibilitaPostazioneTableMap::COL_DATA_INIZIO)) {
            $modifiedColumns[':p' . $index++]  = 'data_inizio';
        }
        if ($this->isColumnModified(DisponibilitaPostazioneTableMap::COL_DATA_FINE)) {
            $modifiedColumns[':p' . $index++]  = 'data_fine';
        }

        $sql = sprintf(
            'INSERT INTO disponibilita_postazione (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case 'id_disponibilita_postazione':
                        $stmt->bindValue($identifier, $this->id_disponibilita_postazione, PDO::PARAM_INT);
                        break;
                    case 'id_assegnamento_postazione':
                        $stmt->bindValue($identifier, $this->id_assegnamento_postazione, PDO::PARAM_INT);
                        break;
                    case 'data_inizio':
                        $stmt->bindValue($identifier, $this->data_inizio ? $this->data_inizio->format("Y-m-d H:i:s.u") : null, PDO::PARAM_STR);
                        break;
                    case 'data_fine':
                        $stmt->bindValue($identifier, $this->data_fine ? $this->data_fine->format("Y-m-d H:i:s.u") : null, PDO::PARAM_STR);
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
        $this->setIdDisponibilitaPostazione($pk);

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
        $pos = DisponibilitaPostazioneTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getIdDisponibilitaPostazione();
                break;
            case 1:
                return $this->getIdAssegnamentoPostazione();
                break;
            case 2:
                return $this->getDataInizio();
                break;
            case 3:
                return $this->getDataFine();
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

        if (isset($alreadyDumpedObjects['DisponibilitaPostazione'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['DisponibilitaPostazione'][$this->hashCode()] = true;
        $keys = DisponibilitaPostazioneTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getIdDisponibilitaPostazione(),
            $keys[1] => $this->getIdAssegnamentoPostazione(),
            $keys[2] => $this->getDataInizio(),
            $keys[3] => $this->getDataFine(),
        );
        if ($result[$keys[2]] instanceof \DateTime) {
            $result[$keys[2]] = $result[$keys[2]]->format('c');
        }

        if ($result[$keys[3]] instanceof \DateTime) {
            $result[$keys[3]] = $result[$keys[3]]->format('c');
        }

        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->aAssegnamentiPostazione) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'assegnamentiPostazione';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'assegnamenti_postazione';
                        break;
                    default:
                        $key = 'AssegnamentiPostazione';
                }

                $result[$key] = $this->aAssegnamentiPostazione->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->collSubaffittiPostaziones) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'subaffittiPostaziones';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'subaffitti_postaziones';
                        break;
                    default:
                        $key = 'SubaffittiPostaziones';
                }

                $result[$key] = $this->collSubaffittiPostaziones->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
     * @return $this|\DisponibilitaPostazione
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = DisponibilitaPostazioneTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\DisponibilitaPostazione
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setIdDisponibilitaPostazione($value);
                break;
            case 1:
                $this->setIdAssegnamentoPostazione($value);
                break;
            case 2:
                $this->setDataInizio($value);
                break;
            case 3:
                $this->setDataFine($value);
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
        $keys = DisponibilitaPostazioneTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setIdDisponibilitaPostazione($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setIdAssegnamentoPostazione($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setDataInizio($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setDataFine($arr[$keys[3]]);
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
     * @return $this|\DisponibilitaPostazione The current object, for fluid interface
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
        $criteria = new Criteria(DisponibilitaPostazioneTableMap::DATABASE_NAME);

        if ($this->isColumnModified(DisponibilitaPostazioneTableMap::COL_ID_DISPONIBILITA_POSTAZIONE)) {
            $criteria->add(DisponibilitaPostazioneTableMap::COL_ID_DISPONIBILITA_POSTAZIONE, $this->id_disponibilita_postazione);
        }
        if ($this->isColumnModified(DisponibilitaPostazioneTableMap::COL_ID_ASSEGNAMENTO_POSTAZIONE)) {
            $criteria->add(DisponibilitaPostazioneTableMap::COL_ID_ASSEGNAMENTO_POSTAZIONE, $this->id_assegnamento_postazione);
        }
        if ($this->isColumnModified(DisponibilitaPostazioneTableMap::COL_DATA_INIZIO)) {
            $criteria->add(DisponibilitaPostazioneTableMap::COL_DATA_INIZIO, $this->data_inizio);
        }
        if ($this->isColumnModified(DisponibilitaPostazioneTableMap::COL_DATA_FINE)) {
            $criteria->add(DisponibilitaPostazioneTableMap::COL_DATA_FINE, $this->data_fine);
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
        $criteria = ChildDisponibilitaPostazioneQuery::create();
        $criteria->add(DisponibilitaPostazioneTableMap::COL_ID_DISPONIBILITA_POSTAZIONE, $this->id_disponibilita_postazione);

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
        $validPk = null !== $this->getIdDisponibilitaPostazione();

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
        return $this->getIdDisponibilitaPostazione();
    }

    /**
     * Generic method to set the primary key (id_disponibilita_postazione column).
     *
     * @param       int $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setIdDisponibilitaPostazione($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {
        return null === $this->getIdDisponibilitaPostazione();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param      object $copyObj An object of \DisponibilitaPostazione (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setIdAssegnamentoPostazione($this->getIdAssegnamentoPostazione());
        $copyObj->setDataInizio($this->getDataInizio());
        $copyObj->setDataFine($this->getDataFine());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getSubaffittiPostaziones() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addSubaffittiPostazione($relObj->copy($deepCopy));
                }
            }

        } // if ($deepCopy)

        if ($makeNew) {
            $copyObj->setNew(true);
            $copyObj->setIdDisponibilitaPostazione(NULL); // this is a auto-increment column, so set to default value
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
     * @return \DisponibilitaPostazione Clone of current object.
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
     * Declares an association between this object and a ChildAssegnamentiPostazione object.
     *
     * @param  ChildAssegnamentiPostazione $v
     * @return $this|\DisponibilitaPostazione The current object (for fluent API support)
     * @throws PropelException
     */
    public function setAssegnamentiPostazione(ChildAssegnamentiPostazione $v = null)
    {
        if ($v === null) {
            $this->setIdAssegnamentoPostazione(NULL);
        } else {
            $this->setIdAssegnamentoPostazione($v->getIdAssegnamentoPostazione());
        }

        $this->aAssegnamentiPostazione = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildAssegnamentiPostazione object, it will not be re-added.
        if ($v !== null) {
            $v->addDisponibilitaPostazione($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildAssegnamentiPostazione object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildAssegnamentiPostazione The associated ChildAssegnamentiPostazione object.
     * @throws PropelException
     */
    public function getAssegnamentiPostazione(ConnectionInterface $con = null)
    {
        if ($this->aAssegnamentiPostazione === null && ($this->id_assegnamento_postazione !== null)) {
            $this->aAssegnamentiPostazione = ChildAssegnamentiPostazioneQuery::create()->findPk($this->id_assegnamento_postazione, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aAssegnamentiPostazione->addDisponibilitaPostaziones($this);
             */
        }

        return $this->aAssegnamentiPostazione;
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
        if ('SubaffittiPostazione' == $relationName) {
            return $this->initSubaffittiPostaziones();
        }
    }

    /**
     * Clears out the collSubaffittiPostaziones collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addSubaffittiPostaziones()
     */
    public function clearSubaffittiPostaziones()
    {
        $this->collSubaffittiPostaziones = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collSubaffittiPostaziones collection loaded partially.
     */
    public function resetPartialSubaffittiPostaziones($v = true)
    {
        $this->collSubaffittiPostazionesPartial = $v;
    }

    /**
     * Initializes the collSubaffittiPostaziones collection.
     *
     * By default this just sets the collSubaffittiPostaziones collection to an empty array (like clearcollSubaffittiPostaziones());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initSubaffittiPostaziones($overrideExisting = true)
    {
        if (null !== $this->collSubaffittiPostaziones && !$overrideExisting) {
            return;
        }

        $collectionClassName = SubaffittiPostazioneTableMap::getTableMap()->getCollectionClassName();

        $this->collSubaffittiPostaziones = new $collectionClassName;
        $this->collSubaffittiPostaziones->setModel('\SubaffittiPostazione');
    }

    /**
     * Gets an array of ChildSubaffittiPostazione objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildDisponibilitaPostazione is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildSubaffittiPostazione[] List of ChildSubaffittiPostazione objects
     * @throws PropelException
     */
    public function getSubaffittiPostaziones(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collSubaffittiPostazionesPartial && !$this->isNew();
        if (null === $this->collSubaffittiPostaziones || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collSubaffittiPostaziones) {
                // return empty collection
                $this->initSubaffittiPostaziones();
            } else {
                $collSubaffittiPostaziones = ChildSubaffittiPostazioneQuery::create(null, $criteria)
                    ->filterByDisponibilitaPostazione($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collSubaffittiPostazionesPartial && count($collSubaffittiPostaziones)) {
                        $this->initSubaffittiPostaziones(false);

                        foreach ($collSubaffittiPostaziones as $obj) {
                            if (false == $this->collSubaffittiPostaziones->contains($obj)) {
                                $this->collSubaffittiPostaziones->append($obj);
                            }
                        }

                        $this->collSubaffittiPostazionesPartial = true;
                    }

                    return $collSubaffittiPostaziones;
                }

                if ($partial && $this->collSubaffittiPostaziones) {
                    foreach ($this->collSubaffittiPostaziones as $obj) {
                        if ($obj->isNew()) {
                            $collSubaffittiPostaziones[] = $obj;
                        }
                    }
                }

                $this->collSubaffittiPostaziones = $collSubaffittiPostaziones;
                $this->collSubaffittiPostazionesPartial = false;
            }
        }

        return $this->collSubaffittiPostaziones;
    }

    /**
     * Sets a collection of ChildSubaffittiPostazione objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $subaffittiPostaziones A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildDisponibilitaPostazione The current object (for fluent API support)
     */
    public function setSubaffittiPostaziones(Collection $subaffittiPostaziones, ConnectionInterface $con = null)
    {
        /** @var ChildSubaffittiPostazione[] $subaffittiPostazionesToDelete */
        $subaffittiPostazionesToDelete = $this->getSubaffittiPostaziones(new Criteria(), $con)->diff($subaffittiPostaziones);


        $this->subaffittiPostazionesScheduledForDeletion = $subaffittiPostazionesToDelete;

        foreach ($subaffittiPostazionesToDelete as $subaffittiPostazioneRemoved) {
            $subaffittiPostazioneRemoved->setDisponibilitaPostazione(null);
        }

        $this->collSubaffittiPostaziones = null;
        foreach ($subaffittiPostaziones as $subaffittiPostazione) {
            $this->addSubaffittiPostazione($subaffittiPostazione);
        }

        $this->collSubaffittiPostaziones = $subaffittiPostaziones;
        $this->collSubaffittiPostazionesPartial = false;

        return $this;
    }

    /**
     * Returns the number of related SubaffittiPostazione objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related SubaffittiPostazione objects.
     * @throws PropelException
     */
    public function countSubaffittiPostaziones(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collSubaffittiPostazionesPartial && !$this->isNew();
        if (null === $this->collSubaffittiPostaziones || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collSubaffittiPostaziones) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getSubaffittiPostaziones());
            }

            $query = ChildSubaffittiPostazioneQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByDisponibilitaPostazione($this)
                ->count($con);
        }

        return count($this->collSubaffittiPostaziones);
    }

    /**
     * Method called to associate a ChildSubaffittiPostazione object to this object
     * through the ChildSubaffittiPostazione foreign key attribute.
     *
     * @param  ChildSubaffittiPostazione $l ChildSubaffittiPostazione
     * @return $this|\DisponibilitaPostazione The current object (for fluent API support)
     */
    public function addSubaffittiPostazione(ChildSubaffittiPostazione $l)
    {
        if ($this->collSubaffittiPostaziones === null) {
            $this->initSubaffittiPostaziones();
            $this->collSubaffittiPostazionesPartial = true;
        }

        if (!$this->collSubaffittiPostaziones->contains($l)) {
            $this->doAddSubaffittiPostazione($l);

            if ($this->subaffittiPostazionesScheduledForDeletion and $this->subaffittiPostazionesScheduledForDeletion->contains($l)) {
                $this->subaffittiPostazionesScheduledForDeletion->remove($this->subaffittiPostazionesScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildSubaffittiPostazione $subaffittiPostazione The ChildSubaffittiPostazione object to add.
     */
    protected function doAddSubaffittiPostazione(ChildSubaffittiPostazione $subaffittiPostazione)
    {
        $this->collSubaffittiPostaziones[]= $subaffittiPostazione;
        $subaffittiPostazione->setDisponibilitaPostazione($this);
    }

    /**
     * @param  ChildSubaffittiPostazione $subaffittiPostazione The ChildSubaffittiPostazione object to remove.
     * @return $this|ChildDisponibilitaPostazione The current object (for fluent API support)
     */
    public function removeSubaffittiPostazione(ChildSubaffittiPostazione $subaffittiPostazione)
    {
        if ($this->getSubaffittiPostaziones()->contains($subaffittiPostazione)) {
            $pos = $this->collSubaffittiPostaziones->search($subaffittiPostazione);
            $this->collSubaffittiPostaziones->remove($pos);
            if (null === $this->subaffittiPostazionesScheduledForDeletion) {
                $this->subaffittiPostazionesScheduledForDeletion = clone $this->collSubaffittiPostaziones;
                $this->subaffittiPostazionesScheduledForDeletion->clear();
            }
            $this->subaffittiPostazionesScheduledForDeletion[]= clone $subaffittiPostazione;
            $subaffittiPostazione->setDisponibilitaPostazione(null);
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
        if (null !== $this->aAssegnamentiPostazione) {
            $this->aAssegnamentiPostazione->removeDisponibilitaPostazione($this);
        }
        $this->id_disponibilita_postazione = null;
        $this->id_assegnamento_postazione = null;
        $this->data_inizio = null;
        $this->data_fine = null;
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
            if ($this->collSubaffittiPostaziones) {
                foreach ($this->collSubaffittiPostaziones as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collSubaffittiPostaziones = null;
        $this->aAssegnamentiPostazione = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(DisponibilitaPostazioneTableMap::DEFAULT_STRING_FORMAT);
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
