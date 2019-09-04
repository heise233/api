<?php

namespace api\components;

use yii\web\HttpException;

class ApiHttpException extends HttpException
{
    public function __construct($status, $message = null, $code = 0, \Exception $previous = null)
    {
        $this->statusCode = $status;
        parent::__construct($status, $message, $code, $previous);
    }
}