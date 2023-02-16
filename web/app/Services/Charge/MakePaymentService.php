<?php

namespace App\Services\Charge;

use App\Models\Charge;
use App\Models\ChargeType;

class MakePaymentService
{

    public function execute(Charge $chargeEntity): ChargeType
    {
        $chargeEntity->status = 'paid';
        $chargeTypeEntity = new ChargeType();
        $chargeTypeEntity->charge_id = $chargeEntity->id;

        switch ($chargeEntity->type) {
            case Charge::TYPE_TICKET:
                $chargeTypeEntity->ticket = "CODIGO_DE_BARRAS";
                break;
            case Charge::TYPE_CARD:
                $chargeTypeEntity->card = "DADOS_CARTAO";
                break;
            case Charge::TYPE_PIX:
                $chargeTypeEntity->pix = "CHAVE_PIX";
                break;
            default:
                throw new \Exception("Tipo inválido na fatura", 400);
        }

        $chargeEntity->save();
        $chargeTypeEntity->save();

        return $chargeTypeEntity;
    }
}
