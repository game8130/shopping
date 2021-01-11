<?php

namespace App\Models\User;

use App\Models\LumenShoppingModel;

class UsersLogin extends LumenShoppingModel
{
    protected $table = 'users_login';
    protected $fillable = [
        'user_id', 'user_account', 'login_ip', 'device', 'device_info', 'area', 'status'
    ];
    protected $casts    = [
        'device_info' => 'array',
    ];
}
