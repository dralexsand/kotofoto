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

    public function setPrices(SetPriceRequest $request)
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

    public function test()
    {
        $oldRegions = [1, 2, 4, 3, 5, 6, 7, 8, 9];
        $newRegions = [2, 1, 3, 4, 5, 7, 9, 11];

        $data = [
            'success' => true,
            'data' => diffArrays($oldRegions, $newRegions),
        ];

        return $data;
    }
}
