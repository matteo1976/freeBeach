<?php

use Base\AccountQuery as BaseAccountQuery;

/**
 * Skeleton subclass for performing query and update operations on the 'account' table.
 *
 *
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 */
class AccountQuery extends BaseAccountQuery
{

    /**
     * cancella record dalla tabella Account usando idCliente
     *
     * @see        filterByIdCliente()
     *
     * @param     mixed $IdCliente The value to use as filter.
     *              Use array values for in_array() equivalent.
     *
     */
    public static function deleteAccountByIdCliente($IdCliente)
        {

        AccountQuery::create()
            ->filterByIdCliente($IdCliente)
            ->delete();
        }

}
