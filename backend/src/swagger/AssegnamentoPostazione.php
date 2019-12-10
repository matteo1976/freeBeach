<?php

namespace swagger;

class AssegnamentoPostazione
{

    /**
     * Id dell'assegnamento
     * @var integer
     */
    public $idAssegnamento;

    /**
     * Data inizio periodo di assegnamento di una postazione.
     * @var DataTime
     */
    public $dataInizio;

    /**
     * Data fine periodo di assegnamento di una postazione.
     * @var DataTime
     */
    public $dataFine;

    /**
     *Note sull'assegnamento
     * @var String
     */
    public $note;

    /**
     * dati del cliente al quale e' assegnat la postazione
     * @var object swagger/Cliente
     */

    public $cliente;

    /**
     * dati del abbonamento fatto dal cliente per quella postazione assegnata
     * @var object swagger/Abbonamento
     */

    public $abbonamento;
    /**
     * dati della disponibilita di quella postazione per un eventuale subaffitto
     * @var object swagger/DisponibilitaPostazione
     */
    public $disponibilita;

    /**
     * dati sulle persone autorizzate all'uso della postazione assegnata.
     * @var array[] string
     */
    public $autorizzati;

    /**
     * dati dei servizi legati alla postazione assegnata
     * @var  type: array items: $ref: '#/definitions/Servizio'             */
    public $servizi;

    /**
     * Carica nell'oggetto swagger i dati degli assegnamenti
     * dall'oggetto restituito da propel
     * N.B
     * non carico cliente perche' essendo chiamata da clienti
     * i dati del cliente sono gia' presenti
     * @param object $value ChildAssegnamentiPostazione
     * @return swagger/object AssegnamentoPostazione
     */
//    public static function LoadAssegnamentoDaCliente(\AssegnamentiPostazione $value): AssegnamentoPostazione {
//
//        $assegnamento = new AssegnamentoPostazione();
//
//        $assegnamento->idAssegnamento = $value->getIdAssegnamentoPostazione();
//        $assegnamento->dataInizio = $value->getDataInizio(\DateTime::ISO8601);
//        $assegnamento->dataFine = $value->getDataFine(\DateTime::ISO8601);
//
//        $assegnamento->abbonamento =Abbonamento::LoadAbbonamenti($value->getAbbonamenti());
//
//        //MATTEO la chiamo da cliente e quindi i dati li ho gia
//        //$assegnamento->cliente = Cliente::LoadClienti($value->getClienti());
//
//        $assegnamento->autorizzati=$value->getAutorizzati();
//
//        foreach ($value->getDisponibilitaPostaziones() as $disponibilita)
//            $assegnamento->disponibilita[]= DisponibilitaPostazione::LoadDisponibilita($disponibilita);
//
//        return $assegnamento;
//    }

    /**
     * Carica nell'oggetto swagger i dati degli assegnamenti
     * dall'oggetto restituito da propel
     * N.B
     * Gli assegnamenti partendo dalle postazioni
     * devo caricare anche i dati dei clienti
     * @param object $value ChildAssegnamentiPostazione
     * @return swagger/object AssegnamentoPostazione
     */
//    public static function LoadAssegnamentiDaPostazione(\AssegnamentiPostazione $value): AssegnamentoPostazione {
//
//        $assegnamento = new AssegnamentoPostazione();
//
//        $assegnamento->idAssegnamento = $value->getIdAssegnamentoPostazione();
//        $assegnamento->dataInizio = $value->getDataInizio(\DateTime::ISO8601);
//        $assegnamento->dataFine = $value->getDataFine(\DateTime::ISO8601);
//
//        $assegnamento->abbonamento =Abbonamento::LoadAbbonamenti($value->getAbbonamenti());
//
//        //carica i clienti senza ricaricare gli assegnamenti
//        $assegnamento->cliente = Cliente::LoadClienteDaPostazione($value->getClienti());
//
//        $assegnamento->autorizzati=$value->getAutorizzati();
//
//        foreach ($value->getDisponibilitaPostaziones() as $disponibilita)
//            $assegnamento->disponibilita[]= DisponibilitaPostazione::LoadDisponibilita($disponibilita);
//
//        return $assegnamento;
//    }

}
