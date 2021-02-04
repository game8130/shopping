<?php

namespace App\Http\Controllers\System;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Services\System\SystemServices;

class SystemController extends Controller
{
    private $systemsServices;

    public function __construct(SystemServices $SystemsServices)
    {
        $this->systemsServices = $SystemsServices;
    }
    /**
     * 自訂驗證
     */
    public function validatorExtend() {
        // 驗證碼檢查
        app('validator')->extend('captcha_api', function ($message, $attribute, $rule, $parameters) {
            return app('captcha')->check($attribute, $rule[0]);
        });
    }

    /**
     * 登入驗證
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function login(Request $request)
    {
        $this->validatorExtend();
        $this->validate($request, [
            'account'  => 'required|between:3,20',
            'password' => 'required|alpha_dash|between:6,20',
            'captcha'  => 'required|captcha_api:' . $request['key'],
        ],[
            'captcha.captcha_api' => '驗證碼錯誤'
        ]);
        return $this->responseWithJson($request, $this->systemsServices->login($request->all(), $request->ip()));
    }

    /**
     * 註冊
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function register(Request $request)
    {
        $this->validate($request, [
            'account'  => 'required|between:3,20|unique:users,account',
            'email'    => 'required|email|unique:users,email',
            'phone'    => 'required|max:10|unique:users,phone',
            'name'     => 'required|max:30',
            'password' => 'required|alpha_dash|between:6,20|confirmed',
        ]);
        return $this->responseWithJson($request, $this->systemsServices->register($request->all()));
    }
}
