<?php

namespace App\Services\Charge;

use App\Models\Contract;
use Carbon\Carbon;

class IsHaveCurrentMountIByContractService
{
    public function execute(Contract $contractEntity): bool
    {
        return (bool) $contractEntity->charges()->whereDate('created_at', date('Y-m-d'))->count();
    }
}
