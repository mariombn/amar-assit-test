<?php

namespace App\Services\Customer;

use App\Models\Customer;

class CountContractsService
{
    /**
     * Retorna o total de contratos que o Cliente possui
     * @param Customer $customerEntity
     * @return int
     */
    public function execute(Customer $customerEntity): int
    {
        return $customerEntity->contracts()->count();
    }
}
