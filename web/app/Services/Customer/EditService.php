<?php

namespace App\Services\Customer;

use App\Models\Customer;

class EditService
{

    public function execute(Customer $customerEntity, array $data): Customer
    {
        $customerEntity->fill($data);
        $customerEntity->save();

        return $customerEntity;
    }
}
