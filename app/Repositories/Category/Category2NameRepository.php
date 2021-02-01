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

    /**
     * 取得下拉式選單資料
     *
     * @return array
     */
    public function dropdown()
    {
        return Category2Name::select('id', 'category2_name as name')->orderBy('id', 'ASC')->get()->toArray();
    }

    public function countWhereCategory2NameWhereNotId($name, $id)
    {
        return Category2Name::where('category2_name', $name)->where('id', '!=', $id)->count();
    }
}
