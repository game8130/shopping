<?php

// api code

return [
    /**
     * HTTP STATUS CODE : ２００
     */
    // 執行成功
    'success'              => 200001,

    /**
     * HTTP STATUS CODE    : ４００
     */

    /**
     * HTTP STATUS CODE    : ４０１
     */
    // 登入失敗
    'invalidCredentials'   => 401001,

    /**
     * HTTP STATUS CODE    : ４０３
     */
    // 無該功能權限
    'invalidPermission'     => 403001,

    /**
     * HTTP STATUS CODE    : ４０４
     */
    // 查無資料
    'notFound'             => 404001,

    /**
     * HTTP STATUS CODE    : ４２２
     */
    // 驗證失敗
    'validateFail'         => 422001,
    // 名稱重複
    'validateRepeat'       => 422002,
    // 登入驗證碼錯誤
    'captchaFail'          => 422003,
    // 舊密碼與新密碼相同
    'differentFail'        => 422004,
    // 不可異動
    'unchangeable'         => 422005,
    // 不可刪除
    'notRemove'            => 422006,
    // 目前密碼錯誤
    'wrongPassword'        => 422007,
    // 結束時間不可小於開始時間
    'dateCompareFail'      => 422008,
    // 超出查詢時間範圍
    'dateRangeFail'        => 422009,

    /**
     * HTTP STATUS CODE    : ５００
     */
    // 未傳遞 API Code
    'notAPICode'           => 500001,
    // 產生 Token 異常
    'couldNotCreateToken'  => 500002,

    /**
     * HTTP STATUS CODE    : ５０３
     */
    'ServiceUnavailable'    => 503001,
];
