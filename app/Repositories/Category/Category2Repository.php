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
}
