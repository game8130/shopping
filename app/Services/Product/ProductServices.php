<?php

namespace App\Services\Product;

use App\Repositories\Product\ProductRepository;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ProductServices
{
    private $productRepository;

    public function __construct(
        ProductRepository $productRepository
    ) {
        $this->productRepository = $productRepository;
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

    /**
     * @param array $request
     * @return array
     */
    public function detail(array $request)
    {
        try {
            return [
                'code'   => config('apiCode.success'),
                'result' => $this->productRepository->firstWhereUuidWith($request['uuid']),
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
            $fileName = '';
            if(isset($request['image'])) {
                $Ym = Carbon::today()->format('Ym');
                $storagePath = Storage::put('/public/product/' . $Ym, $request['image']);
                $fileName = 'product/' . $Ym . '/' . basename($storagePath);
            }
            return [
                'code'   => config('apiCode.success'),
                'result' => $this->productRepository->store([
                    'category3_id'    => $request['category3_id'],
                    'uuid'            => (string) Str::uuid(),
                    'image'           => $fileName,
                    'name'            => $request['name'],
                    'description'     => $request['description'],
                    'suggested_price' => $request['suggested_price'],
                    'price'           => $request['price'],
                    'residual'        => $request['residual'],
                    'active'          => $request['active'],
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
            $fileName = '';
            if(isset($request['image'])) {
                $Ym = Carbon::today()->format('Ym');
                $storagePath = Storage::put('/public/product/' . $Ym, $request['image']);
                $fileName = 'product/' . $Ym . '/' . basename($storagePath);
            }
            return [
                'code'   => config('apiCode.success'),
                'result' => $this->productRepository->updateWhereUuid($request['uuid'], [
                    'category3_id'    => $request['category3_id'],
                    'uuid'            => (string) Str::uuid(),
                    'image'           => $fileName,
                    'name'            => $request['name'],
                    'description'     => $request['description'],
                    'suggested_price' => $request['suggested_price'],
                    'price'           => $request['price'],
                    'residual'        => $request['residual'],
                    'active'          => $request['active'],
                ]),
            ];
        } catch (\Exception $e) {
            return [
                'code'  => $e->getCode() ?? config('apiCode.notAPICode'),
                'error' => $e->getMessage(),
            ];
        }
    }
}
