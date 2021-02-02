<?php

namespace App\Http\Controllers\ShoppingCart;

use App\Services\ShoppingCart\ShoppingCartServices;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ShoppingCartController extends Controller
{
    private $shoppingCartServices;

    public function __construct(ShoppingCartServices $shoppingCartServices)
    {
        $this->shoppingCartServices = $shoppingCartServices;
    }

    /**
     * 查詢
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function index(Request $request)
    {
        return $this->responseWithJson($request, $this->shoppingCartServices->index($request->all()));
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
            'uuid' => 'required|exists:product,uuid',
            'number' => 'required|numeric|min:1|not_in:0',
        ]);
        return $this->responseWithJson($request, $this->shoppingCartServices->store($request->all()));
    }
}
