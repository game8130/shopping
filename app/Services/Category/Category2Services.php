<?php

namespace App\Services\Category;

use App\Repositories\Category\Category1Repository;
use App\Repositories\Category\Category2Repository;
use App\Repositories\Category\Category3Repository;
use App\Repositories\Category\Category2NameRepository;

class Category2Services
{
    private $category1Repository;
    private $category2Repository;
    private $category3Repository;
    private $category2NameRepository;

    public function __construct(
        Category1Repository $category1Repository,
        Category2Repository $category2Repository,
        Category3Repository $category3Repository,
        Category2NameRepository $category2NameRepository
    ) {
        $this->category1Repository = $category1Repository;
        $this->category2Repository = $category2Repository;
        $this->category3Repository = $category3Repository;
        $this->category2NameRepository = $category2NameRepository;
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
                'result' => $this->category2Repository->getJoinAll(),
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
            $category2Name = $this->category2NameRepository->firstOrCreate(['category2_name' => $request['category2_name']]);
            return [
                'code'   => config('apiCode.success'),
                'result' => $this->category2Repository->store([
                    'category2_name_id' => $category2Name['id'],
                    'category1_id' => $request['category1_id'],
                ]),
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
            $category2Name = $this->category2NameRepository->firstOrCreate(['category2_name' => $request['category2_name']]);
            return [
                'code'   => config('apiCode.success'),
                'result' => $this->category2Repository->update($request['id'], [
                    'category1_id' => $request['category1_id'],
                    'category2_name_id' => $category2Name['id']
                ]),
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
            $category3 = $this->category3Repository->checkFieldExist('category2_id', $request['id']);
            if ($category3->count() != 0) {
                throw new \Exception('還有資料不可以刪除', config('apiCode.notRemove'));
            }
            return [
                'code'   => config('apiCode.success'),
                'result' => $this->category3Repository->destroy($request['id']),
            ];
        } catch (\Exception $e) {
            return [
                'code'  => $e->getCode() ?? config('apiCode.notAPICode'),
                'error' => $e->getMessage(),
            ];
        }
    }
}
