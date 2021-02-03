<?php

namespace App\Repositories\Category;

use App\Models\Category\Category2;
use App\Repositories\Repository;

class Category2Repository
{
    use Repository;

    public function __construct()
    {
        $this->setEntity(Category2::class);
    }

    /**
     * @param array $parameters
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getJoinAll()
    {
        return Category2::join('category2_name', 'category2.category2_name_id', '=', 'category2_name.id')
            ->join('category1', 'category2.category1_id', '=', 'category1.id')
            ->select('category2.id', 'category2.category1_id', 'category2.category2_name_id', 'category2_name.category2_name', 'category1.category1_name')
            ->get();
    }
}
