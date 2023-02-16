<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChargeType extends Model
{
    protected $table = 'charges_types';

    public function charge()
    {
        return $this->belongsTo(Charge::class, 'charge_id', 'id');
    }
}
