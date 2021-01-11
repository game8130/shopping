<?php

namespace App\Repositories\User;

use App\Models\User\UsersLogin;
use App\Repositories\Repository;

class UsersLoginRepository
{
    use Repository;

    public function __construct()
    {
        $this->setEntity(UsersLogin::class);
    }

    /**
     * @param array $parameters
     * @return mixed
     */
    public function list(array $parameters)
    {
        $query = UsersLogin::whereBetween('created_at', [$parameters['start_at'] . ' 00:00:00', $parameters['end_at'] . ' 23:59:59']);
        // 搜尋條件
        if (!empty($parameters['user_id'])) {
            $query = $query->whereIn('user_id', $parameters['user_id']);
        }
        // IP 搜尋
        if (!empty($parameters['login_ip'])) {
            $query = $query->where('login_ip', $parameters['login_ip']);
        }
        return $this->sortByAndItemsPerPage($query, $parameters);
    }
}
