<?php

namespace frontend\modules\telegram\models;

use Yii;

/**
 * This is the model class for table "telegram_user".
 *
 * @property int $id
 * @property int $user_id
 * @property int $telegram_user_id
 * @property int $chat_id
 * @property string $username
 * @property string $first_name
 * @property string $language
 * @property string $last_update
 *
 * @property TelegramServersRelations[] $telegramServersRelations
 */
class TelegramUser extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'telegram_user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'telegram_user_id', 'chat_id'], 'integer'],
            [['telegram_user_id', 'chat_id', 'username', 'first_name'], 'required'],
            [['last_update'], 'safe'],
            [['username', 'first_name'], 'string', 'max' => 48],
            [['language'], 'string', 'max' => 2],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('main', 'ID'),
            'user_id' => Yii::t('main', 'User ID'),
            'telegram_user_id' => Yii::t('main', 'Telegram User ID'),
            'chat_id' => Yii::t('main', 'Chat ID'),
            'username' => Yii::t('main', 'Username'),
            'first_name' => Yii::t('main', 'First Name'),
            'language' => Yii::t('main', 'Language'),
            'last_update' => Yii::t('main', 'Last Update'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTelegramServersRelations()
    {
        return $this->hasMany(TelegramServersRelations::className(), ['telegram_user_id' => 'id']);
    }

    public function getServers()
    {
        return $this->getTelegramServersRelations()
            ->with('servers');
    }
}
