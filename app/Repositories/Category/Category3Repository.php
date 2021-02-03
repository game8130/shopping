<?php

namespace App\Repositories\Category;

use App\Models\Category\Category3;
use App\Repositories\Repository;

class Category3Repository
{
    use Repository;

    public function __construct()
    {
        $this->setEntity(Category3::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getJoinAll()
    {
        return Category3::join('category3_name', 'category3.category3_name_id', '=', 'category3_name.id')
        ->join('category2', 'category3.category2_id', '=', 'category2.id')
        ->join('category2_name', 'category2_name.id', '=', 'category2.category2_name_id')
        ->select('category3.id', 'category3.category2_id', 'category3.category3_name_id', 'category3.uuid', 'category3_name.category3_name', 'category2_name.category2_name')
        ->get();
    }
}
