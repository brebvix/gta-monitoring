<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "user_ulogin".
 *
 * @property int $id
 * @property int $user_id
 * @property string $identity
 * @property string $network
 * @property string $date
 *
 * @property User $user
 */
class UserUlogin extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_ulogin';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'identity', 'network'], 'required'],
            [['user_id'], 'integer'],
            [['date'], 'safe'],
            [['identity'], 'string', 'max' => 128],
            [['network'], 'string', 'max' => 32],
            [['user_id'], 'unique'],
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
            'user_id' => Yii::t('app', 'User ID'),
            'identity' => Yii::t('app', 'Identity'),
            'network' => Yii::t('app', 'Network'),
            'date' => Yii::t('app', 'Date'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
