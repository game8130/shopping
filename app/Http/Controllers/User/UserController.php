<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\User\UserServices;

class UserController extends Controller
{
    private $userServices;

    public function __construct(UserServices $userServices)
    {
        $this->userServices = $userServices;
    }

    /**
     * 登入檢查
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function information(Request $request)
    {
        return $this->responseWithJson($request, $this->userServices->information());
    }

    /**
     * 系統登出
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function logout(Request $request)
    {
        return $this->responseWithJson($request, $this->userServices->logout($request->ip()));
    }
}
