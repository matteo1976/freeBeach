<?php

namespace swagger;

use Propel\Runtime\ActiveQuery\Criteria as Criteria;



class Cliente
{

    public $idCliente;

    public $nome;

    public $indirizzo;

    public $cap;

    public $citta;

    public $provincia;

    public $stato;

    public $codiceFiscale;

    public $telefono;

    public $email;

    public $password;

    public $abilitato;

    public $daSaldare;

    public $note;

    //TODO mettere il profilo
    // $ref: '#/definitions/Profilo'
    public $profilo;

    // description: Schede assegnate al cliente
    // type: array
    // items: $ref: '#/definitions/Scheda'
    public $schede;

    // description: Postazioni assegnate al cliente
    // type: array
    // items: $ref: '#/definitions/AssegnamentoPostazione'
    public $assegnamenti;

    /**
     * Carica nell'oggetto swagger i dati dei Clienti
     * dall'oggetto restituito da propel
     * @param   object   $value      ChildClienti
     * @param   DataTime $daData    se null vado a caricare lo strorico di tutti gli assegnamenti
     * @return object swagger/Cliente
     */
//    public static function LoadCliente(\Clienti $value) : Cliente {
//        $that = new Cliente();
//
//        $that->idCliente = $value->getIdCliente();
//        $that->indirizzo = $value->getIndirizzo();
//        $that->cap=$value->getCap();
//        $that->citta=$value->getCitta();
//        $that->provincia=$value->getProvincia();
//        $that->stato=$value->getStato();
//        $that->codiceFiscale=$value->getCodiceFiscale();
//        $that->daSaldare = $value->getDaSaldare(0);
//        $that->note = $value->getNote();
//
//        $account = $value->getAccounts()[0];
//
//        $that->nome = $account->getNome();
//        $that->telefono = $account->getTelefono();
//        $that->email = $account->getEmail();
//        $that->password = $account->getPassword();
//        $that->abilitato = $account->getAbilitato();
//
//        // TODO: Gestire correttamente il profilo.
//        // A noi interessa l'elenco dei privilegi associati
//        // per determinare le funzionalità da abilitare.
//        // Sul cliente al momento non serve
//        //$that->profilo = ....
//		$that->profilo = Profilo::LoadProfili($account->getProfili());
//
//        foreach ($cliente->getSchedes() as $scheda) {
//            $that->schede[] = Scheda::From($scheda);
//        }
//
//        foreach ($cliente->getAssegnamentiPostaziones() as $assegnamento) {
//            $that->assegnamenti[] = AssegnamentoPostazione::from($assegnamento);
//        }
//
//        return $that;
//    }


    /**
     * Carica nell'oggetto swagger i dati dei Clienti
     * dall'oggetto restituito da propel
     * N.B
     * senza i dati degli assegnamenti perche' li carica prima
     * nell caricamento delle postazioni.
     * @param   object   $value      ChildClienti
     * @param   DataTime $daData    se null vado a caricare lo strorico di tutti gli assegnamenti
     * @return object swagger/Cliente
     */
//    public static function LoadClienteDaPostazione(\Clienti $value): Cliente {
//        $that = new Cliente();
//        // alcuni valori vengono presi dal cliente altri dall'account
//        // che sono dati comuni agli operatori
//        $that->idCliente = $value->getIdCliente();
//        $that->indirizzo = $value->getIndirizzo();
//        $that->cap=$value->getCap();
//        $that->citta=$value->getCitta();
//        $that->provincia=$value->getProvincia();
//        $that->stato=$value->getStato();
//        $that->codiceFiscale=$value->getCodiceFiscale();
//        $that->daSaldare = $value->getDaSaldare(0);
//        $that->note = $value->getNote();
//
//        $account = $value->getAccounts()[0];
//
//        $that->nome = $account->getNome();
//        $that->telefono = $account->getTelefono();
//        $that->email = $account->getEmail();
//        $that->password = $account->getPassword();
//        $that->abilitato = $account->getAbilitato();
//        $that->profilo = Profilo::LoadProfili($account->getProfili());
//
//        foreach ($value->getSchedes() as $scheda) {
//            $that->schede[] = Scheda::LoadScheda($scheda);
//        }
//
//        return $that;
//    }

}
