<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

abstract class LumenShoppingModel extends Model
{
    protected $connection = 'mysql';

    /**
     * 取得對應會員資訊
     *
     * @param  object  $query
     * @param  integer $userID
     * @return mixed
     */
    public function scopeUser($query, $userID)
    {
        return $query->where('user_id', $userID);
    }

    /**
     * 取得對應狀態資訊
     *
     * @param  object  $query
     * @param  integer $active
     * @return mixed
     */
    public function scopeActive($query, $active = 1)
    {
        return $query->where('active', $active);
    }

    /**
     * 取得該 entity 資料表名稱
     *
     * @return string
     */
    public static function getTableName()
    {
        return with(new static)->getTable();
    }

    public function getUpdatedAtAttribute($value)
    {
        return $value ? date("Y-m-d H:i:s", strtotime($value)) : '';
    }

    public function getCreatedAtAttribute($value)
    {
        return $value ? date("Y-m-d H:i:s", strtotime($value)) : '';
    }
}
