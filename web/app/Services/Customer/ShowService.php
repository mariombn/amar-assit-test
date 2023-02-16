<?php

namespace App\Services\Customer;

use App\Models\Customer;

class ShowService
{
    /**
     * Carrega a entidade a partir do seu ID
     * @param int $customerId
     * @return Customer
     * @throws \Exception
     */
    public function execute(int $customerId): Customer
    {
        $customerEntity = Customer::find($customerId);

        if (is_null($customerEntity)) {
            throw new \Exception("Entidade de Cliente não encontrada");
        }

        return $customerEntity;
    }
}
