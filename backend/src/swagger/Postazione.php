<?php

namespace swagger;

include_once 'src/swagger/AssegnamentoPostazione.php';

class Postazione
{

    /**
     * Id della postazione.
     * @var int
     */
    public $idPostazione;

    /**
     * Fila della postazione.
     * @var string
     */
    public $fila;

    /**
     * Colonna della postazione.
     * @var string
     */
    public $colonna;

    /**
     * Settore della postazione.
     * @var string
     */
    public $settore;

    /**
     * Ascissa della posizione della postazione sulla mappa.
     * @var int
     */
    public $x;

    /**
     * Ordinata della posizione della postazione sulla mappa.
     * @var int
     */
    public $y;

    /**
     * Note della postazione.
     * @var string
     */
    public $note;

    /**
     * postazioni assegnate
     * @var object AssegnamentoPostazione
     * $ref: '#/definitions/AssegnamentoPostazione'
     */
    public $assegnamenti;

//    /**
//     * Carica nell'oggetto swagger i dati delle postazioni
//     * dall'oggetto restituito da propel
//     * @param object $value ChildPostazioni
//     * @return \swagger\Postazione
//     */
//    public static function LoadPostazione(\Postazioni $value, $filtro = null): Postazione {
//        $that = new Postazione();
//
//        $that->idPostazione = $value->getIdPostazione();
//        $that->fila = $value->getFila();
//        $that->colonna = $value->getColonna();
//        $that->settore = $value->getSettore();
//        $that->x = $value->getX();
//        $that->y = $value->getY();
//        $that->note = $value->getNote();
//
//        if (!is_null($filtro)) {
//            foreach ($value->getAssegnamentiPostaziones($filtro) as $assegnamento) {
//                $that->assegnamenti[] = AssegnamentoPostazione::LoadAssegnamentiDaPostazione($assegnamento);
//            }
//        } else {
//            foreach ($value->getAssegnamentiPostaziones() as $assegnamento) {
//                $that->assegnamenti[] = AssegnamentoPostazione::LoadAssegnamentiDaPostazione($assegnamento);
//            }
//        }
//
//        return $that;
//    }

}
