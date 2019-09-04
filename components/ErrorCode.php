<?php

namespace api\components;

use Exception;

class ErrorCode
{
    private static $error = [
        'system_error'  => [
            'status'    => 500,
            'code'      => 500000,
            'msg'       => 'system error',
        ],
        'auth_error'    => [
            'status'=> 401,
            'code'  => 400000,
            'msg'   => 'auth error',
        ],
        'params_error'  => [
            'status'=> 401,
            'code'  => 400001,
            'msg'   => 'params error',
        ],
        'Authentication_error' => [
            'status' => 403,
            'code' => 400003,
            'msg' => 'Authentication error'
        ]
    ];
    private function __construct(){
    }
    /**
     * @param $key
     * @return mixed
     * @throws Exception
     */
    public static function getError($key){
        if(empty($key) || !isset(self::$error[$key])){
            throw new Exception("error code not exist", 400);
        }
        return self::$error[$key];
    }
}
