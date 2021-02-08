<?php

namespace App\Services\Dropdown;

use App\Repositories\Group\GroupsRepository;
use App\Repositories\User\UsersRepository;
use App\Repositories\Category\Category1Repository;
use App\Repositories\Category\Category2NameRepository;
use App\Repositories\Category\Category3NameRepository;
use App\Repositories\Level\LevelsRepository;
use JWTAuth;

class DropdownServices
{
    private $groupsRepository;
    private $usersRepository;
    private $category1Repository;
    private $category2NameRepository;
    private $category3NameRepository;
    private $levelsRepository;

    public function __construct(
        GroupsRepository $groupsRepository,
        UsersRepository $usersRepository,
        Category1Repository $category1Repository,
        Category2NameRepository $category2NameRepository,
        Category3NameRepository $category3NameRepository,
        LevelsRepository $levelsRepository
    ) {
        $this->groupsRepository = $groupsRepository;
        $this->usersRepository = $usersRepository;
        $this->category1Repository = $category1Repository;
        $this->category2NameRepository = $category2NameRepository;
        $this->category3NameRepository = $category3NameRepository;
        $this->levelsRepository = $levelsRepository;
    }

    /**
     * 下拉式選單
     *
     * @param  string  $method
     * @param  array   $param
     * @return array
     */
    public function dropdown($method, $param = [])
    {
        try {
            $dropdown = [];
            switch ($method) {
                case 'group': // 群組
                    $dropdown = $this->groupsRepository->dropdown();
                    if ($param['all'] !== 'hide') {
                        $dropdown = array_merge([['id' => 0, 'name' => '全部']], $dropdown);
                    }
                    break;
                case 'user': // 人員
                    $dropdown = $this->usersRepository->dropdown($param);
                    break;
                case 'active': // 狀態選項
                    $active = config('dropdown.status');
                    if ($param['all'] == 'hide') {
                        unset($active[0]);
                    }
                    foreach ($active as $key => $value) {
                        $dropdown[] = [
                            'id'   => $key,
                            'name' => $value
                        ];
                    }
                    break;
                case 'level': // 會員等級
                    $dropdown = $this->levelsRepository->dropdown();
                    if ($param['all'] !== 'hide') {
                        $dropdown = array_merge([['id' => 0, 'name' => '全部']], $dropdown);
                    }
                    break;
                case 'category1':
                    $dropdown = $this->category1Repository->dropdown();
                    break;
                case 'category2':
                    $dropdown = $this->category2NameRepository->dropdown();
                    break;
                case 'category3':
                    $dropdown = $this->category3NameRepository->dropdown();
                    break;
            }
            return [
                'code'   => config('apiCode.success'),
                'result' => $dropdown,
            ];
        } catch (\Exception $e) {
            return [
                'code'  => $e->getCode() ?? config('apiCode.notAPICode'),
                'error' => $e->getMessage(),
            ];
        }
    }
}
