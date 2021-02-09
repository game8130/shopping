<?php

namespace App\Models\Product;

use App\Models\LumenShoppingModel;
use App\Models\Category\Category3;

class Product extends LumenShoppingModel
{
    protected $table = 'product';
    protected $fillable = ['uuid', 'category3_id', 'image', 'name', 'description',
        'suggested_price', 'price', 'residual', 'active'];

    public function category3()
    {
        return $this->hasOne(Category3::class, 'id', 'category3_id')
            ->join('category3_name', 'category3.category3_name_id', '=', 'category3_name.id')
            ->select(['category3.*', 'category3_name.category3_name']);
    }
}
