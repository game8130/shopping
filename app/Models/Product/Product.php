<?php

namespace App\Models\Product;

use App\Models\LumenShoppingModel;

class Product extends LumenShoppingModel
{
    protected $table = 'product';
    protected $fillable = ['uuid', 'category3_id', 'name', 'description',
        'suggested_price', 'price', 'residual'];
}
