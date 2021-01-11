<?php

namespace App\Models\Group;

use App\Models\User\Users;
use App\Models\LumenShoppingModel;


class Groups extends LumenShoppingModel
{
    protected $table = 'groups';
    protected $fillable = ['name'];

    /**
     * 取得對應的權限資訊
     *
     * @return mixed
     */
    public function users()
    {
        return $this->hasMany(Users::class,'group_id', 'id');
    }
}
