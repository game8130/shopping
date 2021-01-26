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
     * @param array $parameters
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getWithAll()
    {
        return Category3::with(['category3_name', 'category2'])->get();
    }
}
