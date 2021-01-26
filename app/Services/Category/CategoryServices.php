<?php

namespace App\Services\Category;

use App\Repositories\Category\Category1Repository;
use App\Repositories\Category\Category2Repository;

class CategoryServices
{
    private $category1Repository;
    private $category2Repository;

    public function __construct(
        Category1Repository $category1Repository,
        Category2Repository $category2Repository
    ) {
        $this->category1Repository = $category1Repository;
        $this->category2Repository = $category2Repository;
    }

    /**
     * @param array $request
     * @return array
     */
    public function index(array $request)
    {
        try {
            return [
                'code'   => config('apiCode.success'),
                'result' => $this->category1Repository->getWithAll(),
            ];
        } catch (\Exception $e) {
            return [
                'code'  => $e->getCode() ?? config('apiCode.notAPICode'),
                'error' => $e->getMessage(),
            ];
        }
    }
}
