<?php

namespace App\Models\User;

use App\Models\Group\Groups;
use App\Models\LumenShoppingModel;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Lumen\Auth\Authorizable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Users extends LumenShoppingModel implements AuthenticatableContract, AuthorizableContract, JWTSubject
{
    use Authenticatable, Authorizable, HasFactory;

    protected $table = 'users';

    protected $fillable = [
        'level_id', 'uuid', 'account', 'email', 'email_verified_at', 'password', 'name',
        'token', 'active', 'login_at', 'remember_token', 'phone'
    ];
    protected $hidden = ['password', 'token', 'remember_token'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $dates = ['deleted_at'];

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

//    /**
//     * 取得對應的權限資訊
//     *
//     * @return mixed
//     */
//    public function group()
//    {
//        return $this->belongsTo(Groups::class, 'group_id', 'id')->select(['id', 'name']);
//    }
//
//    public function group_role()
//    {
//        return $this->belongsTo(GroupRole::class, 'group_role_id', 'id')->select(['id', 'name']);
//    }

}
