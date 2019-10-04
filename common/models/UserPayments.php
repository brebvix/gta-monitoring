<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "user_payments".
 *
 * @property int $id
 * @property int $user_id
 * @property double $amount_rub
 * @property double $amount_usd
 * @property string $date
 * @property int $status
 * @property string $payment_system
 * @property int $type
 * @property string $comment
 *
 * @property User $user
 */
class UserPayments extends \yii\db\ActiveRecord
{
    const STATUS_WAIT = 0;
    const STATUS_SUCCESS = 1;
    const STATUS_CANCELED = 2;

    const TYPE_INCREASE = 0;
    const TYPE_DECREASE = 1;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_payments';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'amount_rub', 'amount_usd', 'payment_system', 'type', 'comment'], 'required'],
            [['user_id', 'status', 'type'], 'integer'],
            [['amount_rub', 'amount_usd'], 'number'],
            [['date', 'comment'], 'safe'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_id' => Yii::t('main', 'Пользователь'),
            'amount_rub' => Yii::t('main', 'Сумма, руб.'),
            'amount_usd' => Yii::t('main', 'Сумма, usd.'),
            'payment_system' => Yii::t('main', 'Система оплаты'),
            'date' => Yii::t('main', 'Дата'),
            'status' => Yii::t('main', 'Статус'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function statusIcon()
    {
        switch($this->status){
            case UserPayments::STATUS_WAIT: return 'info';
            case UserPayments::STATUS_SUCCESS: return 'success';
            case UserPayments::STATUS_CANCELED: return 'warning';
        }
    }

    public function statusText()
    {
        switch($this->status){
            case UserPayments::STATUS_WAIT: return Yii::t('main', 'Ожидание оплаты');
            case UserPayments::STATUS_SUCCESS: return Yii::t('main', 'Успешная оплата');
            case UserPayments::STATUS_CANCELED: return Yii::t('main', 'Оплата отменена');
        }
    }
}
