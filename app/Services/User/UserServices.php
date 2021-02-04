<?php

namespace App\Services\User;

use App\Repositories\User\UsersRepository;
use App\Repositories\Group\GroupsRepository;
use App\Services\System\SystemLoginServices;
use App\Services\Common\IpToAreaServices;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\JWTAuth;
use Illuminate\Support\Str;

class UserServices
{
    protected $JWTAuth;

    private $usersRepository;
    private $groupsRepository;
    private $ipToAreaServices;
    private $systemLoginServices;

    public function __construct(
        JWTAuth $JWTAuth,
        UsersRepository $usersRepository,
        GroupsRepository $groupsRepository,
        IpToAreaServices $ipToAreaServices,
        SystemLoginServices $systemLoginServices
    ) {
        $this->JWTAuth = $JWTAuth;
        $this->usersRepository = $usersRepository;
        $this->groupsRepository = $groupsRepository;
        $this->ipToAreaServices = $ipToAreaServices;
        $this->systemLoginServices = $systemLoginServices;
    }

    /**
     * 取得目前帳號詳細資訊
     *
     * @return array
     */
    public function information()
    {
        try {
            $user = $this->JWTAuth->parseToken()->authenticate();
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
     * 系統登出
     *
     * @param  string  $ip
     * @return array
     */
    public function logout($ip)
    {
        try {
            $user = $this->JWTAuth->parseToken()->authenticate();
            $this->updateUserToken($user['id'], $user['token'], '');
            $this->systemLoginServices->storeLogin($user, $ip, 2);
            return [
                'code'   => config('apiCode.success'),
                'result' => true,
            ];
        } catch (\Exception $e) {
            return [
                'code'  => $e->getCode() ?? config('apiCode.notAPICode'),
                'error' => $e->getMessage(),
            ];
        }
    }

    /**
     * 系統自動將帳號自動登出
     *
     * @param array $user
     */
    public function kickerUser($user)
    {
        $this->updateUserToken($user['id'], $user['token'], '');
        $this->systemLoginServices->storeLogin($user, '', 3);
    }

    /**
     * 更新帳號Token資訊
     *
     * @param integer $userID
     * @param string  $oldToken
     * @param string  $newToken
     */
    public function updateUserToken($userID, $oldToken, $newToken)
    {
        try {
            $this->JWTAuth->setToken($oldToken)->invalidate();
            $this->usersRepository->update($userID, [
                'token' => $newToken
            ]);
        } catch (TokenExpiredException $e) {
            $this->usersRepository->update($userID, [
                'token' => $newToken
            ]);
        } catch (JWTException $e) {
            $this->usersRepository->update($userID, [
                'token' => $newToken
            ]);
        }
    }

    /**
     * 人員管理-列表
     *
     * @param  array  $request
     * @return array
     */
    public function index(array $request = [])
    {
        try {
            return [
                'code'   => config('apiCode.success'),
                'result' => $this->usersRepository->list($request),
            ];
        } catch (\Exception $e) {
            return [
                'code'  => $e->getCode() ?? config('apiCode.notAPICode'),
                'error' => $e->getMessage(),
            ];
        }
    }

    /**
     * 人員管理-新增
     *
     * @param array $request
     * @return array
     */
    public function store(array $request)
    {
        try {
            $user = $this->usersRepository->store([
                'group_id'      => $request['group_id'],
                'level_id'      => $request['level_id'],
                'uuid'          => (string) Str::uuid(),
                'account'       => $request['account'],
                'email'         => $request['email'],
                'password'      => app('hash')->make(config('default.adminPassword')),
                'name'          => $request['name'],
                'phone'          => $request['phone'],
                'active'        => 1,
                'token'         => '',
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

    /**
     * 人員管理-修改
     *
     * @param array $request
     * @return array
     */
    public function update(array $request)
    {
        try {
            $clearToken = false;
            $user = $this->usersRepository->getByUuid($request['uuid']);
            // 最高管理員無法修改
            if (in_array($user['account'], [config('default.adminAccount')])) {
                return [
                    'code' => config('apiCode.unchangeable'),
                    'error' => 'The data unchangeable',
                ];
            }
            if (isset($request['password']) && $request['password'] != "") {
                $request['password'] = app('hash')->make($request['password']);
                $clearToken = true;
            } else {
                unset($request['password']);
                unset($request['password_confirmation']);
            }
            $this->usersRepository->update($user['id'], $request);
            // 刪除token
            if ($clearToken) {
                $this->kickerUser($user);
            }
            return [
                'code'   => config('apiCode.success'),
                'result' => true,
            ];
        } catch (\Exception $e) {
            return [
                'code'  => $e->getCode() ?? config('apiCode.notAPICode'),
                'error' => $e->getMessage(),
            ];
        }
    }

    /**
     * 人員管理-刪除
     *
     * @param array $request
     * @return array
     */
    public function destroy(array $request)
    {
        try {
            $user = $this->usersRepository->getByUuid($request['uuid']);
            // 最高管理員無法刪除
            if (in_array($user['account'], [config('default.adminAccount')])) {
                return [
                    'code' => config('apiCode.unchangeable'),
                    'error' => 'The data unchangeable',
                ];
            }
            $this->usersRepository->update($user['id'], ['active' => 3]);
            return [
                'code'   => config('apiCode.success'),
                'result' => $this->usersRepository->destroy($user['id']),
            ];
        } catch (\Exception $e) {
            return [
                'code'  => $e->getCode() ?? config('apiCode.notAPICode'),
                'error' => $e->getMessage(),
            ];
        }
    }

    /**
     * 人員管理-取得單一資料
     *
     * @param  array  $request
     * @return array
     */
    public function single(array $request = [])
    {
        try {
            $user = $this->usersRepository->firstByUuidWith($request['uuid']);
            $user['leave'] = null;
            if (!empty($user['information']['annual_leave_date'])) {
                $diffInDays = Carbon::today()->diffInDays($user['information']['annual_leave_date']);
                if ($diffInDays < 183) {
                    $startDate = Carbon::parse($user['information']['annual_leave_date'])->toDateString();
                    $endDate = Carbon::parse($user['information']['annual_leave_date'])->addMonths(6)->subDay()->toDateString();
                } else if ($diffInDays >= 183 && $diffInDays < 365) {
                    $startDate = Carbon::parse($user['information']['annual_leave_date'])->addMonths(6)->toDateString();
                    $endDate = Carbon::parse($user['information']['annual_leave_date'])->addYear()->subDay()->toDateString();
                } else {
                    $dt = Carbon::parse($user['information']['annual_leave_date']);
                    $today = Carbon::today();
                    if ($today->toDateString() >= Carbon::create($today->year, $dt->month, $dt->day)->toDateString()) {
                        $startDate = Carbon::create($today->year, $dt->month, $dt->day)->toDateString();
                        $endDate = Carbon::create($today->year, $dt->month, $dt->day)->addYear()->subDay()->toDateString();
                    } else {
                        $startDate = Carbon::create($today->year, $dt->month, $dt->day)->subYear()->toDateString();
                        $endDate = Carbon::create($today->year, $dt->month, $dt->day)->subDay()->toDateString();
                    }
                }
                $leaves = $this->leaveRepository->getByWhereInGroupLeaveId($user['id'], $startDate, $endDate);
                $groupLeave = $this->groupLeaveRepository->getKeyById();
                foreach ($leaves as $key => $value) {
                    $leaves[$key]['name'] = $groupLeave[$value['group_leave_id']]['name'];
                }
                $user['leave'] = $leaves;
            }
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
