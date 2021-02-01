<?php

namespace App\Repositories\Product;

use App\Models\Product\Product;
use App\Repositories\Repository;

class ProductRepository
{
    use Repository;

    public function __construct()
    {
        $this->setEntity(Product::class);
    }

    /**
     * @param $uuid
     * @return mixed
     */
    public function paginateJoinCategory3($uuid)
    {
        return Product::select('product.*')->where('category3.uuid', $uuid)
            ->join('category3', 'category3.id', '=', 'product.category3_id')
            ->paginate(config('common.web.paginate'));
    }
}
