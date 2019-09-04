<?php
/**
 * User.php
 * Descriptions:文件描述
 * Author:大圣翻译
 * Created on 2019/8/14 15:10
 */
namespace api\models;

use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

class User extends ActiveRecord implements IdentityInterface
{
    const STATUS_ACTIVE = 0;


    public static function tableName()
    {
        return "b_users";
    }

    /**
     * 根据id获取用户信息
     *
     * @param int|string $id
     * @return User|IdentityInterface|null
     */
    public static function findIdentity($id)
    {
        return self::findOne($id);
    }

    /**
     * 验证用户是否存在【稍加改动，ssid唯一】
     *
     * @param mixed $token
     * @param null $type
     * @return User|IdentityInterface|null
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['ssid' => $token, 'p_status' => self::STATUS_ACTIVE]);
    }


    public function getId()
    {
        // TODO: Implement getId() method.
    }

    public function getAuthKey()
    {
        // TODO: Implement getAuthKey() method.
    }

    public function validateAuthKey($authKey)
    {
        // TODO: Implement validateAuthKey() method.
    }


}