<?php

namespace App\Http\Controllers;

use App\Models\Charge;
use App\Services\Charge\ListByFilterService;
use App\Services\Charge\MakePaymentService;
use App\Services\Charge\ShowService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ChargeController extends Controller
{
    public function index(
        Request $request,
        ListByFilterService $listByFilterService
    ) {
        try {
            $chargeCollection = $listByFilterService->execute($request->all());

            return response()->json([
                'success' => true,
                'data' => $chargeCollection->map(function($charge) {
                    return [
                        'id' => $charge->id,
                        'type' => $charge->type,
                        'value' => $charge->value,
                        'fine_value' => $charge->fine_value,
                        'status' => $charge->status,
                        'created_at' => $charge->created_at,
                        'costumer_id' => $charge->contract->customer_id,
                        'costumer_name' => $charge->contract->customer->name,
                    ];
                })
            ]);
        } catch (\Exception $exception) {
            return response()->json([
                'success' => false,
                'code' => $exception->getCode(),
                'message' => $exception->getMessage(),
                'file' => $exception->getFile(),
                'line' => $exception->getLine(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function makePayment(
        Request $request,
        ShowService $showService,
        MakePaymentService $makePaymentService
    ) {
        try {
            $chargerEntity = $showService->execute($request->id);

            if ($chargerEntity->status == Charge::STATUS_PAID) {
                throw new \Exception("Essa cobrança já encontra-se paga");
            }

            $chargeTypeEntity = $makePaymentService->execute($chargerEntity);

            return response()->json([
                'success' => true,
                'data' => $chargeTypeEntity->toArray()
            ]);
        } catch (\Exception $exception) {
            return response()->json([
                'success' => false,
                'code' => $exception->getCode(),
                'message' => $exception->getMessage(),
                'file' => $exception->getFile(),
                'line' => $exception->getLine(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
