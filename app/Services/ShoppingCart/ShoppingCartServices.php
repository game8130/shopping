<?php

namespace App\Services\ShoppingCart;

use App\Repositories\ShoppingCart\ShoppingCartRepository;
use Tymon\JWTAuth\JWTAuth;

class ShoppingCartServices
{
    protected $JWTAuth;

    private $shoppingCartRepository;

    public function __construct(
        JWTAuth $JWTAuth,
        ShoppingCartRepository $shoppingCartRepository
    ) {
        $this->JWTAuth = $JWTAuth;
        $this->shoppingCartRepository = $shoppingCartRepository;
    }

    /**
     * @param array $request
     * @return array
     */
    public function index(array $request)
    {
        try {
            $user = $this->JWTAuth->parseToken()->authenticate();
            return [
                'code'   => config('apiCode.success'),
                'result' => $this->shoppingCartRepository->getWithProduct($user['id']),
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
            $user = $this->JWTAuth->parseToken()->authenticate();
            $shopping = $this->shoppingCartRepository->firstWhereUserId($user['id'], $request['uuid']);
            if(empty($shopping)) {
                $this->shoppingCartRepository->store([
                    'user_id' => $user['id'],
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
}
