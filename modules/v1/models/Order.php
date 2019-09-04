<?php
/**
 * Order.php
 * Descriptions:文件描述
 * Author:大圣翻译
 * Created on 2019/8/14 16:59
 */
namespace api\modules\v1\models;

use Yii;
use yii\db\ActiveRecord;

class Order extends ActiveRecord
{

    public static function tableName()
    {
        return 'b_order_consume';
    }

    public function rules()
    {
        return [
            [
                ['order_id','integral','descriptions','uid','pd_info','appid'],
                'required'
            ]
        ];
    }

    public function scenarios()
    {
        return [
            'pay' => ['order_id','integral','descriptions','uid','pd_info','appid']
        ];
    }


    /**
     * 创建订单
     *
     * @param $params
     * @return int
     * @throws \yii\db\Exception
     */
    public function insertOrder($params)
    {
        $insert_data = [
            'order_id' => $params['order_id'],
            'integral' => $params['integral'],
            'create_time' => time(),
            'descriptions' => $params['descriptions'],
            'pd_info' => $params['pd_info'],
            'uid' => $params['uid'],
            'appid' => $params['appid']
        ];
        $resp = Yii::$app->db->createCommand()->insert(self::tableName(),$insert_data)->execute();
        return $resp;
    }


    /**
     * 订单状态更新与扣减积分
     *
     * @param $params
     * @return array|bool|null
     * @throws \yii\db\Exception
     */
    public function orderPay($params)
    {
        $userIntegral = User::find()->select('jifen_yue')->where(['id' => $this->uid])->one();
        if($userIntegral && $userIntegral->jifen_yue <= $this->integral) {
            return [
                'order_id' => $this->order_id,
                'error_msg' => Yii::t('app','User integral insufficient.'),
                'error_code' => 40005
            ];
        }
        $create = $this->insertOrder($params);
        if(!$create) return null;
        $result = (new Integral)->insertDataLog($params);
        if(!$result) return false;
        $update_data = [
            'pay_time' => time(),
            'is_pay_success' => 1
        ];
        $resp = self::updateAll($update_data,['order_id' => $this->order_id]);
        return $resp ? ['order_id' => $this->order_id,'error_msg' => "",'error_code' => 0] :
            ['order_id' => $this->order_id,'error_msg' => Yii::t('app','Order Pay Fail.'),'error_code' => 40006];
    }
	
	public function orderQuxiao($params)
	{
		
	}


}