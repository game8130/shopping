<?php

namespace App\Services\System;

use App\Repositories\User\UsersRepository;
use App\Repositories\Level\LevelsRepository;
use App\Repositories\Group\GroupsRepository;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\JWTAuth;
use Illuminate\Support\Facades\Hash;

class SystemServices
{
    protected $JWTAuth;

    private $usersRepository;
    private $levelsRepository;
    private $groupsRepository;
    private $systemLoginServices;

    public function __construct(
        JWTAuth $JWTAuth,
        UsersRepository $usersRepository,
        LevelsRepository $levelsRepository,
        GroupsRepository $groupsRepository,
        SystemLoginServices $systemLoginServices

    ) {
        $this->JWTAuth = $JWTAuth;
        $this->usersRepository = $usersRepository;
        $this->levelsRepository = $levelsRepository;
        $this->groupsRepository = $groupsRepository;
        $this->systemLoginServices = $systemLoginServices;
    }

    /**
     * 登入驗證
     *
     * @param  array  $request
     * @param  string $ip
     * @return array
     */
    public function login(array $request, $ip)
    {
        $user = [];
        // 驗證帳號密碼是否正確
        try {
            if (!$user['token'] = $this->JWTAuth->attempt([
                'account'  => $request['account'],
                'password' => $request['password'],
                'active'   => 1,
            ])) {
                return [
                    'code'  => config('apiCode.invalidCredentials'),
                    'error' => '登入失敗帳號密碼錯誤',
                ];
            }
        } catch (JWTException $e) {
            return [
                'code'  => config('apiCode.couldNotCreateToken'),
                'error' => 'could not create token',
            ];
        }

        // 取得 token 並更新該人員 token 資訊
        try {
            $user['user'] = $this->JWTAuth->setToken($user['token'])->toUser();
            // 黑名單之前 token
//            $this->JWTAuth->setToken($user['user']['token'])->invalidate();
            $this->usersRepository->update($user['user']->id, ['token' => $user['token'], 'login_at' => Carbon::now()->toDateTimeString()]);
            $this->systemLoginServices->storeLogin(['id' => $user['user']->id, 'account' => $request['account']], $ip);
            return [
                'code'   => config('apiCode.success'),
                'result' => $user,
            ];
        } catch (\Exception $e) {
            return [
                'code'  => $e->getCode() ?? config('apiCode.notAPICode'),
                'error' => $e->getMessage(),
            ];
        }
    }

    /**
     * 註冊
     *
     * @param  array  $request
     * @return array
     */
    public function register(array $request)
    {
        try {
            $level = $this->levelsRepository->checkFieldExist('name', config('default.levels')[0]['name']);
            $group = $this->groupsRepository->checkFieldExist('name', config('default.generalGroupName'));
            $user = $this->usersRepository->store([
                'group_id'      => $group[0]->id,
                'level_id'      => $level[0]->id,
                'uuid'          => (string) Str::uuid(),
                'account'       => $request['account'],
                'email'         => $request['email'],
                'password'      => app('hash')->make(config('default.adminPassword')),
                'name'          => $request['name'],
                'active'        => 1,
                'token'         => '',
                'phone'         => $request['phone'],
            ]);

            return [
                'code'   => config('apiCode.success'),
                'result' => $user,
            ];
        } catch (\Exception $e) {
            return [
                'code'  => $e->getCode() ?? config('apiCode.notAPICode'),
                'error' => $e->getMessage(),
            ];
        }
    }
}
