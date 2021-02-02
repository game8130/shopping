<?php

namespace App\Http\Controllers\ShoppingCart;

use App\Services\ShoppingCart\ShoppingCartServices;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;

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

    /**
     * 刪除
     *
     * @param Request $request
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function destroy(Request $request, $id)
    {
        $request['id'] = $id;
        $this->validate($request, [
            'id' => ['required',
                Rule::exists('shopping_cart')->where(function ($query) use($request) {
                    return $query->where('user_id', $request['jwt_user']['id']);
            }),],
        ]);
        return $this->responseWithJson($request, $this->shoppingCartServices->destroy($request->all()));
    }
}
