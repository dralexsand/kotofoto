<?php

namespace App\Http\Controllers\Api\v1;

use App\Helpers\HelperPrice;
use App\Http\Controllers\Controller;
use App\Http\Requests\Price\SetPriceRequest;
use App\Services\PriceService;
use Illuminate\Http\JsonResponse;

class PriceController extends Controller
{
    protected PriceService $service;

    public function __construct()
    {
        $this->service = new PriceService();
    }

    /**
     * @param SetPriceRequest $request
     * @return JsonResponse
     */
    public function setPrices(SetPriceRequest $request): JsonResponse
    {
        $all = $request->all();
        $data = $all['data'];

        $dataStored = $this->service->store($data);

        if ($dataStored) {
            return response()->json([
                'success' => true,
                'data' => $dataStored
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'errors' => ['Ошибка записи']
            ], 500);
        }
    }
}
