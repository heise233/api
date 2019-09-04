<?php
/**
 * Integral.php
 * Descriptions:文件描述
 * Author:大圣翻译
 * Created on 2019/8/14 17:20
 */
namespace api\modules\v1\models;

use Yii;
use yii\db\ActiveRecord;

class Integral extends ActiveRecord
{

    public static function tableName()
    {
        return 'b_jifen_jilu';
    }


    /**
     * 用户消费
     *
     * @param $params
     * @return bool|int
     * @throws \yii\db\Exception
     */
    public function insertDataLog($params)
    {
        $consumBool = (new User)->consumption($params['uid'], $params['integral']);
        if(!$consumBool) return false;
        $insertData = [
            'user_id' => $params['uid'],
            'nickname' => "测试",
            'action' => "-",
            'jifen' => $params['integral'],
            'summary' => "积分商城消费-{$params['integral']}",
            'created_at' => time()
        ];
        $resp = Yii::$app->db->createCommand()->insert(self::tableName(),$insertData)->execute();
        return $resp;
    }

}