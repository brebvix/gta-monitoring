<?php

namespace frontend\modules\telegram\models;

use common\models\Servers;
use common\models\User;
use common\models\UserFavoriteServers;
use Yii;

/**
 * This is the model class for table "telegram_servers_relations".
 *
 * @property int $id
 * @property int $telegram_user_id
 * @property int $server_id
 *
 * @property Servers $server
 * @property TelegramUser $telegramUser
 */
class TelegramServersRelations extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'telegram_servers_relations';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['telegram_user_id', 'server_id'], 'required'],
            [['telegram_user_id', 'server_id'], 'integer'],
            [['server_id'], 'exist', 'skipOnError' => true, 'targetClass' => Servers::className(), 'targetAttribute' => ['server_id' => 'id']],
            [['telegram_user_id'], 'exist', 'skipOnError' => true, 'targetClass' => TelegramUser::className(), 'targetAttribute' => ['telegram_user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('main', 'ID'),
            'telegram_user_id' => Yii::t('main', 'Telegram User ID'),
            'server_id' => Yii::t('main', 'Server ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getServer()
    {
        return $this->hasOne(Servers::className(), ['id' => 'server_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTelegramUser()
    {
        return $this->hasOne(TelegramUser::className(), ['id' => 'telegram_user_id']);
    }

    public static function addServer(TelegramUser $user, $identifier)
    {
        $server = Servers::getByIdentifier($identifier);

        if (empty($server)) {
            return false;
        }

        $checkExist = TelegramServersRelations::findOne(['telegram_user_id' => $user->id, 'server_id' => $server->id]);

        if (!empty($checkExist)) {
            return true;
        }

        if ($user->user_id > 0) {
            $checkMainRelation = UserFavoriteServers::findOne(['user_id' => $user->user_id, 'server_id' => $server->id]);

            if (empty($checkMainRelation)) {
                $mainRelationModel = new UserFavoriteServers();
                $mainRelationModel->user_id = $user->user_id;
                $mainRelationModel->server_id = $server->id;
                $mainRelationModel->save();
            }
        }

        $model = new TelegramServersRelations();
        $model->telegram_user_id = $user->id;
        $model->server_id = $server->id;
        return $model->save();
    }

    public static function deleteServer(TelegramUser $user, $identifier)
    {
        $server = Servers::getByIdentifier($identifier);

        if (empty($server)) {
            return false;
        }

        $checkExist = TelegramServersRelations::findOne(['telegram_user_id' => $user->id, 'server_id' => $server->id]);

        if (empty($checkExist)) {
            return true;
        }

        if ($user->user_id > 0) {
            $checkMainRelation = UserFavoriteServers::findOne(['user_id' => $user->user_id, 'server_id' => $server->id]);

            if (!empty($checkMainRelation)) {
                UserFavoriteServers::deleteAll(['id' => $checkMainRelation->id]);
            }
        }

        return TelegramServersRelations::deleteAll(['id' => $checkExist->id]);
    }

    public static function synchronize(User $mainUser, TelegramUser $user)
    {
        $mainServers = UserFavoriteServers::find()
            ->where(['user_id' => $mainUser->id])
            ->all();

        foreach ($mainServers AS $mainServer) {
            $checkExist = TelegramServersRelations::findOne([
                'telegram_user_id' => $mainUser->id,
                'server_id' => $mainServer->server_id
            ]);

            if (empty($checkExist)) {
                $model = new TelegramServersRelations();
                $model->telegram_user_id = $user->telegram_user_id;
                $model->server_id = $mainServer->id;
                $model->save();
            }
        }

        $servers = TelegramServersRelations::find()
            ->where(['telegram_user_id' => $user->telegram_user_id])
            ->all();

        foreach ($servers AS $server) {
            $checkExist = UserFavoriteServers::findOne(['user_id' => $mainUser->id, 'server_id' => $server->id]);

            if (empty($checkExist)) {
                $model = new UserFavoriteServers();
                $model->user_id = $mainUser->id;
                $model->server_id = $server->id;
                $model->save();
            }
        }

        return true;
    }
}
