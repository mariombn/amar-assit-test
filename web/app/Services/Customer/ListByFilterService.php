<?php

namespace App\Services\Customer;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Collection;

class ListByFilterService
{
    /**
     * Retorna uma Collection com todos os Clientes de acordo com o filtro informado
     * @param array $filter
     * @return array
     */
    public function execute(array $filter = null): Collection
    {
        $query = Customer::query();

        if (!is_null($filter) && count($filter) > 0) {
            if (!empty($filter['name'])) {
                $query->where('name', 'like', '%' . $filter['name'] . '%');
            }

            if (!empty($filter['document'])) {
                $query->where('document', $filter['document']);
            }

            if (!empty($filter['status'])) {
                $query->where('status', $filter['status']);
            }
        }

        $query->orderBy('name');

        return $query->get();
    }
}
