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
}
