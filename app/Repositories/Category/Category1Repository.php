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

    /**
     * 取得下拉式選單資料
     *
     * @return array
     */
    public function dropdown()
    {
        return Category1::select('id', 'category1_name as name')->orderBy('id', 'ASC')->get()->toArray();
    }

    public function getWithAll()
    {
        return Category1::with(['category2' => function ($query) {
            $query->with(['category3']);
        }])->get();
    }
}
