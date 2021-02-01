<?php

namespace App\Services\Product;

use App\Repositories\Product\ProductRepository;
use App\Repositories\Category\Category3Repository;

class ProductServices
{
    private $productRepository;
    private $category3Repository;

    public function __construct(
        ProductRepository $productRepository,
        Category3Repository $category3Repository
    ) {
        $this->productRepository = $productRepository;
        $this->category3Repository = $category3Repository;
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
                'result' => $this->productRepository->paginateJoinCategory3($request['uuid']),
            ];
        } catch (\Exception $e) {
            return [
                'code'  => $e->getCode() ?? config('apiCode.notAPICode'),
                'error' => $e->getMessage(),
            ];
        }
    }
}
