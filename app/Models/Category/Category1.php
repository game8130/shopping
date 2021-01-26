<?php

namespace App\Models\Category;

use App\Models\LumenShoppingModel;

class Category1 extends LumenShoppingModel
{
    protected $table = 'category1';
    protected $fillable = ['category1_name'];

    public function category2()
    {
        return $this->hasMany(Category2::class, 'category1_id' , 'id')
            ->join('category2_name', 'category2.category2_name_id', '=', 'category2_name.id');
    }
}
