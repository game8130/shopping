<?php

namespace App\Repositories\Category;

use App\Models\Category\Category3Name;
use App\Repositories\Repository;

class Category3NameRepository
{
    use Repository;

    public function __construct()
    {
        $this->setEntity(Category3Name::class);
    }
}
