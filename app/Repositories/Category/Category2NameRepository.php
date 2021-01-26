<?php

namespace App\Repositories\Category;

use App\Models\Category\Category2Name;
use App\Repositories\Repository;

class Category2NameRepository
{
    use Repository;

    public function __construct()
    {
        $this->setEntity(Category2Name::class);
    }

    public function countWhereCategory2NameWhereNotId($name, $id)
    {
        return Category2Name::where('category2_name', $name)->where('id', '!=', $id)->count();
    }
}
