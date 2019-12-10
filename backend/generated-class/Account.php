<?php

use Base\Account as BaseAccount;

require_once 'src/swagger/Profilo.php';


/**
 * Skeleton subclass for representing a row from the 'account' table.
 *
 *
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 */
class Account extends BaseAccount
{
    public function toSwagger() : swagger\Operatore {
        $result = new swagger\Operatore();

        $result->idOperatore = $this->getIdAccount();
        $result->abilitato = $this->getAbilitato();
        $result->email = $this->getEmail();
        $result->indirizzo = $this->getIndirizzo();
        $result->nome = $this->getNome();
        $result->telefono = $this->getTelefono();

        $result->profilo = $this->getProfili()->toSwagger();

        return $result;
    }

}
