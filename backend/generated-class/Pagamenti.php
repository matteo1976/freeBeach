<?php

use Base\Pagamenti as BasePagamenti;

/**
 * Skeleton subclass for representing a row from the 'pagamenti' table.
 *
 *
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 */
class Pagamenti extends BasePagamenti
{
    public function toSwagger(): swagger\Pagamento {
        $result = new swagger\Pagamento();

        $result->idPagamento = $this->getIdPagamento();
        $result->importo = $this->getImporto();
        $result->data = $this->getData(\DateTime::ISO8601);

        return $result;
    }
}
