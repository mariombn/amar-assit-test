<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    protected $table = 'contracts';

    const TYPE_PF = 'pf';
    const TYPE_PJ = 'pj';

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }

    public function charges()
    {
        return $this->hasMany(Charge::class, 'contract_id', 'id');
    }
}
