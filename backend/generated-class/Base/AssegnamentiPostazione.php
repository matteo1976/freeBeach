<?php

namespace Base;

use \Abbonamenti as ChildAbbonamenti;
use \AbbonamentiQuery as ChildAbbonamentiQuery;
use \AssegnamentiPostazione as ChildAssegnamentiPostazione;
use \AssegnamentiPostazioneQuery as ChildAssegnamentiPostazioneQuery;
use \Clienti as ChildClienti;
use \ClientiQuery as ChildClientiQuery;
use \DisponibilitaPostazione as ChildDisponibilitaPostazione;
use \DisponibilitaPostazioneQuery as ChildDisponibilitaPostazioneQuery;
use \Postazioni as ChildPostazioni;
use \PostazioniQuery as ChildPostazioniQuery;
use \Servizi as ChildServizi;
use \ServiziQuery as ChildServiziQuery;
use \DateTime;
use \Exception;
use \PDO;
use Map\AssegnamentiPostazioneTableMap;
use Map\DisponibilitaPostazioneTableMap;
use Map\ServiziTableMap;
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
 * Base class that represents a row from the 'assegnamenti_postazione' table.
 *
 *
 *
 * @package    propel.generator..Base
 */
abstract class AssegnamentiPostazione implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\Map\\AssegnamentiPostazioneTableMap';


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
     * The value for the id_assegnamento_postazione field.
     *
     * @var        int
     */
    protected $id_assegnamento_postazione;

    /**
     * The value for the id_cliente field.
     *
     * @var        int
     */
    protected $id_cliente;

    /**
     * The value for the id_postazione field.
     *
     * @var        int
     */
    protected $id_postazione;

    /**
     * The value for the id_abbonamento field.
     *
     * @var        int
     */
    protected $id_abbonamento;

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
     * The value for the autorizzati field.
     *
     * @var        string
     */
    protected $autorizzati;

    /**
     * The value for the note field.
     *
     * @var        string
     */
    protected $note;

    /**
     * @var        ChildPostazioni
     */
    protected $aPostazioni;

    /**
     * @var        ChildClienti
     */
    protected $aClienti;

    /**
     * @var        ChildAbbonamenti
     */
    protected $aAbbonamenti;

    /**
     * @var        ObjectCollection|ChildDisponibilitaPostazione[] Collection to store aggregation of ChildDisponibilitaPostazione objects.
     */
    protected $collDisponibilitaPostaziones;
    protected $collDisponibilitaPostazionesPartial;

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
     * @var ObjectCollection|ChildDisponibilitaPostazione[]
     */
    protected $disponibilitaPostazionesScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildServizi[]
     */
    protected $servizisScheduledForDeletion = null;

    /**
     * Initializes internal state of Base\AssegnamentiPostazione object.
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
     * Compares this with another <code>AssegnamentiPostazione</code> instance.  If
     * <code>obj</code> is an instance of <code>AssegnamentiPostazione</code>, delegates to
     * <code>equals(AssegnamentiPostazione)</code>.  Otherwise, returns <code>false</code>.
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
     * @return $this|AssegnamentiPostazione The current object, for fluid interface
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
     * Get the [id_assegnamento_postazione] column value.
     *
     * @return int
     */
    public function getIdAssegnamentoPostazione()
    {
        return $this->id_assegnamento_postazione;
    }

    /**
     * Get the [id_cliente] column value.
     *
     * @return int
     */
    public function getIdCliente()
    {
        return $this->id_cliente;
    }

    /**
     * Get the [id_postazione] column value.
     *
     * @return int
     */
    public function getIdPostazione()
    {
        return $this->id_postazione;
    }

    /**
     * Get the [id_abbonamento] column value.
     *
     * @return int
     */
    public function getIdAbbonamento()
    {
        return $this->id_abbonamento;
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
     * Get the [autorizzati] column value.
     *
     * @return string
     */
    public function getAutorizzati()
    {
        return $this->autorizzati;
    }

    /**
     * Get the [note] column value.
     *
     * @return string
     */
    public function getNote()
    {
        return $this->note;
    }

    /**
     * Set the value of [id_assegnamento_postazione] column.
     *
     * @param int $v new value
     * @return $this|\AssegnamentiPostazione The current object (for fluent API support)
     */
    public function setIdAssegnamentoPostazione($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id_assegnamento_postazione !== $v) {
            $this->id_assegnamento_postazione = $v;
            $this->modifiedColumns[AssegnamentiPostazioneTableMap::COL_ID_ASSEGNAMENTO_POSTAZIONE] = true;
        }

        return $this;
    } // setIdAssegnamentoPostazione()

    /**
     * Set the value of [id_cliente] column.
     *
     * @param int $v new value
     * @return $this|\AssegnamentiPostazione The current object (for fluent API support)
     */
    public function setIdCliente($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id_cliente !== $v) {
            $this->id_cliente = $v;
            $this->modifiedColumns[AssegnamentiPostazioneTableMap::COL_ID_CLIENTE] = true;
        }

        if ($this->aClienti !== null && $this->aClienti->getIdCliente() !== $v) {
            $this->aClienti = null;
        }

        return $this;
    } // setIdCliente()

    /**
     * Set the value of [id_postazione] column.
     *
     * @param int $v new value
     * @return $this|\AssegnamentiPostazione The current object (for fluent API support)
     */
    public function setIdPostazione($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id_postazione !== $v) {
            $this->id_postazione = $v;
            $this->modifiedColumns[AssegnamentiPostazioneTableMap::COL_ID_POSTAZIONE] = true;
        }

        if ($this->aPostazioni !== null && $this->aPostazioni->getIdPostazione() !== $v) {
            $this->aPostazioni = null;
        }

        return $this;
    } // setIdPostazione()

    /**
     * Set the value of [id_abbonamento] column.
     *
     * @param int $v new value
     * @return $this|\AssegnamentiPostazione The current object (for fluent API support)
     */
    public function setIdAbbonamento($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id_abbonamento !== $v) {
            $this->id_abbonamento = $v;
            $this->modifiedColumns[AssegnamentiPostazioneTableMap::COL_ID_ABBONAMENTO] = true;
        }

        if ($this->aAbbonamenti !== null && $this->aAbbonamenti->getIdAbbonamento() !== $v) {
            $this->aAbbonamenti = null;
        }

        return $this;
    } // setIdAbbonamento()

    /**
     * Sets the value of [data_inizio] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTimeInterface value.
     *               Empty strings are treated as NULL.
     * @return $this|\AssegnamentiPostazione The current object (for fluent API support)
     */
    public function setDataInizio($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->data_inizio !== null || $dt !== null) {
            if ($this->data_inizio === null || $dt === null || $dt->format("Y-m-d H:i:s.u") !== $this->data_inizio->format("Y-m-d H:i:s.u")) {
                $this->data_inizio = $dt === null ? null : clone $dt;
                $this->modifiedColumns[AssegnamentiPostazioneTableMap::COL_DATA_INIZIO] = true;
            }
        } // if either are not null

        return $this;
    } // setDataInizio()

    /**
     * Sets the value of [data_fine] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTimeInterface value.
     *               Empty strings are treated as NULL.
     * @return $this|\AssegnamentiPostazione The current object (for fluent API support)
     */
    public function setDataFine($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->data_fine !== null || $dt !== null) {
            if ($this->data_fine === null || $dt === null || $dt->format("Y-m-d H:i:s.u") !== $this->data_fine->format("Y-m-d H:i:s.u")) {
                $this->data_fine = $dt === null ? null : clone $dt;
                $this->modifiedColumns[AssegnamentiPostazioneTableMap::COL_DATA_FINE] = true;
            }
        } // if either are not null

        return $this;
    } // setDataFine()

    /**
     * Set the value of [autorizzati] column.
     *
     * @param string $v new value
     * @return $this|\AssegnamentiPostazione The current object (for fluent API support)
     */
    public function setAutorizzati($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->autorizzati !== $v) {
            $this->autorizzati = $v;
            $this->modifiedColumns[AssegnamentiPostazioneTableMap::COL_AUTORIZZATI] = true;
        }

        return $this;
    } // setAutorizzati()

    /**
     * Set the value of [note] column.
     *
     * @param string $v new value
     * @return $this|\AssegnamentiPostazione The current object (for fluent API support)
     */
    public function setNote($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->note !== $v) {
            $this->note = $v;
            $this->modifiedColumns[AssegnamentiPostazioneTableMap::COL_NOTE] = true;
        }

        return $this;
    } // setNote()

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

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : AssegnamentiPostazioneTableMap::translateFieldName('IdAssegnamentoPostazione', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id_assegnamento_postazione = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : AssegnamentiPostazioneTableMap::translateFieldName('IdCliente', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id_cliente = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : AssegnamentiPostazioneTableMap::translateFieldName('IdPostazione', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id_postazione = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : AssegnamentiPostazioneTableMap::translateFieldName('IdAbbonamento', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id_abbonamento = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : AssegnamentiPostazioneTableMap::translateFieldName('DataInizio', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->data_inizio = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : AssegnamentiPostazioneTableMap::translateFieldName('DataFine', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->data_fine = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 6 + $startcol : AssegnamentiPostazioneTableMap::translateFieldName('Autorizzati', TableMap::TYPE_PHPNAME, $indexType)];
            $this->autorizzati = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 7 + $startcol : AssegnamentiPostazioneTableMap::translateFieldName('Note', TableMap::TYPE_PHPNAME, $indexType)];
            $this->note = (null !== $col) ? (string) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 8; // 8 = AssegnamentiPostazioneTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\AssegnamentiPostazione'), 0, $e);
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
        if ($this->aClienti !== null && $this->id_cliente !== $this->aClienti->getIdCliente()) {
            $this->aClienti = null;
        }
        if ($this->aPostazioni !== null && $this->id_postazione !== $this->aPostazioni->getIdPostazione()) {
            $this->aPostazioni = null;
        }
        if ($this->aAbbonamenti !== null && $this->id_abbonamento !== $this->aAbbonamenti->getIdAbbonamento()) {
            $this->aAbbonamenti = null;
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
            $con = Propel::getServiceContainer()->getReadConnection(AssegnamentiPostazioneTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildAssegnamentiPostazioneQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aPostazioni = null;
            $this->aClienti = null;
            $this->aAbbonamenti = null;
            $this->collDisponibilitaPostaziones = null;

            $this->collServizis = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see AssegnamentiPostazione::setDeleted()
     * @see AssegnamentiPostazione::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(AssegnamentiPostazioneTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildAssegnamentiPostazioneQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(AssegnamentiPostazioneTableMap::DATABASE_NAME);
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
                AssegnamentiPostazioneTableMap::addInstanceToPool($this);
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

            if ($this->aPostazioni !== null) {
                if ($this->aPostazioni->isModified() || $this->aPostazioni->isNew()) {
                    $affectedRows += $this->aPostazioni->save($con);
                }
                $this->setPostazioni($this->aPostazioni);
            }

            if ($this->aClienti !== null) {
                if ($this->aClienti->isModified() || $this->aClienti->isNew()) {
                    $affectedRows += $this->aClienti->save($con);
                }
                $this->setClienti($this->aClienti);
            }

            if ($this->aAbbonamenti !== null) {
                if ($this->aAbbonamenti->isModified() || $this->aAbbonamenti->isNew()) {
                    $affectedRows += $this->aAbbonamenti->save($con);
                }
                $this->setAbbonamenti($this->aAbbonamenti);
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

            if ($this->disponibilitaPostazionesScheduledForDeletion !== null) {
                if (!$this->disponibilitaPostazionesScheduledForDeletion->isEmpty()) {
                    \DisponibilitaPostazioneQuery::create()
                        ->filterByPrimaryKeys($this->disponibilitaPostazionesScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->disponibilitaPostazionesScheduledForDeletion = null;
                }
            }

            if ($this->collDisponibilitaPostaziones !== null) {
                foreach ($this->collDisponibilitaPostaziones as $referrerFK) {
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

        $this->modifiedColumns[AssegnamentiPostazioneTableMap::COL_ID_ASSEGNAMENTO_POSTAZIONE] = true;
        if (null !== $this->id_assegnamento_postazione) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . AssegnamentiPostazioneTableMap::COL_ID_ASSEGNAMENTO_POSTAZIONE . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(AssegnamentiPostazioneTableMap::COL_ID_ASSEGNAMENTO_POSTAZIONE)) {
            $modifiedColumns[':p' . $index++]  = 'id_assegnamento_postazione';
        }
        if ($this->isColumnModified(AssegnamentiPostazioneTableMap::COL_ID_CLIENTE)) {
            $modifiedColumns[':p' . $index++]  = 'id_cliente';
        }
        if ($this->isColumnModified(AssegnamentiPostazioneTableMap::COL_ID_POSTAZIONE)) {
            $modifiedColumns[':p' . $index++]  = 'id_postazione';
        }
        if ($this->isColumnModified(AssegnamentiPostazioneTableMap::COL_ID_ABBONAMENTO)) {
            $modifiedColumns[':p' . $index++]  = 'id_abbonamento';
        }
        if ($this->isColumnModified(AssegnamentiPostazioneTableMap::COL_DATA_INIZIO)) {
            $modifiedColumns[':p' . $index++]  = 'data_inizio';
        }
        if ($this->isColumnModified(AssegnamentiPostazioneTableMap::COL_DATA_FINE)) {
            $modifiedColumns[':p' . $index++]  = 'data_fine';
        }
        if ($this->isColumnModified(AssegnamentiPostazioneTableMap::COL_AUTORIZZATI)) {
            $modifiedColumns[':p' . $index++]  = 'autorizzati';
        }
        if ($this->isColumnModified(AssegnamentiPostazioneTableMap::COL_NOTE)) {
            $modifiedColumns[':p' . $index++]  = 'note';
        }

        $sql = sprintf(
            'INSERT INTO assegnamenti_postazione (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case 'id_assegnamento_postazione':
                        $stmt->bindValue($identifier, $this->id_assegnamento_postazione, PDO::PARAM_INT);
                        break;
                    case 'id_cliente':
                        $stmt->bindValue($identifier, $this->id_cliente, PDO::PARAM_INT);
                        break;
                    case 'id_postazione':
                        $stmt->bindValue($identifier, $this->id_postazione, PDO::PARAM_INT);
                        break;
                    case 'id_abbonamento':
                        $stmt->bindValue($identifier, $this->id_abbonamento, PDO::PARAM_INT);
                        break;
                    case 'data_inizio':
                        $stmt->bindValue($identifier, $this->data_inizio ? $this->data_inizio->format("Y-m-d H:i:s.u") : null, PDO::PARAM_STR);
                        break;
                    case 'data_fine':
                        $stmt->bindValue($identifier, $this->data_fine ? $this->data_fine->format("Y-m-d H:i:s.u") : null, PDO::PARAM_STR);
                        break;
                    case 'autorizzati':
                        $stmt->bindValue($identifier, $this->autorizzati, PDO::PARAM_STR);
                        break;
                    case 'note':
                        $stmt->bindValue($identifier, $this->note, PDO::PARAM_STR);
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
        $this->setIdAssegnamentoPostazione($pk);

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
        $pos = AssegnamentiPostazioneTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getIdAssegnamentoPostazione();
                break;
            case 1:
                return $this->getIdCliente();
                break;
            case 2:
                return $this->getIdPostazione();
                break;
            case 3:
                return $this->getIdAbbonamento();
                break;
            case 4:
                return $this->getDataInizio();
                break;
            case 5:
                return $this->getDataFine();
                break;
            case 6:
                return $this->getAutorizzati();
                break;
            case 7:
                return $this->getNote();
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

        if (isset($alreadyDumpedObjects['AssegnamentiPostazione'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['AssegnamentiPostazione'][$this->hashCode()] = true;
        $keys = AssegnamentiPostazioneTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getIdAssegnamentoPostazione(),
            $keys[1] => $this->getIdCliente(),
            $keys[2] => $this->getIdPostazione(),
            $keys[3] => $this->getIdAbbonamento(),
            $keys[4] => $this->getDataInizio(),
            $keys[5] => $this->getDataFine(),
            $keys[6] => $this->getAutorizzati(),
            $keys[7] => $this->getNote(),
        );
        if ($result[$keys[4]] instanceof \DateTime) {
            $result[$keys[4]] = $result[$keys[4]]->format('c');
        }

        if ($result[$keys[5]] instanceof \DateTime) {
            $result[$keys[5]] = $result[$keys[5]]->format('c');
        }

        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->aPostazioni) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'postazioni';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'postazioni';
                        break;
                    default:
                        $key = 'Postazioni';
                }

                $result[$key] = $this->aPostazioni->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aClienti) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'clienti';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'clienti';
                        break;
                    default:
                        $key = 'Clienti';
                }

                $result[$key] = $this->aClienti->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aAbbonamenti) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'abbonamenti';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'abbonamenti';
                        break;
                    default:
                        $key = 'Abbonamenti';
                }

                $result[$key] = $this->aAbbonamenti->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->collDisponibilitaPostaziones) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'disponibilitaPostaziones';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'disponibilita_postaziones';
                        break;
                    default:
                        $key = 'DisponibilitaPostaziones';
                }

                $result[$key] = $this->collDisponibilitaPostaziones->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
     * @return $this|\AssegnamentiPostazione
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = AssegnamentiPostazioneTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\AssegnamentiPostazione
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setIdAssegnamentoPostazione($value);
                break;
            case 1:
                $this->setIdCliente($value);
                break;
            case 2:
                $this->setIdPostazione($value);
                break;
            case 3:
                $this->setIdAbbonamento($value);
                break;
            case 4:
                $this->setDataInizio($value);
                break;
            case 5:
                $this->setDataFine($value);
                break;
            case 6:
                $this->setAutorizzati($value);
                break;
            case 7:
                $this->setNote($value);
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
        $keys = AssegnamentiPostazioneTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setIdAssegnamentoPostazione($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setIdCliente($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setIdPostazione($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setIdAbbonamento($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setDataInizio($arr[$keys[4]]);
        }
        if (array_key_exists($keys[5], $arr)) {
            $this->setDataFine($arr[$keys[5]]);
        }
        if (array_key_exists($keys[6], $arr)) {
            $this->setAutorizzati($arr[$keys[6]]);
        }
        if (array_key_exists($keys[7], $arr)) {
            $this->setNote($arr[$keys[7]]);
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
     * @return $this|\AssegnamentiPostazione The current object, for fluid interface
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
        $criteria = new Criteria(AssegnamentiPostazioneTableMap::DATABASE_NAME);

        if ($this->isColumnModified(AssegnamentiPostazioneTableMap::COL_ID_ASSEGNAMENTO_POSTAZIONE)) {
            $criteria->add(AssegnamentiPostazioneTableMap::COL_ID_ASSEGNAMENTO_POSTAZIONE, $this->id_assegnamento_postazione);
        }
        if ($this->isColumnModified(AssegnamentiPostazioneTableMap::COL_ID_CLIENTE)) {
            $criteria->add(AssegnamentiPostazioneTableMap::COL_ID_CLIENTE, $this->id_cliente);
        }
        if ($this->isColumnModified(AssegnamentiPostazioneTableMap::COL_ID_POSTAZIONE)) {
            $criteria->add(AssegnamentiPostazioneTableMap::COL_ID_POSTAZIONE, $this->id_postazione);
        }
        if ($this->isColumnModified(AssegnamentiPostazioneTableMap::COL_ID_ABBONAMENTO)) {
            $criteria->add(AssegnamentiPostazioneTableMap::COL_ID_ABBONAMENTO, $this->id_abbonamento);
        }
        if ($this->isColumnModified(AssegnamentiPostazioneTableMap::COL_DATA_INIZIO)) {
            $criteria->add(AssegnamentiPostazioneTableMap::COL_DATA_INIZIO, $this->data_inizio);
        }
        if ($this->isColumnModified(AssegnamentiPostazioneTableMap::COL_DATA_FINE)) {
            $criteria->add(AssegnamentiPostazioneTableMap::COL_DATA_FINE, $this->data_fine);
        }
        if ($this->isColumnModified(AssegnamentiPostazioneTableMap::COL_AUTORIZZATI)) {
            $criteria->add(AssegnamentiPostazioneTableMap::COL_AUTORIZZATI, $this->autorizzati);
        }
        if ($this->isColumnModified(AssegnamentiPostazioneTableMap::COL_NOTE)) {
            $criteria->add(AssegnamentiPostazioneTableMap::COL_NOTE, $this->note);
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
        $criteria = ChildAssegnamentiPostazioneQuery::create();
        $criteria->add(AssegnamentiPostazioneTableMap::COL_ID_ASSEGNAMENTO_POSTAZIONE, $this->id_assegnamento_postazione);

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
        $validPk = null !== $this->getIdAssegnamentoPostazione();

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
        return $this->getIdAssegnamentoPostazione();
    }

    /**
     * Generic method to set the primary key (id_assegnamento_postazione column).
     *
     * @param       int $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setIdAssegnamentoPostazione($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {
        return null === $this->getIdAssegnamentoPostazione();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param      object $copyObj An object of \AssegnamentiPostazione (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setIdCliente($this->getIdCliente());
        $copyObj->setIdPostazione($this->getIdPostazione());
        $copyObj->setIdAbbonamento($this->getIdAbbonamento());
        $copyObj->setDataInizio($this->getDataInizio());
        $copyObj->setDataFine($this->getDataFine());
        $copyObj->setAutorizzati($this->getAutorizzati());
        $copyObj->setNote($this->getNote());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getDisponibilitaPostaziones() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addDisponibilitaPostazione($relObj->copy($deepCopy));
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
            $copyObj->setIdAssegnamentoPostazione(NULL); // this is a auto-increment column, so set to default value
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
     * @return \AssegnamentiPostazione Clone of current object.
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
     * Declares an association between this object and a ChildPostazioni object.
     *
     * @param  ChildPostazioni $v
     * @return $this|\AssegnamentiPostazione The current object (for fluent API support)
     * @throws PropelException
     */
    public function setPostazioni(ChildPostazioni $v = null)
    {
        if ($v === null) {
            $this->setIdPostazione(NULL);
        } else {
            $this->setIdPostazione($v->getIdPostazione());
        }

        $this->aPostazioni = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildPostazioni object, it will not be re-added.
        if ($v !== null) {
            $v->addAssegnamentiPostazione($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildPostazioni object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildPostazioni The associated ChildPostazioni object.
     * @throws PropelException
     */
    public function getPostazioni(ConnectionInterface $con = null)
    {
        if ($this->aPostazioni === null && ($this->id_postazione !== null)) {
            $this->aPostazioni = ChildPostazioniQuery::create()->findPk($this->id_postazione, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aPostazioni->addAssegnamentiPostaziones($this);
             */
        }

        return $this->aPostazioni;
    }

    /**
     * Declares an association between this object and a ChildClienti object.
     *
     * @param  ChildClienti $v
     * @return $this|\AssegnamentiPostazione The current object (for fluent API support)
     * @throws PropelException
     */
    public function setClienti(ChildClienti $v = null)
    {
        if ($v === null) {
            $this->setIdCliente(NULL);
        } else {
            $this->setIdCliente($v->getIdCliente());
        }

        $this->aClienti = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildClienti object, it will not be re-added.
        if ($v !== null) {
            $v->addAssegnamentiPostazione($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildClienti object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildClienti The associated ChildClienti object.
     * @throws PropelException
     */
    public function getClienti(ConnectionInterface $con = null)
    {
        if ($this->aClienti === null && ($this->id_cliente !== null)) {
            $this->aClienti = ChildClientiQuery::create()->findPk($this->id_cliente, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aClienti->addAssegnamentiPostaziones($this);
             */
        }

        return $this->aClienti;
    }

    /**
     * Declares an association between this object and a ChildAbbonamenti object.
     *
     * @param  ChildAbbonamenti $v
     * @return $this|\AssegnamentiPostazione The current object (for fluent API support)
     * @throws PropelException
     */
    public function setAbbonamenti(ChildAbbonamenti $v = null)
    {
        if ($v === null) {
            $this->setIdAbbonamento(NULL);
        } else {
            $this->setIdAbbonamento($v->getIdAbbonamento());
        }

        $this->aAbbonamenti = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildAbbonamenti object, it will not be re-added.
        if ($v !== null) {
            $v->addAssegnamentiPostazione($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildAbbonamenti object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildAbbonamenti The associated ChildAbbonamenti object.
     * @throws PropelException
     */
    public function getAbbonamenti(ConnectionInterface $con = null)
    {
        if ($this->aAbbonamenti === null && ($this->id_abbonamento !== null)) {
            $this->aAbbonamenti = ChildAbbonamentiQuery::create()->findPk($this->id_abbonamento, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aAbbonamenti->addAssegnamentiPostaziones($this);
             */
        }

        return $this->aAbbonamenti;
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
        if ('DisponibilitaPostazione' == $relationName) {
            return $this->initDisponibilitaPostaziones();
        }
        if ('Servizi' == $relationName) {
            return $this->initServizis();
        }
    }

    /**
     * Clears out the collDisponibilitaPostaziones collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addDisponibilitaPostaziones()
     */
    public function clearDisponibilitaPostaziones()
    {
        $this->collDisponibilitaPostaziones = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collDisponibilitaPostaziones collection loaded partially.
     */
    public function resetPartialDisponibilitaPostaziones($v = true)
    {
        $this->collDisponibilitaPostazionesPartial = $v;
    }

    /**
     * Initializes the collDisponibilitaPostaziones collection.
     *
     * By default this just sets the collDisponibilitaPostaziones collection to an empty array (like clearcollDisponibilitaPostaziones());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initDisponibilitaPostaziones($overrideExisting = true)
    {
        if (null !== $this->collDisponibilitaPostaziones && !$overrideExisting) {
            return;
        }

        $collectionClassName = DisponibilitaPostazioneTableMap::getTableMap()->getCollectionClassName();

        $this->collDisponibilitaPostaziones = new $collectionClassName;
        $this->collDisponibilitaPostaziones->setModel('\DisponibilitaPostazione');
    }

    /**
     * Gets an array of ChildDisponibilitaPostazione objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildAssegnamentiPostazione is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildDisponibilitaPostazione[] List of ChildDisponibilitaPostazione objects
     * @throws PropelException
     */
    public function getDisponibilitaPostaziones(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collDisponibilitaPostazionesPartial && !$this->isNew();
        if (null === $this->collDisponibilitaPostaziones || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collDisponibilitaPostaziones) {
                // return empty collection
                $this->initDisponibilitaPostaziones();
            } else {
                $collDisponibilitaPostaziones = ChildDisponibilitaPostazioneQuery::create(null, $criteria)
                    ->filterByAssegnamentiPostazione($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collDisponibilitaPostazionesPartial && count($collDisponibilitaPostaziones)) {
                        $this->initDisponibilitaPostaziones(false);

                        foreach ($collDisponibilitaPostaziones as $obj) {
                            if (false == $this->collDisponibilitaPostaziones->contains($obj)) {
                                $this->collDisponibilitaPostaziones->append($obj);
                            }
                        }

                        $this->collDisponibilitaPostazionesPartial = true;
                    }

                    return $collDisponibilitaPostaziones;
                }

                if ($partial && $this->collDisponibilitaPostaziones) {
                    foreach ($this->collDisponibilitaPostaziones as $obj) {
                        if ($obj->isNew()) {
                            $collDisponibilitaPostaziones[] = $obj;
                        }
                    }
                }

                $this->collDisponibilitaPostaziones = $collDisponibilitaPostaziones;
                $this->collDisponibilitaPostazionesPartial = false;
            }
        }

        return $this->collDisponibilitaPostaziones;
    }

    /**
     * Sets a collection of ChildDisponibilitaPostazione objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $disponibilitaPostaziones A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildAssegnamentiPostazione The current object (for fluent API support)
     */
    public function setDisponibilitaPostaziones(Collection $disponibilitaPostaziones, ConnectionInterface $con = null)
    {
        /** @var ChildDisponibilitaPostazione[] $disponibilitaPostazionesToDelete */
        $disponibilitaPostazionesToDelete = $this->getDisponibilitaPostaziones(new Criteria(), $con)->diff($disponibilitaPostaziones);


        $this->disponibilitaPostazionesScheduledForDeletion = $disponibilitaPostazionesToDelete;

        foreach ($disponibilitaPostazionesToDelete as $disponibilitaPostazioneRemoved) {
            $disponibilitaPostazioneRemoved->setAssegnamentiPostazione(null);
        }

        $this->collDisponibilitaPostaziones = null;
        foreach ($disponibilitaPostaziones as $disponibilitaPostazione) {
            $this->addDisponibilitaPostazione($disponibilitaPostazione);
        }

        $this->collDisponibilitaPostaziones = $disponibilitaPostaziones;
        $this->collDisponibilitaPostazionesPartial = false;

        return $this;
    }

    /**
     * Returns the number of related DisponibilitaPostazione objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related DisponibilitaPostazione objects.
     * @throws PropelException
     */
    public function countDisponibilitaPostaziones(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collDisponibilitaPostazionesPartial && !$this->isNew();
        if (null === $this->collDisponibilitaPostaziones || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collDisponibilitaPostaziones) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getDisponibilitaPostaziones());
            }

            $query = ChildDisponibilitaPostazioneQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByAssegnamentiPostazione($this)
                ->count($con);
        }

        return count($this->collDisponibilitaPostaziones);
    }

    /**
     * Method called to associate a ChildDisponibilitaPostazione object to this object
     * through the ChildDisponibilitaPostazione foreign key attribute.
     *
     * @param  ChildDisponibilitaPostazione $l ChildDisponibilitaPostazione
     * @return $this|\AssegnamentiPostazione The current object (for fluent API support)
     */
    public function addDisponibilitaPostazione(ChildDisponibilitaPostazione $l)
    {
        if ($this->collDisponibilitaPostaziones === null) {
            $this->initDisponibilitaPostaziones();
            $this->collDisponibilitaPostazionesPartial = true;
        }

        if (!$this->collDisponibilitaPostaziones->contains($l)) {
            $this->doAddDisponibilitaPostazione($l);

            if ($this->disponibilitaPostazionesScheduledForDeletion and $this->disponibilitaPostazionesScheduledForDeletion->contains($l)) {
                $this->disponibilitaPostazionesScheduledForDeletion->remove($this->disponibilitaPostazionesScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildDisponibilitaPostazione $disponibilitaPostazione The ChildDisponibilitaPostazione object to add.
     */
    protected function doAddDisponibilitaPostazione(ChildDisponibilitaPostazione $disponibilitaPostazione)
    {
        $this->collDisponibilitaPostaziones[]= $disponibilitaPostazione;
        $disponibilitaPostazione->setAssegnamentiPostazione($this);
    }

    /**
     * @param  ChildDisponibilitaPostazione $disponibilitaPostazione The ChildDisponibilitaPostazione object to remove.
     * @return $this|ChildAssegnamentiPostazione The current object (for fluent API support)
     */
    public function removeDisponibilitaPostazione(ChildDisponibilitaPostazione $disponibilitaPostazione)
    {
        if ($this->getDisponibilitaPostaziones()->contains($disponibilitaPostazione)) {
            $pos = $this->collDisponibilitaPostaziones->search($disponibilitaPostazione);
            $this->collDisponibilitaPostaziones->remove($pos);
            if (null === $this->disponibilitaPostazionesScheduledForDeletion) {
                $this->disponibilitaPostazionesScheduledForDeletion = clone $this->collDisponibilitaPostaziones;
                $this->disponibilitaPostazionesScheduledForDeletion->clear();
            }
            $this->disponibilitaPostazionesScheduledForDeletion[]= clone $disponibilitaPostazione;
            $disponibilitaPostazione->setAssegnamentiPostazione(null);
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
     * If this ChildAssegnamentiPostazione is new, it will return
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
                    ->filterByAssegnamentiPostazione($this)
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
     * @return $this|ChildAssegnamentiPostazione The current object (for fluent API support)
     */
    public function setServizis(Collection $servizis, ConnectionInterface $con = null)
    {
        /** @var ChildServizi[] $servizisToDelete */
        $servizisToDelete = $this->getServizis(new Criteria(), $con)->diff($servizis);


        $this->servizisScheduledForDeletion = $servizisToDelete;

        foreach ($servizisToDelete as $serviziRemoved) {
            $serviziRemoved->setAssegnamentiPostazione(null);
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
                ->filterByAssegnamentiPostazione($this)
                ->count($con);
        }

        return count($this->collServizis);
    }

    /**
     * Method called to associate a ChildServizi object to this object
     * through the ChildServizi foreign key attribute.
     *
     * @param  ChildServizi $l ChildServizi
     * @return $this|\AssegnamentiPostazione The current object (for fluent API support)
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
        $servizi->setAssegnamentiPostazione($this);
    }

    /**
     * @param  ChildServizi $servizi The ChildServizi object to remove.
     * @return $this|ChildAssegnamentiPostazione The current object (for fluent API support)
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
            $servizi->setAssegnamentiPostazione(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this AssegnamentiPostazione is new, it will return
     * an empty collection; or if this AssegnamentiPostazione has previously
     * been saved, it will retrieve related Servizis from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in AssegnamentiPostazione.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildServizi[] List of ChildServizi objects
     */
    public function getServizisJoinTipiServizio(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildServiziQuery::create(null, $criteria);
        $query->joinWith('TipiServizio', $joinBehavior);

        return $this->getServizis($query, $con);
    }

    /**
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear()
    {
        if (null !== $this->aPostazioni) {
            $this->aPostazioni->removeAssegnamentiPostazione($this);
        }
        if (null !== $this->aClienti) {
            $this->aClienti->removeAssegnamentiPostazione($this);
        }
        if (null !== $this->aAbbonamenti) {
            $this->aAbbonamenti->removeAssegnamentiPostazione($this);
        }
        $this->id_assegnamento_postazione = null;
        $this->id_cliente = null;
        $this->id_postazione = null;
        $this->id_abbonamento = null;
        $this->data_inizio = null;
        $this->data_fine = null;
        $this->autorizzati = null;
        $this->note = null;
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
            if ($this->collDisponibilitaPostaziones) {
                foreach ($this->collDisponibilitaPostaziones as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collServizis) {
                foreach ($this->collServizis as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collDisponibilitaPostaziones = null;
        $this->collServizis = null;
        $this->aPostazioni = null;
        $this->aClienti = null;
        $this->aAbbonamenti = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(AssegnamentiPostazioneTableMap::DEFAULT_STRING_FORMAT);
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
