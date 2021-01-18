<?php

namespace App\Services\User;

use App\Repositories\User\UsersRepository;
use App\Repositories\Group\GroupsRepository;
use App\Services\System\SystemLoginServices;
use App\Services\Common\IpToAreaServices;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\JWTAuth;

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
}
