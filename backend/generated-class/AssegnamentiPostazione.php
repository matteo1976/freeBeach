<?php

use Base\AssegnamentiPostazione as BaseAssegnamentiPostazione;
use Base\AssegnamentiPostazioneQuery as BaseAssegnamentiPostazioneQuery;
use \Propel\Runtime\ActiveQuery\Criteria as Criteria;

require_once 'src/swagger/Abbonamento.php';
require_once 'src/swagger/AssegnamentoPostazione.php';
require_once 'src/swagger/Cliente.php';
require_once 'src/swagger/DisponibilitaPostazione.php';

/**
 * Skeleton subclass for representing a row from the 'assegnamenti_postazione' table.
 *
 *
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 */
class AssegnamentiPostazione extends BaseAssegnamentiPostazione
{

    const WITH_CLIENTE = 1;

    const WITH_POSTAZIONE = 2;

    public $postazione;

    public $cliente;

    /**
     * Carica nell'oggetto swagger i dati degli assegnamenti
     * dall'oggetto restituito da propel
     * Gli assegnamenti sono relativi alle due entità postazione
     * e cliente. Una delle due può sempre essere derivata dalla
     * rotta ma la seconda deve essere caricata nell'oggetto
     * assegnamento.
     * Questo viene controllato tramite il parametro $with che
     * specifica i flag per indicare cosa caricare.
     * $with = 0 -> non carica niente
     * $with = WITH_CLIENTE -> sarà caricato il cliente
     * $with = WITH_POSTAZIONE -> sarà caricata la postazione
     * $with = WITH_CLIENTE + postazione -> carica entrambi
     * @param int $with Modalità di caricamento
     * @return swagger/object AssegnamentoPostazione
     */
    public function toSwagger($with = 0): swagger\AssegnamentoPostazione {
        $assegnamento = new swagger\AssegnamentoPostazione();

        $assegnamento->idAssegnamento = $this->getIdAssegnamentoPostazione();
        $assegnamento->dataInizio = $this->getDataInizio(\DateTime::ISO8601);
        $assegnamento->dataFine = $this->getDataFine(\DateTime::ISO8601);

        $assegnamento->abbonamento = $this->getAbbonamenti()->toSwagger();

        if ($with & AssegnamentiPostazione::WITH_CLIENTE === AssegnamentiPostazione::WITH_CLIENTE) {
            $assegnamento->cliente = $this->getClienti()->toSwagger(FALSE);
        }

        //$assegnamento->postazione = $this->getPostazioni()->toSwagger();
        if (($with & AssegnamentiPostazione::WITH_POSTAZIONE) === AssegnamentiPostazione::WITH_POSTAZIONE) {
            $assegnamento->postazione = $this->getPostazioni()->toSwagger2();
        }

        $assegnamento->autorizzati = $this->getAutorizzati();
        $assegnamento->note = $this->getNote();

        // servizio
        foreach ($this->getServizis() as $servizio) {
            $assegnamento->servizi[] = $servizio->ToSwagger();
        }

        foreach ($this->getDisponibilitaPostaziones() as $disponibilita) {
            $assegnamento->disponibilita[] = $disponibilita->toSwagger();
        }

        return $assegnamento;
    }

    /*
     * MATTEO TODO
     * conta solo record dentro intervallo
     * non controlla una disponibilita parziale
     */
    public function verificaPossibilitaAssegnamento($idPostazione, $dataInizio, $dataFine)
    {

        $count = BaseAssegnamentiPostazioneQuery::create()
            ->filterByDataInizio($dataInizio, Criteria::LESS_EQUAL)
            ->_and()
            ->filterByDataFine($dataFine, Criteria::GREATER_EQUAL)
            ->_and()
            ->filterByIdPostazione($idPostazione)
            ->count();

        if ($count === 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

}
