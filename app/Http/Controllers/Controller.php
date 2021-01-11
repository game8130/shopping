<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller as BaseController;
use Log;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;

class Controller extends BaseController
{
    /**
     * 驗證錯誤
     * ref: /vendor/laravel/lumen-framework/src/Routing/ProvidesConvenienceMethods.php
     *
     * @param  Request   $request
     * @param  Validator $validator
     * @throws ValidationException
     */
    protected function throwValidationException(Request $request, $validator)
    {
        throw new ValidationException($validator, $this->buildFailedValidationResponse($request, $this->customValidationErrors($validator, $request)));
    }

    /**
     * 驗證錯誤統一回傳
     *
     * @param Validator $validator
     * @param Request   $request
     * @return array
     */
    protected function customValidationErrors(Validator $validator, Request $request)
    {
        $code = config('apiCode.validateFail');
        $errors = $validator->errors();
        $errorAllMessage = array_map(function ($msg) {
            return str_replace('api.', '', $msg);
        }, $errors->all());
        if (count($errorAllMessage) == 1) {
            if ($errors->has('captcha')) {
                $code = config('apiCode.captchaFail');
            } elseif ($errors->has('old_password')) {
                $code = config('apiCode.differentFail');
            }
        }
        $this->addErrorLog('422', $request, ['result' => $errorAllMessage, 'code' => $code], '');

        return [
            'code'  => $code,
            'error' => $errorAllMessage,
        ];
    }

    /**
     * 統整要回傳前端的資料格式
     *
     * @param Request $request
     * @param array   $info
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function responseWithJson($request, array $info)
    {
        $param = $this->handleResponseWithJson($info);
        if ($param['statusCode'] != 200) { // 非 200 的一律寫入到 log
            $error = $info['error'] ?? '';
            $this->addErrorLog($param['statusCode'], $request, $param['response'], $error);
            if (config('common.APP_DEBUG') == true) {
                $param['response']['error'] = $error;
            }
        }
        if (isset($info['other']) && $info['other'] != '') {
            $param['response']['other'] = $info['other'];
        }
        return response()->json($param['response'], $param['statusCode']);
    }

    /**
     * [API串接] 統整要回傳的資料格式
     *
     * @param Request $request
     * @param array   $info
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function responseApiWithJson($request, array $info)
    {
        $param = $this->handleResponseWithJson($info);
        $logType = 'info';
        if ($param['statusCode'] != 200) { // 執行失敗
            $param['response']['error'] = (config('common.APP_DEBUG') == true) ? ($info['error'] ?? '') : '';
            switch ($param['statusCode']) {
                case '500':
                    $logType = 'emergency';
                    break;
                default:
                    $logType = 'error';
                    break;
            }
        }
        // 寫Log
        $logReturn = $param['response'];
        if (strpos($request->path(), 'report')) { // 報表相關的省略紀錄回傳的清單資料
            $logReturn['result']['list'] = '';
        }
        $logger = $this->getLoggerByLog($request);
        $logger->{$logType}(json_encode([
            'send'   => $this->getInfoByLog($request),
            'return' => $logReturn,
        ]));
        return response()->json($param['response'], $param['statusCode']);
    }

    /**
     * 將錯誤訊息寫入 Log
     *
     * @param string   $statusCode
     * @param Request  $request
     * @param array    $response
     * @param string   $error
     *
     */
    protected function addErrorLog($statusCode, $request, array $response, string $error)
    {
        $logger = $this->getLoggerByLog($request);
        $logger->info(json_encode($this->getInfoByLog($request)));
        $logger->debug(json_encode($response));
        if ($error != '') {
            if ($statusCode == 500) {
                $logger->emergency($error);
            } else {
                $logger->error($error);
            }
        }
    }

    /**
     * 整理回傳的資訊
     *
     * @param  array $parameters
     * @return array
     */
    private function handleResponseWithJson($parameters)
    {
        // 整理APICode
        $apiCode = ($parameters['code'] && strlen($parameters['code']) == 6) ? $parameters['code'] : config('apiCode.notAPICode');
        return [
            'statusCode' => substr($apiCode, 0, 3),
            'response'   => ['result' => ($parameters['result'] ?? ''), 'code' => $apiCode],
        ];
    }

    /**
     * 取得Logger 物件
     *
     * @param  Request  $request
     * @return mixed
     */
    private function getLoggerByLog($request)
    {
        // 指定寫入 LOG 路徑 [ /logs/[api or web]/YYYY-mm-dd/H.log]
        $apiFolder = explode('/', $request->path())[0];
        $logger = new Logger($apiFolder);
        $filename = app()->storagePath() . '/logs/' . $apiFolder . '/' . date('Y-m-d') . '/' . date('H') . '.log';
        $logger->pushHandler(new StreamHandler($filename, Logger::DEBUG));
        return $logger;
    }

    /**
     * 取得call api 相關資訊(Log紀錄使用)
     *
     * @param  Request       $request
     * @return array
     */
    private function getInfoByLog($request)
    {
        $parameters = $request->all();
        if (isset($parameters['images'])) {
            $parameters['images'] = true;
        }
        // 排除要紀錄的欄位資訊
        $exclude = ['password', 'password_confirmation', 'old_password'];
        foreach ($parameters as $field => $value) {
            if (in_array($field, $exclude)) {
                $parameters[$field] = '';
            }
        }
        return [
            'time'       => \Carbon\Carbon::now()->toDateTimeString(),
            'path'       => $request->path(),
            'method'     => $request->method(),
            'parameters' => $parameters,
            'ip'         => get_real_ip($request->ip()),
        ];
    }
}
