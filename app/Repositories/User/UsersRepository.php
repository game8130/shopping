<?php

namespace App\Repositories\User;

use App\Models\User\Users;
use App\Repositories\Repository;
use Illuminate\Support\Facades\DB;

class UsersRepository
{
    use Repository;

    public function __construct()
    {
        $this->setEntity(Users::class);
    }

    /**
     * @param array $parameters
     * @return mixed
     */
    public function list(array $parameters)
    {
        $user = Users::select(['*'])->with(['group', 'level']);
        return $this->sortByAndItemsPerPage($user, $parameters);
    }

    /**
     * @param string $uuid
     * @return mixed
     */
    public function firstByUuidWith($uuid)
    {
        return Users::where('uuid', $uuid)->with(['group', 'level'])->first();
    }

    /**
     * @return mixed
     */
    public function getAllWithInformation()
    {
        return Users::select(['id', 'name'])->with(['information' => function ($query) {
            $query->select(['user_id', 'annual_leave_date', 'new_system', 'annual_leave', 'now_annual_leave']);
        }])->get();
    }

    /**
     * 取得下拉式選單資料
     *
     * @param $param
     * @return array
     */
    public function dropdown($param)
    {
        $user = Users::select('id', 'name');
        if (isset($param['all']) && $param['all'] == 'true') {
            $user->whereIn('active', [1, 2]);
        }
        if (!empty($param['id'])) {
            $user->where('group_id', $param['id']);
        }
        return $user->orderBy('id', 'DESC')->get()->toArray();
    }

    /**
     * @param $request
     * @param $start
     * @param $end
     * @return mixed
     */
    public function getByWhereWithLeavePunches($request, $start, $end)
    {
        $user = Users::select(['id', 'name', 'group_id', 'group_role_id'])
            ->where('account', '!=', config('default.adminAccount'))
            ->where('active', '!=', 3);
        if (!empty($request['group_id'])) {
            $user->where('group_id', $request['group_id']);
        }
        return $user->orderBy('sort', 'DESC')->orderBy('id')->with(['leave' => function ($query) use ($start, $end) {
                $query->select(['user_id', 'group_leave_id', 'date', 'start_time', 'end_time', 'total_hours'])->whereBetween('date', [$start, $end]);
            }])
            ->with(['class_month_one' => function ($query) use ($start) {
            $query->select(['user_id', 'group_class_id'])->where('month', $start);
            }])
            ->with(['work' => function ($query) use ($start, $end) {
                $query->select(['user_id', 'date', 'begin_time as start_time', 'finish_time as end_time', 'group_class_id', 'complete', 'group_class_id', 'delay'])->whereBetween('date', [$start, $end]);
            }])->get()->toArray();
    }

    /**
     * @param $request
     * @param $start
     * @param $end
     * @return mixed
     */
    public function getByWhereWithLeave($request, $start, $end)
    {
        $user = Users::select(['id', 'name', 'group_id'])
            ->where('account', '!=', config('default.adminAccount'))
            ->where('active', '!=', 3);
        if (!empty($request['group_id'])) {
            $user->where('group_id', $request['group_id']);
        }
        return $user->with(['leave' => function ($query) use ($start, $end) {
            $query->select('user_id', 'group_leave_id', DB::raw('SUM(total_hours) as total_hours'))
                ->whereBetween('date', [$start, $end])
                ->groupBy('group_leave_id', 'user_id');
        }])->with('information')->get()->toArray();
    }

    /**
     * @param $date
     * @return mixed
     */
    public function getByWithClassMonth($date)
    {
        return Users::select(['id', 'name'])
            ->with(['class_month' => function ($query) use ($date) {
                $query->select(['user_id', 'group_class_id'])->where('month', $date);
            }])->orderBy('sort', 'DESC')->orderBy('id')->get()->toArray();
    }

    /**
     * @param $id
     * @param $date
     * @return mixed
     */
    public function getByFirstWithClassMonth($id, $date)
    {
        return Users::select(['id', 'name'])
            ->where('id', $id)
            ->with(['class_month' => function ($query) use ($date) {
                $query->select(['user_id', 'group_class_id'])->where('month', $date);
            }])->first();
    }

    /**
     * @param array $param
     * @return bool
     */
    public function updateAll(array $param)
    {
        return Users::query()->update($param);
    }

    /**
     * @param array $array
     * @param array $param
     * @return mixed
     */
    public function whereNotInId(array $array, array $param)
    {
        return Users::whereNotIn('id', $array)->update($param);
    }
}
