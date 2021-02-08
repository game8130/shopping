<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\User\UserServices;
use Illuminate\Validation\Rule;

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
        return $this->responseWithJson($request, $this->userServices->information($request->all()));
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

    /**
     * 人員管理-列表
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        return $this->responseWithJson($request, $this->userServices->index($request->all()));
    }

    /**
     * 人員管理-新增
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'account'  => 'required|unique:users,account|between:3,20',
            'email'    => 'required|unique:users,email|email',
            'name'     => 'required|max:20',
            'group_id' => 'required|exists:groups,id',
            'level_id' => 'required|exists:levels,id',
            'phone'    => 'required|numeric',
        ]);
        return $this->responseWithJson($request, $this->userServices->store($request->all()));
    }

    /**
     * 人員管理-修改
     *
     * @param Request $request
     * @param string  $uuid
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $uuid)
    {
        $request['uuid'] = $uuid;
        $this->validate($request, [
            'uuid'     => 'required|exists:users,uuid',
            'group_id' => 'required|exists:groups,id',
            'level_id' => 'required|exists:levels,id',
            'active'   => 'in:1,2',
            'password' => 'alpha_dash|between:6,20|confirmed|nullable',
            'name'     => 'max:20',
            'phone'    => 'required|numeric',
            'email'    => [
                'email',
                Rule::unique('users', 'email')->ignore($uuid, 'uuid')
            ],
        ]);
        return $this->responseWithJson($request, $this->userServices->update($request->all()));
    }

    /**
     * 人員管理-刪除
     *
     * @param Request $request
     * @param string  $uuid
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request, $uuid)
    {
        $request['uuid'] = $uuid;
        $this->validate($request, [
            'uuid' => 'required|exists:users,uuid',
        ]);
        return $this->responseWithJson($request, $this->userServices->destroy($request->all()));
    }

    /**
     * 修改會員資料
     *
     * @param Request $request
     * @param string  $uuid
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateInformation(Request $request)
    {
        $request['uuid'] = $request['jwt_user']['uuid'];
        $this->validate($request, [
            'password' => 'alpha_dash|between:6,20|confirmed|nullable',
            'name'     => 'max:20',
            'phone'    => 'required|numeric',
            'email'    => [
                'email',
                Rule::unique('users', 'email')->ignore($request['uuid'], 'uuid')
            ],
        ]);
        return $this->responseWithJson($request, $this->userServices->update($request->all()));
    }

    /**
     * 人員管理-取得單一資料
     *
     * @param Request $request
     * @param string  $uuid
     * @return \Illuminate\Http\JsonResponse
     */
    public function single(Request $request, $uuid)
    {
        $request['uuid'] = $uuid;
        $this->validate($request, [
            'uuid' => 'required|exists:users,uuid',
        ]);
        return $this->responseWithJson($request, $this->userServices->single($request->all()));
    }
}
