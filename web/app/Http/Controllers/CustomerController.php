<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Services\Customer\CountContractsService;
use App\Services\Customer\EditService;
use App\Services\Customer\ListByFilterService;
use App\Services\Customer\ShowService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CustomerController extends Controller
{
    public function index(
        Request $request,
        ListByFilterService $listByFilterService
    ) {
        try {
            $customerCollection = $listByFilterService->execute($request->all());

            return response()->json([
                'success' => true,
                'data' => $customerCollection->toArray()
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

    public function show(
        Request $request,
        ShowService $showService
    ) {
        try {
            return response()->json([
                'success' => true,
                'data' => $showService->execute($request->id)
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

    public function update(
        Request $request,
        ShowService $showService,
        CountContractsService $countContractsService,
        EditService $editService
    ) {
        try {
            $data = $request->all();

            $customerEntity = $showService->execute($request->id);
            $contractCount = $countContractsService->execute($customerEntity);

            if (
                $data['status'] == Customer::STATUS_INACTIVE &&
                $contractCount > 0
            ) {
                throw new \Exception(
                    "Não é permitido desativar clientes que possuam contratos",
                    Response::HTTP_BAD_REQUEST
                );
            }

            $customerEntity = $editService->execute($customerEntity, $data);

            return response()->json([
                'success' => true,
                'data' => $customerEntity
            ]);
        } catch (\Exception $exception) {
            return response()->json([
                'success' => false,
                'code' => $exception->getCode(),
                'message' => $exception->getMessage(),
                'file' => $exception->getFile(),
                'line' => $exception->getLine(),
            ], $exception->getCode());
        }
    }
}
