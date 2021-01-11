<?php

namespace App\Repositories\Level;

use App\Models\Level\Levels;
use App\Repositories\Repository;

class LevelsRepository
{
    use Repository;

    public function __construct()
    {
        $this->setEntity(Levels::class);
    }

    /**
     * 取得下拉式選單資料
     *
     * @return array
     */
    public function dropdown()
    {
        return Groups::select('id', 'name')->orderBy('id', 'DESC')->get()->toArray();
    }
}
