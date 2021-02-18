<?php

namespace App\Http\Controllers\Product;

use App\Services\Product\ProductServices;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    private $productServices;

    public function __construct(ProductServices $productServices)
    {
        $this->productServices = $productServices;
    }

    /**
     * 搜尋
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function search(Request $request)
    {
        return $this->responseWithJson($request, $this->productServices->search($request->all()));
    }

    /**
     * 查詢
     *
     * @param Request $request
     * @param $active
     * @param $category3_uuid
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function index(Request $request, $active, $category3_uuid)
    {
        $request['active'] = $active;
        $request['uuid'] = $category3_uuid;
        $this->validate($request, [
            'active' => 'required|in:0,1',
            'uuid' => 'required|exists:category3,uuid',
        ]);
        return $this->responseWithJson($request, $this->productServices->index($request->all()));
    }

    /**
     * 詳情
     *
     * @param Request $request
     * @param $product_uuid
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function detail(Request $request, $product_uuid)
    {
        $request['uuid'] = $product_uuid;
        $this->validate($request, [
            'uuid' => 'required|exists:product,uuid',
        ]);
        return $this->responseWithJson($request, $this->productServices->detail($request->all()));
    }

    /**
     * 新增
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'category3_uuid' => 'required|exists:category3,uuid',
            'image' => 'required|mimes:jpeg,bmp,png,jpg',
            'name' => 'required|max:60',
            'description' => 'required',
            'suggested_price' => 'required|numeric',
            'price' => 'required|numeric',
            'residual' => 'required|numeric',
            'active'   => 'required|in:1,2',
        ]);
        return $this->responseWithJson($request, $this->productServices->store($request->all()));
    }

    /**
     * 修改
     *
     * @param Request $request
     * @param $product_uuid
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, $product_uuid)
    {
        $request['uuid'] = $product_uuid;
        $this->validate($request, [
            'uuid' => 'required|exists:product,uuid',
            'category3_uuid' => 'required|exists:category3,uuid',
            'name' => 'required|max:60',
            'description' => 'required',
            'suggested_price' => 'required|numeric',
            'price' => 'required|numeric',
            'residual' => 'required|numeric',
            'active'   => 'required|in:1,2'
        ]);
        return $this->responseWithJson($request, $this->productServices->update($request->all()));
    }
}
