<?php

use Base\Postazioni as BasePostazioni;
use Propel\Runtime\ActiveQuery\Criteria;

require_once 'src/swagger/Postazione.php';

/**
 * Skeleton subclass for representing a row from the 'postazioni' table.
 *
 *
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 */
class Postazioni extends BasePostazioni
{

    const WITH_ASSEGNAMENTO = 1;

    /**
     * Carica gli assegnamenti, le disponibilità e i subaffitti correlati
     * alla postazione a partire dalla data fornita.
     * @param DateTime $data   La data da usare come filtro (default data odierna).
     */
    public function loadAssegnamentiDa(DateTime $data = null)
    {
        if (is_null($data)) {
            $data = DateTime();
        }

        $dataFine = new Criteria();
        $dataFine->add(Map\AssegnamentiPostazioneTableMap::COL_DATA_FINE, $data,
            Criteria::GREATER_EQUAL);

        $this->loadAssegnamenti($dataFine);
    }

    /**
     * Carica gli assegnamenti, le disponibilità e i subaffitti correlati
     * alla postazione a fino alla data fornita.
     * @param DateTime $data   La data da usare come filtro (default data odierna).
     */
    public function loadAssegnamentiFinoA(DateTime $data = null)
    {
        if (is_null($data)) {
            $data = DateTime();
        }

        $dataFine = new Criteria();
        $dataFine->add(Map\AssegnamentiPostazioneTableMap::COL_DATA_FINE, $data,
            Criteria::LESSER_EQUAL);

        $this->loadAssegnamenti($dataFine);
    }

    private function loadAssegnamenti(Criteria $data) {
        foreach ($this->getAssegnamentiPostaziones($data) as $assegnamento) {
            $assegnamento
                ->getClienti()
                ->getAccounts();

            $cliente = ClientiQuery::create()
                ->findPk($assegnamento->getClienti()->getIdCliente());
            $assegnamento->cliente = $cliente->toSwagger(FALSE);

            $assegnamento->getDisponibilitaPostaziones();

            foreach ($assegnamento->getDisponibilitaPostaziones() as $disponibilita) {
                $disponibilita->getSubaffittiPostaziones();
            }
        }
    }

    public function toSwagger($filtro = null): swagger\Postazione {
        $post = new swagger\Postazione();

        $post->idPostazione = $this->getIdPostazione();
        $post->fila = $this->getFila();
        $post->colonna = $this->getColonna();
        $post->settore = $this->getSettore();
        $post->x = $this->getX();
        $post->y = $this->getY();
        $post->note = $this->getNote();

        if (!is_null($filtro)) {
            foreach ($this->getAssegnamentiPostaziones($filtro) as $assegnamento) {
                $post->assegnamenti[] = $assegnamento->toSwagger(AssegnamentiPostazione::WITH_CLIENTE);
            }
        } else {
            foreach ($this->getAssegnamentiPostaziones() as $assegnamento) {
                $post->assegnamenti[] = $assegnamento->toSwagger(AssegnamentiPostazione::WITH_CLIENTE);
            }
        }

        return $post;
    }

    public function toSwaggerOne($filtro = null): swagger\Postazione {
        $post = new swagger\Postazione();
        $post->idPostazione = $this->getIdPostazione();
        $post->fila = $this->getFila();
        $post->colonna = $this->getColonna();
        $post->settore = $this->getSettore();
        $post->x = $this->getX();
        $post->y = $this->getY();
        $post->note = $this->getNote();

        if (!is_null($filtro)) {
            
            foreach ($this->getAssegnamentiPostaziones($filtro) as $assegnamento) {                
                $post->assegnamenti[] = $assegnamento->toSwagger(AssegnamentiPostazione::WITH_CLIENTE);
                break;// carico solo il primo assegnamento
        }    
        } else {
            foreach ($this->getAssegnamentiPostaziones() as $assegnamento) {
                $post->assegnamenti[] = $assegnamento->toSwagger(AssegnamentiPostazione::WITH_CLIENTE);
                break;// carico solo il primo assegnamento
        }
        }
        return $post;
    }
    
    
    
    /**
     * Carica nell'oggetto swagger i dati della postazione e
     * opzionalmente anche gli assegnamenti.
     * Questo viene controllato tramite il parametro $with che
     * specifica i flag per indicare cosa caricare.
     * $with = 0 -> non carica niente
     * $with = WITH_ASSEGNAMENTO carica l'assegnamento
     * @param int $with
     * @param Criteria $filtro
     * @return \swagger\Postazione
     */
    public function toSwagger2($with = 0, $filtro = null): swagger\Postazione {
        // TODO: il nome è temporaneo per evitare errori di compilazione.
        // Da sostituire alla toSwagger asap.
        $post = new swagger\Postazione();

        $post->idPostazione = $this->getIdPostazione();
        $post->fila = $this->getFila();
        $post->colonna = $this->getColonna();
        $post->settore = $this->getSettore();
        $post->x = $this->getX();
        $post->y = $this->getY();
        $post->note = $this->getNote();

        if (($with & Postazioni::WITH_ASSEGNAMENTO) === Postazioni::WITH_ASSEGNAMENTO) {
            if (is_null($filtro)) {
                foreach ($this->getAssegnamentiPostaziones() as $assegnamento) {
                    $post->assegnamenti[] = $assegnamento->toSwagger(AssegnamentiPostazione::WITH_CLIENTE);
                }
            } else {
                foreach ($this->getAssegnamentiPostaziones($filtro) as $assegnamento) {
                    $post->assegnamenti[] = $assegnamento->toSwagger(AssegnamentiPostazione::WITH_CLIENTE);
                }
            }
        }

        return $post;
    }

}
