<?php

namespace App\Models\ShoppingCart;

use App\Models\LumenShoppingModel;
use App\Models\Product\Product;

class ShoppingCart extends LumenShoppingModel
{
    protected $table = 'shopping_cart';
    protected $fillable = ['user_id', 'product_uuid', 'number'];

    /**
     * 取得對應的權限資訊
     *
     * @return mixed
     */
    public function product()
    {
        return $this->hasOne(Product::class, 'uuid', 'product_uuid');
    }
}
