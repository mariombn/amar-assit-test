<?php

namespace Database\Seeders;

use App\Models\ChargeType;
use App\Models\Contract;
use App\Models\Customer;
use App\Models\Charge;
use DateTime;
use Illuminate\Database\Seeder;;
use Illuminate\Support\Str;

class DemoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $customers = 50;
        $rangeContractByCustomers = [0, 2];

        for ($customersCount = 0; $customersCount < $customers; $customersCount++) {

            if (rand(0, 1) == 0) {
                $document = rand(10000000000, 99999999999);
            } else {
                $document = rand(10000000000000, 99999999999999);
            }

            $customerEntity = new Customer();
            $customerEntity->name = Str::random(10);
            $customerEntity->document = $document;
            $customerEntity->address = Str::random(200);
            $customerEntity->contact = '11' . rand(10000000, 99999999);
            $customerEntity->status = 'active';
            $customerEntity->created_at = now();
            $customerEntity->updated_at = now();
            $customerEntity->save();

            $randContract = rand($rangeContractByCustomers[0], $rangeContractByCustomers[1]);

            for (
                $rangeContractByCustomersCount = 0;
                $rangeContractByCustomersCount < $randContract;
                $rangeContractByCustomersCount++
            ) {
                $customerId = $customerEntity->id;
                $contractEntity = new Contract();
                $contractEntity->cicle = date('d');
                $type = 'pf';
                if (strlen($customerEntity->document) == 14) {
                    $type = 'pj';
                }
                $contractEntity->type = $type;
                $contractEntity->customer_id = $customerId;
                $contractEntity->save();
            }
        }
    }
}
