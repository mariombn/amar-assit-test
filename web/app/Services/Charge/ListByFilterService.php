<?php

namespace App\Services\Charge;

use App\Models\Charge;
use Illuminate\Database\Eloquent\Collection;

class ListByFilterService
{
    /**
     * Retorna uma Collection com todos os Clientes de acordo com o filtro informado ordenados pelo status do contrato
     * @param array $filter
     * @return array
     */
    public function execute(array $filter = null): Collection
    {
        $query = Charge::query();

        if (isset($filter['status']) && !is_null($filter['status'])) {
            $query->where('status', $filter['status']);
        }

        if (
            isset($filter['date_start']) &&
            isset($filter['date_end']) &&
            !is_null($filter['date_start']) &&
            !is_null($filter['date_end'])
        ) {
            $query->whereBetween('created_at', [$filter['date_start'], $filter['date_end']]);
        }

        $query->orderBy('status')->orderBy('created_at');

        return $query->get();
    }
}
