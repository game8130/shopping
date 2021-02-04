<?php

return [
    'APP_NAME'           => env('APP_NAME'),
    'APP_ENV'            => env('APP_ENV'),
    'APP_KEY'            => env('APP_KEY'),
    'APP_DEBUG'          => env('APP_DEBUG'),
    'APP_URL'            => env('APP_URL'),
    'APP_TIMEZONE'       => env('APP_TIMEZONE'),
    // 後台
    'admin' => [
        'paginate' => 8, // 列表一頁顯示的資料筆數
    ],
    // 前台
    'web' => [
        'paginate' => 8, // 列表一頁顯示的資料筆數
    ],
    'status' => [
        '0'  => '全部',
        '1'  => '啟用',
        '2'  => '停用',
    ],
];
