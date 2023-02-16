<?php

namespace App\Services\Charge;

use App\Models\Charge;

class ShowService
{
    /**
     * Carrega a entidade a partir do seu ID
     * @param int $chargerId
     * @return Charge
     * @throws \Exception
     */
    public function execute(int $chargerId): Charge
    {
        $chargeEntity = Charge::find($chargerId);

        if (is_null($chargeEntity)) {
            throw new \Exception("Entidade de Cobrança não encontrada");
        }

        return $chargeEntity;
    }
}
