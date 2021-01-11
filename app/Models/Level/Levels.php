<?php

namespace App\Models\Level;

use App\Models\User\Users;
use App\Models\LumenShoppingModel;

class Levels extends LumenShoppingModel
{
    protected $table = 'levels';
    protected $fillable = ['name', 'amount', 'amount_max'];

    /**
     * 取得對應的權限資訊
     *
     * @return mixed
     */
    public function users()
    {
        return $this->hasMany(Users::class,'level_id', 'id');
    }
}
