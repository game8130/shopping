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
}
