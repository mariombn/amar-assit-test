<?php

namespace App\Console\Commands;

use App\Models\Contract;
use App\Services\Charge\ApplyFineService;
use App\Services\Charge\CreateByContractService;
use App\Services\Charge\GetAllLateService;
use App\Services\Charge\IsHaveCurrentMountIByContractService;
use App\Services\Contract\GetAllofCurrentDayService;
use Illuminate\Console\Command;

class ApplyFineValue extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cron:apply-fine-value';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Aplica juros em todas as faturas em atraso';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(
        GetAllLateService $getAllLateService,
        ApplyFineService $applyFineService
    ) {
        $chargeCollection = $getAllLateService->execute();

        foreach ($chargeCollection as $chageEntity) {
            $applyFineService->execute($chageEntity);
        }

        $this->info('Foram aplicados juros em ' . count($chargeCollection) .  ' contratos');

        return Command::SUCCESS;
    }
}
