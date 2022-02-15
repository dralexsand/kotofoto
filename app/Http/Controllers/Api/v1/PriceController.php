<?php

namespace App\Http\Controllers\Api\v1;

use App\Helpers\HelperPrice;
use App\Http\Controllers\Controller;
use App\Http\Requests\Price\SetPriceRequest;
use App\Services\PriceService;
use Illuminate\Http\Request;

class PriceController extends Controller
{
    protected PriceService $service;

    public function __construct()
    {
        $this->service = new PriceService();
    }

    /**
     * @param SetPriceRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function setPrices(SetPriceRequest $request): \Illuminate\Http\JsonResponse
    {
        $all = $request->all();
        $data = $all['data'];

        $isStore = $this->service->store($data);

        if ($isStore) {
            $response = $this->service->getStructuredResponse();
            return response()->json([
                'success' => true,
                'data' => $response
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'errors' => ['Ошибка записи']
            ], 500);
        }
    }
}
