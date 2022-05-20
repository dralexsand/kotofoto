<?php
declare(strict_types=1);


namespace App\Services;

use App\Models\Price;
use App\Models\PriceArchive;
use App\Models\Product;
use App\Models\Region;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class PriceService
{

    // Получаем все соответствия id, region_id, product_id
    // Во избежание дублей при добавлении новых позиций
    /**
     * @return array
     */
    public function getPricesDbData(): array
    {
        $data = Price::select('id', 'region_id', 'product_id')->get();
        $dataArray = [];

        $lastId = 1;

        foreach ($data as $item) {
            $dataArray[$item->product_id][$item->region_id] = $item->id;
            $lastId = $item->id;
        }
        return [
            'data' => $dataArray,
            'last_id' => $lastId,
        ];
    }


    // Проверяем существование пары region_id, product_id, если есть - возвращаем id

    /**
     * @param array $data
     * @param int $productId
     * @param int $regionId
     * @return int
     */
    public function findIdByRegionIdProductId(array $data, int $productId, int $regionId): int
    {
        return $data[$productId][$regionId] ?? 0;
    }

    // Формируем сырой запрос массовой вставки/обновления

    /**
     * @param array $products
     * @param array $dbData
     * @return string
     */
    public function buildSqlUpdate(array $products, array $dbData): string
    {
        $idLast = $dbData['last_id'];

        $sql = [];
        $sql[] = "INSERT INTO `prices` (id, product_id, region_id, purchase, selling, discount)";
        $sql[] = "VALUES";
        $values = [];

        foreach ($products as $product) {
            $productId = $product['product_id'];
            $pricesData = $product['prices'];

            foreach ($pricesData as $regionId => $priceContent) {
                $idRecord = $this->findIdByRegionIdProductId($dbData['data'], $productId, $regionId);

                if ($idRecord !== 0) {
                    $i = $idRecord;
                } else {
                    $i = $idLast + 1;
                    $idLast++;
                }

                $purchase = $priceContent['price_purchase'];
                $selling = $priceContent['price_selling'];
                $discount = $priceContent['price_discount'];

                $values[] = "({$i}, {$productId}, {$regionId}, {$purchase}, {$selling}, {$discount})";
            }
        }

        $sql[] = implode(',', $values);
        $sql[] = "ON DUPLICATE KEY";
        $sql[] = "UPDATE";
        $sql[] = "purchase=VALUES(purchase),";
        $sql[] = "selling=VALUES(selling),";
        $sql[] = "discount=VALUES(discount)";

        return implode(' ', $sql);
    }

    public function store(array $products): array
    {
        $dbData = $this->getPricesDbData();
        $sql = $this->buildSqlUpdate($products, $dbData);
        DB::statement($sql);
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
