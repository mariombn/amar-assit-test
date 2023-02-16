<?php

namespace App\Services\Charge;

use App\Models\Charge;
use Carbon\Carbon;

class ApplyFineService
{
    /**
     * Aplica juros de acordo com o tempo de atraso do contrato
     * @param Charge $chargeEntity
     * @return bool
     */
    public function execute(Charge $chargeEntity): bool
    {
        $currentDay = date('Y-m-d');
        $dateString = $chargeEntity->created_at;
        $date = Carbon::parse($dateString);
        $dateOnly = $date->format('Y-m-d');
        $days = Carbon::parse($dateOnly)->diffInDays(Carbon::parse($currentDay));

        $fineValue = $chargeEntity->value;

        if ($days <= 0) {
            return false;
        }

        for ($i = 0; $i < $days; $i++) {
            $fineValue *= 0.01;
        }

        $chargeEntity->fine_value = $fineValue;
        $chargeEntity->save();

        return true;
    }
}
