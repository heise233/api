<?php
/**
 * User.php
 * Descriptions:文件描述
 * Author:大圣翻译
 * Created on 2019/8/14 14:35
 */
namespace api\modules\v1\models;

use yii\db\ActiveRecord;

class User extends ActiveRecord
{

    public $uid;

    public static function tableName()
    {
        return 'b_users';
    }

    public function rules()
    {
        return [
            [
                ['id'],'required'
            ]
        ];
    }


    public function scenarios()
    {
        return [
            'get' => ['id']
        ];
    }


    public function fields()
    {
       return [
           'uid' => function(){
                return $this->id;
           },
           'nickname','username','ssid','jifen_yue','headimgurl'
       ];
    }

    /**
     * 修改用户积分
     *
     * @param $uid
     * @param $number
     * @return int
     */
    public function consumption($uid, $number)
    {
        $resp = self::updateAllCounters(['jifen_yue' => -$number],['id' => $uid]);
        return $resp;
    }


    /**
     * 用户基本信息
     *
     * @param $params
     * @return array|ActiveRecord|null
     */
    public function getUserInfo($params)
    {
        $data = self::find()->where(['id' => $this->id])->one();
        return $data;
    }


}