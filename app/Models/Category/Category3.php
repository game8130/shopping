<?php

namespace App\Models\Category;

use App\Models\LumenShoppingModel;
use App\Models\Product\Product;

class Category3 extends LumenShoppingModel
{
    protected $table = 'category3';
    protected $fillable = ['category2_id', 'category3_name_id', 'uuid'];

     public function category2()
     {
         return $this->belongsTo(Category2::class, 'category2_id', 'id')
             ->join('category2_name', 'category2.category2_name_id', '=', 'category2_name.id')
             ->join('category1', 'category2.category1_id', '=', 'category1.id')
             ->select(['category2.*', 'category2_name.category2_name', 'category1.category1_name']);
     }
}
