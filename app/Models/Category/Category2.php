<?php

namespace App\Models\Category;

use App\Models\LumenShoppingModel;


class Category2 extends LumenShoppingModel
{
    protected $table = 'category2';
    protected $fillable = ['name', 'uuid', 'category1_id'];
}
