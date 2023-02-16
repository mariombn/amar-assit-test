<?php

namespace App\Services\Contract;


use App\Models\Contract;
use Illuminate\Database\Eloquent\Collection;

class GetAllofCurrentDayService
{

    /**
     * Retorna uma coleção com todos os contratos que tem o ciclo no dia atual
     * Caso seja o ultimo dia do Mês, seram pegos contratos que tem ciclo em dias finais de meses diferentes do mês atual
     * @return Collection
     */
    public function execute(): Collection
    {
        $day = date('d');
        $listDaysOfSearch[] = $day;
        $isLastDayOfMount = ($day == date('t'));

        if ($isLastDayOfMount) {
            $maxDayinMount = 31;
            $diff = $maxDayinMount - $day;
            for ($i = 1; $i <= $diff; $i++) {
                $listDaysOfSearch[] = $day + $i;
            }
        }

        return Contract::whereIn('cicle', $listDaysOfSearch)->get();
    }
}
