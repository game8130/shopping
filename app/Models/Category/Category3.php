<?php

namespace App\Models\Category;

use App\Models\LumenShoppingModel;
use App\Models\Product\Product;

class Category3 extends LumenShoppingModel
{
    protected $table = 'category3';
    protected $fillable = ['category2_id', 'category3_name_id', 'uuid'];

    // public function category3_name()
    // {
    //     return $this->hasOne(Category3Name::class, 'id' , 'category3_name_id')->select('id', 'category3_name as name');
    // }

    // public function category2()
    // {
    //     return $this->hasOne(Category2::class, 'id' , 'category2_id')
    //         ->join('category2_name', 'category2.category2_name_id', '=', 'category2_name.id');
    // }
}
