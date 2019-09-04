<?php
/**
 * UserController.php
 * Descriptions:用户相关
 * Author:大圣翻译
 * Created on 2019/8/14 14:33
 */
namespace api\modules\v1\controllers;

use api\components\Tools;
use Yii;
use api\actions\ApiAction;
use api\controllers\RestApiBaseController;
use api\modules\v1\models\User;

class UserController extends RestApiBaseController
{
    /* @var $modelClass string 默认模型 */
    public $modelClass = 'api\modules\v1\models\User';

    public function actions()
    {
        return [
            'user-info' => [
                'class' => ApiAction::className(),
                'modelClass' => User::className(),
                'scenario' => 'get',
                'action' => 'getUserInfo'
            ]
        ];
    }


}