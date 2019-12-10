<?php

use Base\Clienti as BaseClienti;

require_once 'src/swagger/Scheda.php';
require_once 'src/swagger/AssegnamentoPostazione.php';
require_once 'src/swagger/Profilo.php';

/**
 * Skeleton subclass for representing a row from the 'clienti' table.
 *
 *
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 */
class Clienti extends BaseClienti
{

    /**
     * Carica nell'oggetto swagger i dati dei Clienti
     * dall'oggetto restituito da propel
     * @param   boolean   $withAssegnamenti   Se true carica gli assegnamenti del cliente
     * @param   Criteria  $filtro             Filtra gli assegnamenti per data
     * @return object swagger/Cliente
     */
    public function toSwagger($withAssegnamenti, $filtro = null): swagger\Cliente {
        $result = new swagger\Cliente();

        $result->idCliente = $this->getIdCliente();
        $result->indirizzo = $this->getIndirizzo();
        $result->cap = $this->getCap();
        $result->citta = $this->getCitta();
        $result->provincia = $this->getProvincia();
        $result->stato = $this->getStato();
        $result->codiceFiscale = $this->getCodiceFiscale();
        $result->daSaldare = (float) $this->getDaSaldare(0);
        $result->note = $this->getNote();

        $account = $this->getAccounts()[0];

        $result->nome = $account->getNome();
        $result->telefono = $account->getTelefono();
        $result->email = $account->getEmail();
        $result->password = $account->getPassword();
        $result->abilitato = $account->getAbilitato();

        // TODO: Gestire correttamente il profilo.
        // A noi interessa l'elenco dei privilegi associati
        // per determinare le funzionalità da abilitare.
        // Sul cliente al momento non serve
        //$that->profilo = ....
        $result->profilo = $account->getProfili()->toSwagger();

        foreach ($this->getSchedes() as $scheda) {
            $result->schede[] = $scheda->toSwagger();
        }

        if ($withAssegnamenti) {
            // TODO: controllare se ordinato per data inizio
            foreach ($this->getAssegnamentiPostaziones($filtro) as $assegnamento) {
                $result->assegnamenti[] = $assegnamento->toSwagger(AssegnamentiPostazione::WITH_POSTAZIONE);
            }
        }

        foreach ($this->getPagamentis() as $pagamento) {
            $result->pagamenti[] = $pagamento->toSwagger();
        }

        return $result;
    }

}
