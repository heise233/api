<?php
/**
 * ApiAction.php
 * Descriptions: 业务执行脚本
 * Author:大圣翻译
 * Created on 2019/8/14 14:36
 */
namespace api\actions;

use api\components\ApiHttpException;
use api\components\ErrorCode;
use Yii;
use yii\base\Action;
use yii\base\InvalidParamException;

class ApiAction extends Action
{
    /* @var $modelClass string */
    public $modelClass;

    /* @var $scenario string 场景 默认为 default */
    public $scenario = 'default';

    /* @var $action string | \Closure 需要执行model的方法 */
    public $action;

    /* @var $callback null | \Closure 回调方法 */
    public $callback = null;


    /**
     * @return array
     * @throws ApiHttpException
     * @throws \Exception
     */
    public function run()
    {
        if(!$this->modelClass) {
            throw new InvalidParamException(Yii::t('app',"ModelClass Can't be empty"));
        }
        /* @var $model \yii\db\ActiveRecord */
        $model = new $this->modelClass;
        $model->setScenario($this->scenario);
        $params = Yii::$app->getRequest()->get();
        if(Yii::$app->getRequest()->getIsPost()){
            $params = Yii::$app->getRequest()->post();
        }
        if($model->load($params,'') && $model->validate()){
            if($this->action instanceof \Closure){
                $resp = call_user_func($this->action);
            }else{
                $action = $this->action;
                $resp = $model->$action($params);
            }
            if($this->callback instanceof \Closure){
                $resp = call_user_func($this->callback,$resp);
            }
            return $resp;
        }
        $errorReasons = $model->getErrors();
        $err = '';
        foreach ($errorReasons as $errorReason) {
            $err .= $errorReason[0] . '<br>';
        }
        $err = rtrim($err, '<br>');
        $error = ErrorCode::getError('params_error');
        throw new ApiHttpException($error['status'], $err, $error['code']);
    }


}