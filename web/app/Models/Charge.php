<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Charge extends Model
{
    protected $table = 'charges';

    const TYPE_TICKET = 'ticket';
    const TYPE_CARD = 'card';
    const TYPE_PIX = 'pix';

    const STATUS_PENDING = 'pending';
    const STATUS_PAID = 'paid';

    public function contract()
    {
        return $this->belongsTo(Contract::class, 'contract_id', 'id');
    }

    public function chargeType()
    {
        return $this->hasOne(ChargeType::class, 'charge_id', 'id');
    }
}
