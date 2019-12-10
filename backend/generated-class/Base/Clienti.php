<?php

namespace Base;

use \Account as ChildAccount;
use \AccountQuery as ChildAccountQuery;
use \AssegnamentiPostazione as ChildAssegnamentiPostazione;
use \AssegnamentiPostazioneQuery as ChildAssegnamentiPostazioneQuery;
use \Clienti as ChildClienti;
use \ClientiQuery as ChildClientiQuery;
use \Pagamenti as ChildPagamenti;
use \PagamentiQuery as ChildPagamentiQuery;
use \Schede as ChildSchede;
use \SchedeQuery as ChildSchedeQuery;
use \Exception;
use \PDO;
use Map\AccountTableMap;
use Map\AssegnamentiPostazioneTableMap;
use Map\ClientiTableMap;
use Map\PagamentiTableMap;
use Map\SchedeTableMap;
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
 * Base class that represents a row from the 'clienti' table.
 *
 *
 *
 * @package    propel.generator..Base
 */
abstract class Clienti implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\Map\\ClientiTableMap';


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
     * The value for the id_cliente field.
     *
     * @var        int
     */
    protected $id_cliente;

    /**
     * The value for the da_saldare field.
     *
     * @var        string
     */
    protected $da_saldare;

    /**
     * The value for the note field.
     *
     * @var        string
     */
    protected $note;

    /**
     * The value for the indirizzo field.
     *
     * @var        string
     */
    protected $indirizzo;

    /**
     * The value for the cap field.
     *
     * @var        string
     */
    protected $cap;

    /**
     * The value for the citta field.
     *
     * @var        string
     */
    protected $citta;

    /**
     * The value for the provincia field.
     *
     * @var        string
     */
    protected $provincia;

    /**
     * The value for the stato field.
     *
     * @var        string
     */
    protected $stato;

    /**
     * The value for the codice_fiscale field.
     *
     * @var        string
     */
    protected $codice_fiscale;

    /**
     * @var        ObjectCollection|ChildAccount[] Collection to store aggregation of ChildAccount objects.
     */
    protected $collAccounts;
    protected $collAccountsPartial;

    /**
     * @var        ObjectCollection|ChildAssegnamentiPostazione[] Collection to store aggregation of ChildAssegnamentiPostazione objects.
     */
    protected $collAssegnamentiPostaziones;
    protected $collAssegnamentiPostazionesPartial;

    /**
     * @var        ObjectCollection|ChildPagamenti[] Collection to store aggregation of ChildPagamenti objects.
     */
    protected $collPagamentis;
    protected $collPagamentisPartial;

    /**
     * @var        ObjectCollection|ChildSchede[] Collection to store aggregation of ChildSchede objects.
     */
    protected $collSchedes;
    protected $collSchedesPartial;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildAccount[]
     */
    protected $accountsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildAssegnamentiPostazione[]
     */
    protected $assegnamentiPostazionesScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildPagamenti[]
     */
    protected $pagamentisScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildSchede[]
     */
    protected $schedesScheduledForDeletion = null;

    /**
     * Initializes internal state of Base\Clienti object.
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
     * Compares this with another <code>Clienti</code> instance.  If
     * <code>obj</code> is an instance of <code>Clienti</code>, delegates to
     * <code>equals(Clienti)</code>.  Otherwise, returns <code>false</code>.
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
     * @return $this|Clienti The current object, for fluid interface
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
     * Get the [id_cliente] column value.
     *
     * @return int
     */
    public function getIdCliente()
    {
        return $this->id_cliente;
    }

    /**
     * Get the [da_saldare] column value.
     *
     * @return string
     */
    public function getDaSaldare()
    {
        return $this->da_saldare;
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
     * Get the [indirizzo] column value.
     *
     * @return string
     */
    public function getIndirizzo()
    {
        return $this->indirizzo;
    }

    /**
     * Get the [cap] column value.
     *
     * @return string
     */
    public function getCap()
    {
        return $this->cap;
    }

    /**
     * Get the [citta] column value.
     *
     * @return string
     */
    public function getCitta()
    {
        return $this->citta;
    }

    /**
     * Get the [provincia] column value.
     *
     * @return string
     */
    public function getProvincia()
    {
        return $this->provincia;
    }

    /**
     * Get the [stato] column value.
     *
     * @return string
     */
    public function getStato()
    {
        return $this->stato;
    }

    /**
     * Get the [codice_fiscale] column value.
     *
     * @return string
     */
    public function getCodiceFiscale()
    {
        return $this->codice_fiscale;
    }

    /**
     * Set the value of [id_cliente] column.
     *
     * @param int $v new value
     * @return $this|\Clienti The current object (for fluent API support)
     */
    public function setIdCliente($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id_cliente !== $v) {
            $this->id_cliente = $v;
            $this->modifiedColumns[ClientiTableMap::COL_ID_CLIENTE] = true;
        }

        return $this;
    } // setIdCliente()

    /**
     * Set the value of [da_saldare] column.
     *
     * @param string $v new value
     * @return $this|\Clienti The current object (for fluent API support)
     */
    public function setDaSaldare($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->da_saldare !== $v) {
            $this->da_saldare = $v;
            $this->modifiedColumns[ClientiTableMap::COL_DA_SALDARE] = true;
        }

        return $this;
    } // setDaSaldare()

    /**
     * Set the value of [note] column.
     *
     * @param string $v new value
     * @return $this|\Clienti The current object (for fluent API support)
     */
    public function setNote($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->note !== $v) {
            $this->note = $v;
            $this->modifiedColumns[ClientiTableMap::COL_NOTE] = true;
        }

        return $this;
    } // setNote()

    /**
     * Set the value of [indirizzo] column.
     *
     * @param string $v new value
     * @return $this|\Clienti The current object (for fluent API support)
     */
    public function setIndirizzo($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->indirizzo !== $v) {
            $this->indirizzo = $v;
            $this->modifiedColumns[ClientiTableMap::COL_INDIRIZZO] = true;
        }

        return $this;
    } // setIndirizzo()

    /**
     * Set the value of [cap] column.
     *
     * @param string $v new value
     * @return $this|\Clienti The current object (for fluent API support)
     */
    public function setCap($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->cap !== $v) {
            $this->cap = $v;
            $this->modifiedColumns[ClientiTableMap::COL_CAP] = true;
        }

        return $this;
    } // setCap()

    /**
     * Set the value of [citta] column.
     *
     * @param string $v new value
     * @return $this|\Clienti The current object (for fluent API support)
     */
    public function setCitta($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->citta !== $v) {
            $this->citta = $v;
            $this->modifiedColumns[ClientiTableMap::COL_CITTA] = true;
        }

        return $this;
    } // setCitta()

    /**
     * Set the value of [provincia] column.
     *
     * @param string $v new value
     * @return $this|\Clienti The current object (for fluent API support)
     */
    public function setProvincia($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->provincia !== $v) {
            $this->provincia = $v;
            $this->modifiedColumns[ClientiTableMap::COL_PROVINCIA] = true;
        }

        return $this;
    } // setProvincia()

    /**
     * Set the value of [stato] column.
     *
     * @param string $v new value
     * @return $this|\Clienti The current object (for fluent API support)
     */
    public function setStato($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->stato !== $v) {
            $this->stato = $v;
            $this->modifiedColumns[ClientiTableMap::COL_STATO] = true;
        }

        return $this;
    } // setStato()

    /**
     * Set the value of [codice_fiscale] column.
     *
     * @param string $v new value
     * @return $this|\Clienti The current object (for fluent API support)
     */
    public function setCodiceFiscale($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->codice_fiscale !== $v) {
            $this->codice_fiscale = $v;
            $this->modifiedColumns[ClientiTableMap::COL_CODICE_FISCALE] = true;
        }

        return $this;
    } // setCodiceFiscale()

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

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : ClientiTableMap::translateFieldName('IdCliente', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id_cliente = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : ClientiTableMap::translateFieldName('DaSaldare', TableMap::TYPE_PHPNAME, $indexType)];
            $this->da_saldare = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : ClientiTableMap::translateFieldName('Note', TableMap::TYPE_PHPNAME, $indexType)];
            $this->note = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : ClientiTableMap::translateFieldName('Indirizzo', TableMap::TYPE_PHPNAME, $indexType)];
            $this->indirizzo = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : ClientiTableMap::translateFieldName('Cap', TableMap::TYPE_PHPNAME, $indexType)];
            $this->cap = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : ClientiTableMap::translateFieldName('Citta', TableMap::TYPE_PHPNAME, $indexType)];
            $this->citta = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 6 + $startcol : ClientiTableMap::translateFieldName('Provincia', TableMap::TYPE_PHPNAME, $indexType)];
            $this->provincia = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 7 + $startcol : ClientiTableMap::translateFieldName('Stato', TableMap::TYPE_PHPNAME, $indexType)];
            $this->stato = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 8 + $startcol : ClientiTableMap::translateFieldName('CodiceFiscale', TableMap::TYPE_PHPNAME, $indexType)];
            $this->codice_fiscale = (null !== $col) ? (string) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 9; // 9 = ClientiTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\Clienti'), 0, $e);
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
            $con = Propel::getServiceContainer()->getReadConnection(ClientiTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildClientiQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->collAccounts = null;

            $this->collAssegnamentiPostaziones = null;

            $this->collPagamentis = null;

            $this->collSchedes = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see Clienti::setDeleted()
     * @see Clienti::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(ClientiTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildClientiQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(ClientiTableMap::DATABASE_NAME);
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
                ClientiTableMap::addInstanceToPool($this);
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

            if ($this->accountsScheduledForDeletion !== null) {
                if (!$this->accountsScheduledForDeletion->isEmpty()) {
                    foreach ($this->accountsScheduledForDeletion as $account) {
                        // need to save related object because we set the relation to null
                        $account->save($con);
                    }
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

            if ($this->assegnamentiPostazionesScheduledForDeletion !== null) {
                if (!$this->assegnamentiPostazionesScheduledForDeletion->isEmpty()) {
                    \AssegnamentiPostazioneQuery::create()
                        ->filterByPrimaryKeys($this->assegnamentiPostazionesScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->assegnamentiPostazionesScheduledForDeletion = null;
                }
            }

            if ($this->collAssegnamentiPostaziones !== null) {
                foreach ($this->collAssegnamentiPostaziones as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->pagamentisScheduledForDeletion !== null) {
                if (!$this->pagamentisScheduledForDeletion->isEmpty()) {
                    \PagamentiQuery::create()
                        ->filterByPrimaryKeys($this->pagamentisScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->pagamentisScheduledForDeletion = null;
                }
            }

            if ($this->collPagamentis !== null) {
                foreach ($this->collPagamentis as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->schedesScheduledForDeletion !== null) {
                if (!$this->schedesScheduledForDeletion->isEmpty()) {
                    foreach ($this->schedesScheduledForDeletion as $schede) {
                        // need to save related object because we set the relation to null
                        $schede->save($con);
                    }
                    $this->schedesScheduledForDeletion = null;
                }
            }

            if ($this->collSchedes !== null) {
                foreach ($this->collSchedes as $referrerFK) {
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

        $this->modifiedColumns[ClientiTableMap::COL_ID_CLIENTE] = true;
        if (null !== $this->id_cliente) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . ClientiTableMap::COL_ID_CLIENTE . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(ClientiTableMap::COL_ID_CLIENTE)) {
            $modifiedColumns[':p' . $index++]  = 'id_cliente';
        }
        if ($this->isColumnModified(ClientiTableMap::COL_DA_SALDARE)) {
            $modifiedColumns[':p' . $index++]  = 'da_saldare';
        }
        if ($this->isColumnModified(ClientiTableMap::COL_NOTE)) {
            $modifiedColumns[':p' . $index++]  = 'note';
        }
        if ($this->isColumnModified(ClientiTableMap::COL_INDIRIZZO)) {
            $modifiedColumns[':p' . $index++]  = 'indirizzo';
        }
        if ($this->isColumnModified(ClientiTableMap::COL_CAP)) {
            $modifiedColumns[':p' . $index++]  = 'cap';
        }
        if ($this->isColumnModified(ClientiTableMap::COL_CITTA)) {
            $modifiedColumns[':p' . $index++]  = 'citta';
        }
        if ($this->isColumnModified(ClientiTableMap::COL_PROVINCIA)) {
            $modifiedColumns[':p' . $index++]  = 'provincia';
        }
        if ($this->isColumnModified(ClientiTableMap::COL_STATO)) {
            $modifiedColumns[':p' . $index++]  = 'stato';
        }
        if ($this->isColumnModified(ClientiTableMap::COL_CODICE_FISCALE)) {
            $modifiedColumns[':p' . $index++]  = 'codice_fiscale';
        }

        $sql = sprintf(
            'INSERT INTO clienti (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case 'id_cliente':
                        $stmt->bindValue($identifier, $this->id_cliente, PDO::PARAM_INT);
                        break;
                    case 'da_saldare':
                        $stmt->bindValue($identifier, $this->da_saldare, PDO::PARAM_STR);
                        break;
                    case 'note':
                        $stmt->bindValue($identifier, $this->note, PDO::PARAM_STR);
                        break;
                    case 'indirizzo':
                        $stmt->bindValue($identifier, $this->indirizzo, PDO::PARAM_STR);
                        break;
                    case 'cap':
                        $stmt->bindValue($identifier, $this->cap, PDO::PARAM_STR);
                        break;
                    case 'citta':
                        $stmt->bindValue($identifier, $this->citta, PDO::PARAM_STR);
                        break;
                    case 'provincia':
                        $stmt->bindValue($identifier, $this->provincia, PDO::PARAM_STR);
                        break;
                    case 'stato':
                        $stmt->bindValue($identifier, $this->stato, PDO::PARAM_STR);
                        break;
                    case 'codice_fiscale':
                        $stmt->bindValue($identifier, $this->codice_fiscale, PDO::PARAM_STR);
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
        $this->setIdCliente($pk);

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
        $pos = ClientiTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getIdCliente();
                break;
            case 1:
                return $this->getDaSaldare();
                break;
            case 2:
                return $this->getNote();
                break;
            case 3:
                return $this->getIndirizzo();
                break;
            case 4:
                return $this->getCap();
                break;
            case 5:
                return $this->getCitta();
                break;
            case 6:
                return $this->getProvincia();
                break;
            case 7:
                return $this->getStato();
                break;
            case 8:
                return $this->getCodiceFiscale();
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

        if (isset($alreadyDumpedObjects['Clienti'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Clienti'][$this->hashCode()] = true;
        $keys = ClientiTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getIdCliente(),
            $keys[1] => $this->getDaSaldare(),
            $keys[2] => $this->getNote(),
            $keys[3] => $this->getIndirizzo(),
            $keys[4] => $this->getCap(),
            $keys[5] => $this->getCitta(),
            $keys[6] => $this->getProvincia(),
            $keys[7] => $this->getStato(),
            $keys[8] => $this->getCodiceFiscale(),
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
            if (null !== $this->collAssegnamentiPostaziones) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'assegnamentiPostaziones';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'assegnamenti_postaziones';
                        break;
                    default:
                        $key = 'AssegnamentiPostaziones';
                }

                $result[$key] = $this->collAssegnamentiPostaziones->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collPagamentis) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'pagamentis';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'pagamentis';
                        break;
                    default:
                        $key = 'Pagamentis';
                }

                $result[$key] = $this->collPagamentis->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collSchedes) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'schedes';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'schedes';
                        break;
                    default:
                        $key = 'Schedes';
                }

                $result[$key] = $this->collSchedes->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
     * @return $this|\Clienti
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = ClientiTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\Clienti
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setIdCliente($value);
                break;
            case 1:
                $this->setDaSaldare($value);
                break;
            case 2:
                $this->setNote($value);
                break;
            case 3:
                $this->setIndirizzo($value);
                break;
            case 4:
                $this->setCap($value);
                break;
            case 5:
                $this->setCitta($value);
                break;
            case 6:
                $this->setProvincia($value);
                break;
            case 7:
                $this->setStato($value);
                break;
            case 8:
                $this->setCodiceFiscale($value);
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
        $keys = ClientiTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setIdCliente($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setDaSaldare($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setNote($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setIndirizzo($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setCap($arr[$keys[4]]);
        }
        if (array_key_exists($keys[5], $arr)) {
            $this->setCitta($arr[$keys[5]]);
        }
        if (array_key_exists($keys[6], $arr)) {
            $this->setProvincia($arr[$keys[6]]);
        }
        if (array_key_exists($keys[7], $arr)) {
            $this->setStato($arr[$keys[7]]);
        }
        if (array_key_exists($keys[8], $arr)) {
            $this->setCodiceFiscale($arr[$keys[8]]);
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
     * @return $this|\Clienti The current object, for fluid interface
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
        $criteria = new Criteria(ClientiTableMap::DATABASE_NAME);

        if ($this->isColumnModified(ClientiTableMap::COL_ID_CLIENTE)) {
            $criteria->add(ClientiTableMap::COL_ID_CLIENTE, $this->id_cliente);
        }
        if ($this->isColumnModified(ClientiTableMap::COL_DA_SALDARE)) {
            $criteria->add(ClientiTableMap::COL_DA_SALDARE, $this->da_saldare);
        }
        if ($this->isColumnModified(ClientiTableMap::COL_NOTE)) {
            $criteria->add(ClientiTableMap::COL_NOTE, $this->note);
        }
        if ($this->isColumnModified(ClientiTableMap::COL_INDIRIZZO)) {
            $criteria->add(ClientiTableMap::COL_INDIRIZZO, $this->indirizzo);
        }
        if ($this->isColumnModified(ClientiTableMap::COL_CAP)) {
            $criteria->add(ClientiTableMap::COL_CAP, $this->cap);
        }
        if ($this->isColumnModified(ClientiTableMap::COL_CITTA)) {
            $criteria->add(ClientiTableMap::COL_CITTA, $this->citta);
        }
        if ($this->isColumnModified(ClientiTableMap::COL_PROVINCIA)) {
            $criteria->add(ClientiTableMap::COL_PROVINCIA, $this->provincia);
        }
        if ($this->isColumnModified(ClientiTableMap::COL_STATO)) {
            $criteria->add(ClientiTableMap::COL_STATO, $this->stato);
        }
        if ($this->isColumnModified(ClientiTableMap::COL_CODICE_FISCALE)) {
            $criteria->add(ClientiTableMap::COL_CODICE_FISCALE, $this->codice_fiscale);
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
        $criteria = ChildClientiQuery::create();
        $criteria->add(ClientiTableMap::COL_ID_CLIENTE, $this->id_cliente);

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
        $validPk = null !== $this->getIdCliente();

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
        return $this->getIdCliente();
    }

    /**
     * Generic method to set the primary key (id_cliente column).
     *
     * @param       int $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setIdCliente($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {
        return null === $this->getIdCliente();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param      object $copyObj An object of \Clienti (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setDaSaldare($this->getDaSaldare());
        $copyObj->setNote($this->getNote());
        $copyObj->setIndirizzo($this->getIndirizzo());
        $copyObj->setCap($this->getCap());
        $copyObj->setCitta($this->getCitta());
        $copyObj->setProvincia($this->getProvincia());
        $copyObj->setStato($this->getStato());
        $copyObj->setCodiceFiscale($this->getCodiceFiscale());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getAccounts() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addAccount($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getAssegnamentiPostaziones() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addAssegnamentiPostazione($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getPagamentis() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addPagamenti($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getSchedes() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addSchede($relObj->copy($deepCopy));
                }
            }

        } // if ($deepCopy)

        if ($makeNew) {
            $copyObj->setNew(true);
            $copyObj->setIdCliente(NULL); // this is a auto-increment column, so set to default value
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
     * @return \Clienti Clone of current object.
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
        if ('AssegnamentiPostazione' == $relationName) {
            return $this->initAssegnamentiPostaziones();
        }
        if ('Pagamenti' == $relationName) {
            return $this->initPagamentis();
        }
        if ('Schede' == $relationName) {
            return $this->initSchedes();
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
     * If this ChildClienti is new, it will return
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
                    ->filterByClienti($this)
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
     * @return $this|ChildClienti The current object (for fluent API support)
     */
    public function setAccounts(Collection $accounts, ConnectionInterface $con = null)
    {
        /** @var ChildAccount[] $accountsToDelete */
        $accountsToDelete = $this->getAccounts(new Criteria(), $con)->diff($accounts);


        $this->accountsScheduledForDeletion = $accountsToDelete;

        foreach ($accountsToDelete as $accountRemoved) {
            $accountRemoved->setClienti(null);
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
                ->filterByClienti($this)
                ->count($con);
        }

        return count($this->collAccounts);
    }

    /**
     * Method called to associate a ChildAccount object to this object
     * through the ChildAccount foreign key attribute.
     *
     * @param  ChildAccount $l ChildAccount
     * @return $this|\Clienti The current object (for fluent API support)
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
        $account->setClienti($this);
    }

    /**
     * @param  ChildAccount $account The ChildAccount object to remove.
     * @return $this|ChildClienti The current object (for fluent API support)
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
            $this->accountsScheduledForDeletion[]= $account;
            $account->setClienti(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Clienti is new, it will return
     * an empty collection; or if this Clienti has previously
     * been saved, it will retrieve related Accounts from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Clienti.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildAccount[] List of ChildAccount objects
     */
    public function getAccountsJoinProfili(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildAccountQuery::create(null, $criteria);
        $query->joinWith('Profili', $joinBehavior);

        return $this->getAccounts($query, $con);
    }

    /**
     * Clears out the collAssegnamentiPostaziones collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addAssegnamentiPostaziones()
     */
    public function clearAssegnamentiPostaziones()
    {
        $this->collAssegnamentiPostaziones = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collAssegnamentiPostaziones collection loaded partially.
     */
    public function resetPartialAssegnamentiPostaziones($v = true)
    {
        $this->collAssegnamentiPostazionesPartial = $v;
    }

    /**
     * Initializes the collAssegnamentiPostaziones collection.
     *
     * By default this just sets the collAssegnamentiPostaziones collection to an empty array (like clearcollAssegnamentiPostaziones());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initAssegnamentiPostaziones($overrideExisting = true)
    {
        if (null !== $this->collAssegnamentiPostaziones && !$overrideExisting) {
            return;
        }

        $collectionClassName = AssegnamentiPostazioneTableMap::getTableMap()->getCollectionClassName();

        $this->collAssegnamentiPostaziones = new $collectionClassName;
        $this->collAssegnamentiPostaziones->setModel('\AssegnamentiPostazione');
    }

    /**
     * Gets an array of ChildAssegnamentiPostazione objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildClienti is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildAssegnamentiPostazione[] List of ChildAssegnamentiPostazione objects
     * @throws PropelException
     */
    public function getAssegnamentiPostaziones(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collAssegnamentiPostazionesPartial && !$this->isNew();
        if (null === $this->collAssegnamentiPostaziones || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collAssegnamentiPostaziones) {
                // return empty collection
                $this->initAssegnamentiPostaziones();
            } else {
                $collAssegnamentiPostaziones = ChildAssegnamentiPostazioneQuery::create(null, $criteria)
                    ->filterByClienti($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collAssegnamentiPostazionesPartial && count($collAssegnamentiPostaziones)) {
                        $this->initAssegnamentiPostaziones(false);

                        foreach ($collAssegnamentiPostaziones as $obj) {
                            if (false == $this->collAssegnamentiPostaziones->contains($obj)) {
                                $this->collAssegnamentiPostaziones->append($obj);
                            }
                        }

                        $this->collAssegnamentiPostazionesPartial = true;
                    }

                    return $collAssegnamentiPostaziones;
                }

                if ($partial && $this->collAssegnamentiPostaziones) {
                    foreach ($this->collAssegnamentiPostaziones as $obj) {
                        if ($obj->isNew()) {
                            $collAssegnamentiPostaziones[] = $obj;
                        }
                    }
                }

                $this->collAssegnamentiPostaziones = $collAssegnamentiPostaziones;
                $this->collAssegnamentiPostazionesPartial = false;
            }
        }

        return $this->collAssegnamentiPostaziones;
    }

    /**
     * Sets a collection of ChildAssegnamentiPostazione objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $assegnamentiPostaziones A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildClienti The current object (for fluent API support)
     */
    public function setAssegnamentiPostaziones(Collection $assegnamentiPostaziones, ConnectionInterface $con = null)
    {
        /** @var ChildAssegnamentiPostazione[] $assegnamentiPostazionesToDelete */
        $assegnamentiPostazionesToDelete = $this->getAssegnamentiPostaziones(new Criteria(), $con)->diff($assegnamentiPostaziones);


        $this->assegnamentiPostazionesScheduledForDeletion = $assegnamentiPostazionesToDelete;

        foreach ($assegnamentiPostazionesToDelete as $assegnamentiPostazioneRemoved) {
            $assegnamentiPostazioneRemoved->setClienti(null);
        }

        $this->collAssegnamentiPostaziones = null;
        foreach ($assegnamentiPostaziones as $assegnamentiPostazione) {
            $this->addAssegnamentiPostazione($assegnamentiPostazione);
        }

        $this->collAssegnamentiPostaziones = $assegnamentiPostaziones;
        $this->collAssegnamentiPostazionesPartial = false;

        return $this;
    }

    /**
     * Returns the number of related AssegnamentiPostazione objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related AssegnamentiPostazione objects.
     * @throws PropelException
     */
    public function countAssegnamentiPostaziones(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collAssegnamentiPostazionesPartial && !$this->isNew();
        if (null === $this->collAssegnamentiPostaziones || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collAssegnamentiPostaziones) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getAssegnamentiPostaziones());
            }

            $query = ChildAssegnamentiPostazioneQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByClienti($this)
                ->count($con);
        }

        return count($this->collAssegnamentiPostaziones);
    }

    /**
     * Method called to associate a ChildAssegnamentiPostazione object to this object
     * through the ChildAssegnamentiPostazione foreign key attribute.
     *
     * @param  ChildAssegnamentiPostazione $l ChildAssegnamentiPostazione
     * @return $this|\Clienti The current object (for fluent API support)
     */
    public function addAssegnamentiPostazione(ChildAssegnamentiPostazione $l)
    {
        if ($this->collAssegnamentiPostaziones === null) {
            $this->initAssegnamentiPostaziones();
            $this->collAssegnamentiPostazionesPartial = true;
        }

        if (!$this->collAssegnamentiPostaziones->contains($l)) {
            $this->doAddAssegnamentiPostazione($l);

            if ($this->assegnamentiPostazionesScheduledForDeletion and $this->assegnamentiPostazionesScheduledForDeletion->contains($l)) {
                $this->assegnamentiPostazionesScheduledForDeletion->remove($this->assegnamentiPostazionesScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildAssegnamentiPostazione $assegnamentiPostazione The ChildAssegnamentiPostazione object to add.
     */
    protected function doAddAssegnamentiPostazione(ChildAssegnamentiPostazione $assegnamentiPostazione)
    {
        $this->collAssegnamentiPostaziones[]= $assegnamentiPostazione;
        $assegnamentiPostazione->setClienti($this);
    }

    /**
     * @param  ChildAssegnamentiPostazione $assegnamentiPostazione The ChildAssegnamentiPostazione object to remove.
     * @return $this|ChildClienti The current object (for fluent API support)
     */
    public function removeAssegnamentiPostazione(ChildAssegnamentiPostazione $assegnamentiPostazione)
    {
        if ($this->getAssegnamentiPostaziones()->contains($assegnamentiPostazione)) {
            $pos = $this->collAssegnamentiPostaziones->search($assegnamentiPostazione);
            $this->collAssegnamentiPostaziones->remove($pos);
            if (null === $this->assegnamentiPostazionesScheduledForDeletion) {
                $this->assegnamentiPostazionesScheduledForDeletion = clone $this->collAssegnamentiPostaziones;
                $this->assegnamentiPostazionesScheduledForDeletion->clear();
            }
            $this->assegnamentiPostazionesScheduledForDeletion[]= clone $assegnamentiPostazione;
            $assegnamentiPostazione->setClienti(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Clienti is new, it will return
     * an empty collection; or if this Clienti has previously
     * been saved, it will retrieve related AssegnamentiPostaziones from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Clienti.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildAssegnamentiPostazione[] List of ChildAssegnamentiPostazione objects
     */
    public function getAssegnamentiPostazionesJoinPostazioni(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildAssegnamentiPostazioneQuery::create(null, $criteria);
        $query->joinWith('Postazioni', $joinBehavior);

        return $this->getAssegnamentiPostaziones($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Clienti is new, it will return
     * an empty collection; or if this Clienti has previously
     * been saved, it will retrieve related AssegnamentiPostaziones from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Clienti.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildAssegnamentiPostazione[] List of ChildAssegnamentiPostazione objects
     */
    public function getAssegnamentiPostazionesJoinAbbonamenti(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildAssegnamentiPostazioneQuery::create(null, $criteria);
        $query->joinWith('Abbonamenti', $joinBehavior);

        return $this->getAssegnamentiPostaziones($query, $con);
    }

    /**
     * Clears out the collPagamentis collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addPagamentis()
     */
    public function clearPagamentis()
    {
        $this->collPagamentis = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collPagamentis collection loaded partially.
     */
    public function resetPartialPagamentis($v = true)
    {
        $this->collPagamentisPartial = $v;
    }

    /**
     * Initializes the collPagamentis collection.
     *
     * By default this just sets the collPagamentis collection to an empty array (like clearcollPagamentis());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initPagamentis($overrideExisting = true)
    {
        if (null !== $this->collPagamentis && !$overrideExisting) {
            return;
        }

        $collectionClassName = PagamentiTableMap::getTableMap()->getCollectionClassName();

        $this->collPagamentis = new $collectionClassName;
        $this->collPagamentis->setModel('\Pagamenti');
    }

    /**
     * Gets an array of ChildPagamenti objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildClienti is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildPagamenti[] List of ChildPagamenti objects
     * @throws PropelException
     */
    public function getPagamentis(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collPagamentisPartial && !$this->isNew();
        if (null === $this->collPagamentis || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collPagamentis) {
                // return empty collection
                $this->initPagamentis();
            } else {
                $collPagamentis = ChildPagamentiQuery::create(null, $criteria)
                    ->filterByClienti($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collPagamentisPartial && count($collPagamentis)) {
                        $this->initPagamentis(false);

                        foreach ($collPagamentis as $obj) {
                            if (false == $this->collPagamentis->contains($obj)) {
                                $this->collPagamentis->append($obj);
                            }
                        }

                        $this->collPagamentisPartial = true;
                    }

                    return $collPagamentis;
                }

                if ($partial && $this->collPagamentis) {
                    foreach ($this->collPagamentis as $obj) {
                        if ($obj->isNew()) {
                            $collPagamentis[] = $obj;
                        }
                    }
                }

                $this->collPagamentis = $collPagamentis;
                $this->collPagamentisPartial = false;
            }
        }

        return $this->collPagamentis;
    }

    /**
     * Sets a collection of ChildPagamenti objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $pagamentis A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildClienti The current object (for fluent API support)
     */
    public function setPagamentis(Collection $pagamentis, ConnectionInterface $con = null)
    {
        /** @var ChildPagamenti[] $pagamentisToDelete */
        $pagamentisToDelete = $this->getPagamentis(new Criteria(), $con)->diff($pagamentis);


        $this->pagamentisScheduledForDeletion = $pagamentisToDelete;

        foreach ($pagamentisToDelete as $pagamentiRemoved) {
            $pagamentiRemoved->setClienti(null);
        }

        $this->collPagamentis = null;
        foreach ($pagamentis as $pagamenti) {
            $this->addPagamenti($pagamenti);
        }

        $this->collPagamentis = $pagamentis;
        $this->collPagamentisPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Pagamenti objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Pagamenti objects.
     * @throws PropelException
     */
    public function countPagamentis(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collPagamentisPartial && !$this->isNew();
        if (null === $this->collPagamentis || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collPagamentis) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getPagamentis());
            }

            $query = ChildPagamentiQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByClienti($this)
                ->count($con);
        }

        return count($this->collPagamentis);
    }

    /**
     * Method called to associate a ChildPagamenti object to this object
     * through the ChildPagamenti foreign key attribute.
     *
     * @param  ChildPagamenti $l ChildPagamenti
     * @return $this|\Clienti The current object (for fluent API support)
     */
    public function addPagamenti(ChildPagamenti $l)
    {
        if ($this->collPagamentis === null) {
            $this->initPagamentis();
            $this->collPagamentisPartial = true;
        }

        if (!$this->collPagamentis->contains($l)) {
            $this->doAddPagamenti($l);

            if ($this->pagamentisScheduledForDeletion and $this->pagamentisScheduledForDeletion->contains($l)) {
                $this->pagamentisScheduledForDeletion->remove($this->pagamentisScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildPagamenti $pagamenti The ChildPagamenti object to add.
     */
    protected function doAddPagamenti(ChildPagamenti $pagamenti)
    {
        $this->collPagamentis[]= $pagamenti;
        $pagamenti->setClienti($this);
    }

    /**
     * @param  ChildPagamenti $pagamenti The ChildPagamenti object to remove.
     * @return $this|ChildClienti The current object (for fluent API support)
     */
    public function removePagamenti(ChildPagamenti $pagamenti)
    {
        if ($this->getPagamentis()->contains($pagamenti)) {
            $pos = $this->collPagamentis->search($pagamenti);
            $this->collPagamentis->remove($pos);
            if (null === $this->pagamentisScheduledForDeletion) {
                $this->pagamentisScheduledForDeletion = clone $this->collPagamentis;
                $this->pagamentisScheduledForDeletion->clear();
            }
            $this->pagamentisScheduledForDeletion[]= clone $pagamenti;
            $pagamenti->setClienti(null);
        }

        return $this;
    }

    /**
     * Clears out the collSchedes collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addSchedes()
     */
    public function clearSchedes()
    {
        $this->collSchedes = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collSchedes collection loaded partially.
     */
    public function resetPartialSchedes($v = true)
    {
        $this->collSchedesPartial = $v;
    }

    /**
     * Initializes the collSchedes collection.
     *
     * By default this just sets the collSchedes collection to an empty array (like clearcollSchedes());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initSchedes($overrideExisting = true)
    {
        if (null !== $this->collSchedes && !$overrideExisting) {
            return;
        }

        $collectionClassName = SchedeTableMap::getTableMap()->getCollectionClassName();

        $this->collSchedes = new $collectionClassName;
        $this->collSchedes->setModel('\Schede');
    }

    /**
     * Gets an array of ChildSchede objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildClienti is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildSchede[] List of ChildSchede objects
     * @throws PropelException
     */
    public function getSchedes(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collSchedesPartial && !$this->isNew();
        if (null === $this->collSchedes || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collSchedes) {
                // return empty collection
                $this->initSchedes();
            } else {
                $collSchedes = ChildSchedeQuery::create(null, $criteria)
                    ->filterByClienti($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collSchedesPartial && count($collSchedes)) {
                        $this->initSchedes(false);

                        foreach ($collSchedes as $obj) {
                            if (false == $this->collSchedes->contains($obj)) {
                                $this->collSchedes->append($obj);
                            }
                        }

                        $this->collSchedesPartial = true;
                    }

                    return $collSchedes;
                }

                if ($partial && $this->collSchedes) {
                    foreach ($this->collSchedes as $obj) {
                        if ($obj->isNew()) {
                            $collSchedes[] = $obj;
                        }
                    }
                }

                $this->collSchedes = $collSchedes;
                $this->collSchedesPartial = false;
            }
        }

        return $this->collSchedes;
    }

    /**
     * Sets a collection of ChildSchede objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $schedes A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildClienti The current object (for fluent API support)
     */
    public function setSchedes(Collection $schedes, ConnectionInterface $con = null)
    {
        /** @var ChildSchede[] $schedesToDelete */
        $schedesToDelete = $this->getSchedes(new Criteria(), $con)->diff($schedes);


        $this->schedesScheduledForDeletion = $schedesToDelete;

        foreach ($schedesToDelete as $schedeRemoved) {
            $schedeRemoved->setClienti(null);
        }

        $this->collSchedes = null;
        foreach ($schedes as $schede) {
            $this->addSchede($schede);
        }

        $this->collSchedes = $schedes;
        $this->collSchedesPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Schede objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Schede objects.
     * @throws PropelException
     */
    public function countSchedes(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collSchedesPartial && !$this->isNew();
        if (null === $this->collSchedes || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collSchedes) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getSchedes());
            }

            $query = ChildSchedeQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByClienti($this)
                ->count($con);
        }

        return count($this->collSchedes);
    }

    /**
     * Method called to associate a ChildSchede object to this object
     * through the ChildSchede foreign key attribute.
     *
     * @param  ChildSchede $l ChildSchede
     * @return $this|\Clienti The current object (for fluent API support)
     */
    public function addSchede(ChildSchede $l)
    {
        if ($this->collSchedes === null) {
            $this->initSchedes();
            $this->collSchedesPartial = true;
        }

        if (!$this->collSchedes->contains($l)) {
            $this->doAddSchede($l);

            if ($this->schedesScheduledForDeletion and $this->schedesScheduledForDeletion->contains($l)) {
                $this->schedesScheduledForDeletion->remove($this->schedesScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildSchede $schede The ChildSchede object to add.
     */
    protected function doAddSchede(ChildSchede $schede)
    {
        $this->collSchedes[]= $schede;
        $schede->setClienti($this);
    }

    /**
     * @param  ChildSchede $schede The ChildSchede object to remove.
     * @return $this|ChildClienti The current object (for fluent API support)
     */
    public function removeSchede(ChildSchede $schede)
    {
        if ($this->getSchedes()->contains($schede)) {
            $pos = $this->collSchedes->search($schede);
            $this->collSchedes->remove($pos);
            if (null === $this->schedesScheduledForDeletion) {
                $this->schedesScheduledForDeletion = clone $this->collSchedes;
                $this->schedesScheduledForDeletion->clear();
            }
            $this->schedesScheduledForDeletion[]= $schede;
            $schede->setClienti(null);
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
        $this->id_cliente = null;
        $this->da_saldare = null;
        $this->note = null;
        $this->indirizzo = null;
        $this->cap = null;
        $this->citta = null;
        $this->provincia = null;
        $this->stato = null;
        $this->codice_fiscale = null;
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
            if ($this->collAssegnamentiPostaziones) {
                foreach ($this->collAssegnamentiPostaziones as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collPagamentis) {
                foreach ($this->collPagamentis as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collSchedes) {
                foreach ($this->collSchedes as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collAccounts = null;
        $this->collAssegnamentiPostaziones = null;
        $this->collPagamentis = null;
        $this->collSchedes = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(ClientiTableMap::DEFAULT_STRING_FORMAT);
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
