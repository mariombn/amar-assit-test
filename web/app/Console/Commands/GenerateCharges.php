<?php

namespace App\Console\Commands;

use App\Models\Contract;
use App\Services\Charge\CreateByContractService;
use App\Services\Charge\IsHaveCurrentMountIByContractService;
use App\Services\Contract\GetAllofCurrentDayService;
use Illuminate\Console\Command;

class GenerateCharges extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cron:generete-charges';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Gera as faturas de todos os contratos do dia atual';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(
        GetAllofCurrentDayService $getAllofCurrentDayService,
        IsHaveCurrentMountIByContractService $isHaveCurrentMountIByContractService,
        CreateByContractService $createByContractService
    ) {

        $contractCollection = $getAllofCurrentDayService->execute();

        $newCharges = [];

        /** @var Contract $contractEntity */
        foreach ($contractCollection as $contractEntity) {
            if ($isHaveCurrentMountIByContractService->execute($contractEntity)) {
                continue;
            }
            $newCharges[] = $createByContractService->execute($contractEntity);
        }

        $this->info('Foram criadas ' . count($newCharges) . ' novas faturas');

        return Command::SUCCESS;
    }
}
