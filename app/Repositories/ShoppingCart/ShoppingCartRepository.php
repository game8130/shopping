<?php

namespace App\Repositories\ShoppingCart;

use App\Models\ShoppingCart\ShoppingCart;
use App\Repositories\Repository;

class ShoppingCartRepository
{
    use Repository;

    public function __construct()
    {
        $this->setEntity(ShoppingCart::class);
    }

    /**
     * @param $uuid
     * @return mixed
     */
    public function firstWhereUserId($userId, $uuid)
    {
        return ShoppingCart::where('user_id', $userId)->where('product_uuid', $uuid)->first();
    }

    /**
     * @param $uuid
     * @return mixed
     */
    public function getWithProduct($userId)
    {
        return ShoppingCart::where('user_id', $userId)
        ->with('product')->get();
    }
}
