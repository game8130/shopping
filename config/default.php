<?php
// 放置初始化資料 Database Seeds
return [
    // 初始總權限名稱(無法異動/刪除)
    'adminGroupName'   => '超級管理者',
    'generalGroupName' => '一般會員',
    // 初始管理者帳號/密碼/名稱/Email
    'adminAccount'   => 'administrator',
    'adminPassword'  => 'password',
    'adminName'      => '超級管理員',
    'adminEmail'     => 'administrator@email.com',
    'levels' => [[
        'name' => '普通會員',
        'amount' => 0,
        'amount_max' => 1000,
    ],[
        'name' => '高級會員',
        'amount' => 1001,
        'amount_max' => 5000,
    ],[
        'name' => '超級會員',
        'amount' => 5001,
        'amount_max' => 10000,
    ],[
        'name' => '超高級會員',
        'amount' => 10001,
        'amount_max' => 20000,
    ],[
        'name' => '頂級會員',
        'amount' => 20001,
        'amount_max' => 100000000,
    ],]
];
