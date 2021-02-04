<?php

namespace App\Services\User;

use App\Repositories\User\UsersLoginRepository;

class UserLoginServices
{
    private $usersLoginRepository;

    public function __construct(
        UsersLoginRepository $usersLoginRepository
    ) {
        $this->usersLoginRepository = $usersLoginRepository;
    }


    /**
     * 登入日誌-列表
     *
     * @param  array  $request
     * @return array
     */
    public function index(array $request)
    {
        try {
            return [
                'code'   => config('apiCode.success'),
                'result' => $this->usersLoginRepository->list($request),
            ];
        } catch (\Exception $e) {
            return [
                'code'  => $e->getCode() ?? config('apiCode.notAPICode'),
                'error' => $e->getMessage(),
            ];
        }
    }
}
