<?php
/**
 * OrderController.php
 * Descriptions:文件描述
 * Author:大圣翻译
 * Created on 2019/8/14 16:59
 */
namespace api\modules\v1\controllers;

use api\actions\ApiAction;
use api\controllers\RestApiBaseController;
use api\modules\v1\models\Order;

class OrderController extends RestApiBaseController
{

    public $modelClass = "";

    public function actions()
    {
        return [
            'order-pay' => [
                'class' => ApiAction::className(),
                'modelClass' => Order::className(),
                'scenario' => 'pay',
                'action' => 'orderPay'
            ]
        ];
    }


}