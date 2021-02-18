<?php

namespace App\Repositories\Product;

use App\Models\Product\Product;
use App\Repositories\Repository;

class ProductRepository
{
    use Repository;

    public function __construct()
    {
        $this->setEntity(Product::class);
    }

    /**
     * @param $request
     * @return mixed
     */
    public function paginateJoinCategory3($request)
    {
        $product = Product::select('product.*')->where('category3.uuid', $request['uuid'])
            ->join('category3', 'category3.id', '=', 'product.category3_id');
        if($request['active'] == 1) {
            $product->where('active', 1);
        }
        return $product->paginate(config('common.web.paginate'));
    }

    /**
     * @param $uuid
     * @return mixed
     */
    public function firstWhereUuidWith($uuid)
    {
        return Product::where('uuid', $uuid)->with(['category3' => function ($query) {
            $query->with(['category2']);
        }])->first();
    }

    /**
     * @param string $uuid
     * @param array $parameters
     * @return mixed
     */
    public function updateWhereUuid($uuid, array $parameters = [])
    {
        return Product::where('uuid', $uuid)->update($parameters);
    }

    /**
     * @param string $name
     * @return mixed
     */
    public function getWhereName($name)
    {
        return Product::where('name','like','%'.$name.'%')
            ->paginate(config('common.web.paginate'))
            ->appends(['q' => $name]);
    }
}
