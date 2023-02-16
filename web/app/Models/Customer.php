<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $table = 'customers';
    const STATUS_ACTIVE = 'active';
    const STATUS_INACTIVE = 'inactive';

    protected $fillable = [
        'name', 'document', 'address', 'contact', 'status'
    ];

    public function contracts()
    {
        return $this->hasMany(Contract::class, 'customer_id', 'id');
    }
}
