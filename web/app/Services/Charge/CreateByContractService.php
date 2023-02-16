<?php

namespace App\Services\Charge;

use App\Models\Charge;
use App\Models\Contract;

class CreateByContractService
{
    public function execute(Contract $contractEntity): Charge
    {
        $types = [
            0 => Charge::TYPE_TICKET,
            1 => Charge::TYPE_CARD,
            2 => Charge::TYPE_PIX,
        ];
        $chargerEntity = new Charge();
        $chargerEntity->value = rand(100, 1000); //Valor aleatório
        $chargerEntity->fine_value = 0;
        $type = $types[rand(0, 2)];
        $chargerEntity->type = $type;
        $chargerEntity->contract_id = $contractEntity->id;
        $chargerEntity->save();

        return $chargerEntity;
    }
}
