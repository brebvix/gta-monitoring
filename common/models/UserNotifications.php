<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "user_notifications".
 *
 * @property int $id
 * @property int $user_id
 * @property int $type
 * @property string $data
 * @property int $seen
 * @property string $date
 *
 * @property User $user
 */
class UserNotifications extends \yii\db\ActiveRecord
{
    const SEEN_NO = 0;
    const SEEN_YES = 1;

    const TYPE_COMMENT_RATING_CHANGE = 0;
    const TYPE_NEW_MESSAGE = 1;
    const TYPE_NEW_USER_COMMENT = 2;
    const TYPE_NEW_AUTHORIZE = 3;
    const TYPE_END_BANNER = 4;
    const TYPE_END_LINK = 5;
    const TYPE_END_SERVER_TOP = 6;
    const TYPE_END_SERVER_COLOR = 7;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_notifications';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'type', 'data'], 'required'],
            [['user_id', 'type', 'seen'], 'integer'],
            [['data'], 'string'],
            [['date'], 'safe'],
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
            'type' => Yii::t('main', 'Тип'),
            'data' => Yii::t('main', 'Значение'),
            'seen' => Yii::t('main', 'Просмотрено'),
            'date' => Yii::t('main', 'Дата'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);


        if (!$insert) {
            return true;
        }
        
        if ($this->user->language != 'ru') {
            Yii::$app->language = 'en-US';
        }

        $subject = Yii::t('main', 'Новое уведомление для') . ' ' . $this->user->username . ' ' . Yii::t('main', 'на сайте Servers.Fun');

        switch ($this->type) {
            case self::TYPE_END_BANNER:
                Yii::$app
                    ->mailer
                    ->compose(
                        ['html' => 'notifications/type-4-html', 'text' => 'notifications/type-4-text'],
                        array_merge(['avatar_link' => $this->user->getAvatarLink()], json_decode($this->data, true))
                    )
                    ->setFrom([Yii::$app->params['supportEmail'] => 'Servers.Fun robot'])
                    ->setTo($this->user->email)
                    ->setSubject($subject)
                    ->send();
                break;
            case self::TYPE_END_LINK:
                Yii::$app
                    ->mailer
                    ->compose(
                        ['html' => 'notifications/type-5-html','text' => 'notifications/type-5-text'],
                        array_merge(['avatar_link' => $this->user->getAvatarLink()], json_decode($this->data, true))
                    )
                    ->setFrom([Yii::$app->params['supportEmail'] => 'Servers.Fun robot'])
                    ->setTo($this->user->email)
                    ->setSubject($subject)
                    ->send();
                break;
            case self::TYPE_END_SERVER_TOP:
                Yii::$app
                    ->mailer
                    ->compose(
                        ['html' => 'notifications/type-6-html','text' => 'notifications/type-6-text'],
                        array_merge(['avatar_link' => $this->user->getAvatarLink()], json_decode($this->data, true))
                    )
                    ->setFrom([Yii::$app->params['supportEmail'] => 'Servers.Fun robot'])
                    ->setTo($this->user->email)
                    ->setSubject($subject)
                    ->send();
                break;
            case self::TYPE_END_SERVER_COLOR:
                Yii::$app
                    ->mailer
                    ->compose(
                        ['html' => 'notifications/type-7-html','text' => 'notifications/type-7-text'],
                        array_merge(['avatar_link' => $this->user->getAvatarLink()], json_decode($this->data, true))
                    )
                    ->setFrom([Yii::$app->params['supportEmail'] => 'Servers.Fun robot'])
                    ->setTo($this->user->email)
                    ->setSubject($subject)
                    ->send();
                break;
        }

        if ($this->user->telegram_status == User::TELEGRAM_STATUS_ENABLED) {
            if ($this->user->haveTelegram()) {
                $data = [
                    'user' => $this->user,
                    'notification' => $this,
                ];

                $message = Yii::$app->controller->renderPartial('@frontend/views/notifications/text/type_' . $this->type, array_merge($data, json_decode($this->data, true)));
                $this->user->sendTelegramMessage($message);
            }
        }
    }
}
