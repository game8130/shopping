<?php

namespace App\Services\Category;

use Illuminate\Support\Str;
use App\Repositories\Category\Category1Repository;
use App\Repositories\Category\Category2Repository;
use App\Repositories\Category\Category3Repository;
use App\Repositories\Category\Category3NameRepository;

class Category3Services
{
    private $category1Repository;
    private $category2Repository;
    private $category3Repository;
    private $category3NameRepository;

    public function __construct(
        Category1Repository $category1Repository,
        Category2Repository $category2Repository,
        Category3Repository $category3Repository,
        Category3NameRepository $category3NameRepository
    ) {
        $this->category1Repository = $category1Repository;
        $this->category2Repository = $category2Repository;
        $this->category3Repository = $category3Repository;
        $this->category3NameRepository = $category3NameRepository;
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
                'result' => $this->category3Repository->getJoinAll(),
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
            $category3Name = $this->category3NameRepository->firstOrCreate(['category3_name' => $request['category3_name']]);
            return [
                'code'   => config('apiCode.success'),
                'result' => $this->category3Repository->store([
                    'uuid' => (string) Str::uuid(),
                    'category3_name_id' => $category3Name['id'],
                    'category2_id' => $request['category2_id'],
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
            $category3Name = $this->category3NameRepository->firstOrCreate(['category3_name' => $request['category3_name']]);
            return [
                'code'   => config('apiCode.success'),
                'result' => $this->category3Repository->update($request['id'], [
                    'category2_id' => $request['category2_id'],
                    'category3_name_id' => $category3Name['id']
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
