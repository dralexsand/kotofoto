<?php

namespace App\Services;

use App\Models\Price;
use App\Models\PriceArchive;
use App\Models\Product;
use App\Models\Region;

class PriceService
{

    public function store(array $products): bool
    {
        foreach ($products as $product) {
            $product_id = $product['product_id'];

            $productStored = Product::find($product_id);

            if (empty($productStored)) {
                Product::create([
                    'id' => $product_id,
                ]);
            }

            $prices = $product['prices'];

            foreach ($prices as $region_id => $price) {
                $region = Region::find($region_id);

                if (empty($region)) {
                    Product::create([
                        'id' => $region_id,
                    ]);
                }

                $priceStored = Price::where([
                    ['product_id', '=', $product_id],
                    ['region_id', '=', $region_id]
                ])->first();

                if (empty($priceStored)) {
                    Price::create([
                        'product_id' => $product_id,
                        'region_id' => $region_id,
                        'purchase' => $price['price_purchase'],
                        'selling' => $price['price_selling'],
                        'discount' => $price['price_discount'],
                    ]);
                } else {
                    $priceStored->update([
                        'product_id' => $product_id,
                        'region_id' => $region_id,
                        'purchase' => $price['price_purchase'],
                        'selling' => $price['price_selling'],
                        'discount' => $price['price_discount'],
                    ]);
                }

                PriceArchive::create([
                    'product_id' => $product_id,
                    'region_id' => $region_id,
                    'purchase' => $price['price_purchase'],
                    'selling' => $price['price_selling'],
                    'discount' => $price['price_discount'],
                ]);
            }
        }

        return true;
    }

    public function getStructuredResponse()
    {
        $items = Price::all();
        $products = [];

        foreach ($items as $item) {
            $product_id = $item->product_id;
            $region_id = $item->region_id;

            $pricesItemArray = [
                'product_id' => $product_id,
                'prices' => [
                    "$region_id" => [
                        'price_purchase' => $item->purchase,
                        'price_selling' => $item->selling,
                        'price_discount' => $item->discount,
                    ],
                ]
            ];

            $products[] = $pricesItemArray;
        }

        return $products;
    }

    public function validateRequestArray(array $data): array
    {
        $messages = [];

        return $messages;
    }

    public function validateRequestItemData(array $itemData)
    {
    }

}
