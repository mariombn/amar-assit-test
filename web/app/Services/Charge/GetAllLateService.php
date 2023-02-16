<?php

namespace App\Services\Charge;

use App\Models\Charge;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;

class GetAllLateService
{
    public function execute(): Collection
    {
        return Charge::where('status', 'pending')
            ->where('created_at', '<', Carbon::today())
            ->get();
    }
}
