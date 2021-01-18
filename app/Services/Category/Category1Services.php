<?php

namespace App\Services\Category;

use App\Repositories\Category\Category1Repository;
use App\Repositories\Category\Category2Repository;

class Category1Services
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
                'result' => $this->category1Repository->getAll(),
            ];
        } catch (\Exception $e) {
            return [
                'code'  => $e->getCode() ?? config('apiCode.notAPICode'),
                'error' => $e->getMessage(),
            ];
        }
    }

    /**
     * @param array $request
     * @return array
     */
    public function store(array $request)
    {
        try {
            return [
                'code'   => config('apiCode.success'),
                'result' => $this->category1Repository->store(['name' => $request['name']]),
            ];
        } catch (\Exception $e) {
            return [
                'code'  => $e->getCode() ?? config('apiCode.notAPICode'),
                'error' => $e->getMessage(),
            ];
        }
    }

    /**
     * @param array $request
     * @return array
     */
    public function update(array $request)
    {
        try {
            return [
                'code'   => config('apiCode.success'),
                'result' => $this->category1Repository->update($request['id'], ['name' => $request['name']]),
            ];
        } catch (\Exception $e) {
            return [
                'code'  => $e->getCode() ?? config('apiCode.notAPICode'),
                'error' => $e->getMessage(),
            ];
        }
    }

    /**
     * @param array $request
     * @return array
     */
    public function destroy(array $request)
    {
        try {
            $category2 = $this->category2Repository->checkFieldExist('category1_id', $request['id']);
            if ($category2->count() != 0) {
                throw new \Exception('還有資料不可以刪除', config('apiCode.notRemove'));
            }
            return [
                'code'   => config('apiCode.success'),
                'result' => $this->category1Repository->destroy($request['id']),
            ];
        } catch (\Exception $e) {
            return [
                'code'  => $e->getCode() ?? config('apiCode.notAPICode'),
                'error' => $e->getMessage(),
            ];
        }
    }
}
