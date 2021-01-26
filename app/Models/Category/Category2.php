<?php

namespace App\Models\Category;

use App\Models\LumenShoppingModel;

class Category2 extends LumenShoppingModel
{
    protected $table = 'category2';
    protected $fillable = ['category1_id', 'category2_name_id'];
    
    public function category2_name()
    {
        return $this->hasOne(Category2Name::class, 'id' , 'category2_name_id')->select('id', 'category2_name as name');
    }

    public function category1()
    {
        return $this->hasOne(Category1::class, 'id' , 'category1_id')->select('id', 'category1_name as name');
    }
}
