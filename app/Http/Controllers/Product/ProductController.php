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
     * 查詢
     *
     * @param Request $request
     * @param $category3_uuid
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function index(Request $request, $category3_uuid)
    {
        $request['uuid'] = $category3_uuid;
        $this->validate($request, [
            'uuid' => 'required|exists:category3,uuid',
        ]);
        return $this->responseWithJson($request, $this->productServices->index($request->all()));
    }

}
