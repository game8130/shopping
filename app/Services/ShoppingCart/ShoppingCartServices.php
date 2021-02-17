<?php

namespace App\Services\ShoppingCart;

use App\Repositories\ShoppingCart\ShoppingCartRepository;

class ShoppingCartServices
{
    private $shoppingCartRepository;

    public function __construct(
        ShoppingCartRepository $shoppingCartRepository
    ) {
        $this->shoppingCartRepository = $shoppingCartRepository;
    }

    /**
     * @param array $request
     * @return array
     */
    public function index(array $request)
    {
        try {
            $shoppingCarts = $this->shoppingCartRepository->getWithProduct($request['jwt_user']['id']);
            $number = $suggestedPrice = $price = 0;
            foreach ($shoppingCarts as $shoppingCart) {
                $number += $shoppingCart['number'];
                $suggestedPrice += $shoppingCart['number'] * $shoppingCart['product']['suggested_price'];
                $price += $shoppingCart['number'] * $shoppingCart['product']['price'];
            }
            return [
                'code'   => config('apiCode.success'),
                'result' => [
                    'data' => $shoppingCarts,
                    'total' => [
                        'number' => $number,
                        'suggested_price' => $suggestedPrice,
                        'price' => $price,
                    ]
                ],
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
            $shopping = $this->shoppingCartRepository->firstWhereUserId($request['jwt_user']['id'], $request['uuid']);
            if(empty($shopping)) {
                $this->shoppingCartRepository->store([
                    'user_id' => $request['jwt_user']['id'],
                    'product_uuid' => $request['uuid'],
                    'number' => $request['number'],
                ]);
            } else {
                $this->shoppingCartRepository->update($shopping['id'],
                    ['number' => $shopping['number'] + $request['number']]);
            }

            return [
                'code'   => config('apiCode.success'),
                'result' => true
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
                'result' => $this->shoppingCartRepository->destroy($request['id'])
            ];
        } catch (\Exception $e) {
            return [
                'code'  => $e->getCode() ?? config('apiCode.notAPICode'),
                'error' => $e->getMessage(),
            ];
        }
    }
}
