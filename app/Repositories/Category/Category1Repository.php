<?php

namespace App\Repositories\Category;

use App\Models\Category\Category1;
use App\Repositories\Repository;

class Category1Repository
{
    use Repository;

    public function __construct()
    {
        $this->setEntity(Category1::class);
    }

    public function getWithAll()
    {
        return Category1::with(['category2' => function ($query) {
            $query->with(['category3']);
        }])->get();
    }
}
