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

    /**
     * 取得下拉式選單資料
     *
     * @return array
     */
    public function dropdown()
    {
        return Category3Name::select('id', 'category3_name as name')->orderBy('id', 'ASC')->get()->toArray();
    }
}
