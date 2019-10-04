<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "servers_rating".
 *
 * @property int $id
 * @property int $server_id
 * @property int $user_id
 * @property string $date
 * @property int $type
 *
 * @property Servers $server
 * @property User $user
 */
class ServersRating extends \yii\db\ActiveRecord
{
    const RATING_UP = 1;
    const RATING_DOWN = 0;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'servers_rating';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['server_id', 'user_id', 'type'], 'required'],
            [['server_id', 'user_id', 'type'], 'integer'],
            [['date'], 'safe'],
            [['server_id'], 'exist', 'skipOnError' => true, 'targetClass' => Servers::className(), 'targetAttribute' => ['server_id' => 'id']],
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
            'server_id' => Yii::t('main', 'Сервер'),
            'user_id' => Yii::t('main', 'Пользователь'),
            'date' => Yii::t('main', 'Дата'),
            'type' => Yii::t('main', 'Тип'),
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
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public static function calculate($server_id, $type)
    {
        $server = Servers::findOne(['id' => $server_id]);

        if (empty($server)) {
            return false;
        }

        if (!self::_isAvailable($server_id, $type)) {
            return false;
        }

        if ($type == self::RATING_UP) {
            $server->rating_up += 0.5;
        } else {
            $server->rating_down += 0.5;
        }

        $server->rating = self::calculateByWilson($server->rating_up, $server->rating_down) * 10;

        if (!$server->save()) {
            Yii::$app->session->setFlash('error', Yii::t('main', 'Ошибка при изменении рейтинга сервера, попробуйте позже.'));

            return false;
        }

        $ratingModel = new ServersRating();
        $ratingModel->server_id = $server->id;
        $ratingModel->user_id = Yii::$app->user->id;
        $ratingModel->type = (int)$type;
        if (!$ratingModel->save()) {
            Yii::$app->session->setFlash('error', Yii::t('main', 'Ошибка при изменении рейтинга сервера, попробуйте позже.'));

            return false;
        }

        $user = Yii::$app->user->identity;
        $user->rating_up += 0.1;
        $user->updateRating();

        self::_updateAchievements($server, $type);

        return true;
    }

    public static function userRatingCount($user_id, $type)
    {
        return self::find()
            ->where(['user_id' => $user_id, 'type' => $type])
            ->count();
    }

    private static function _updateAchievements($server, $type)
    {
        if (!$server->hasAchievement(3)) {
            $achievement_3 = AchievementsCounter::findOne([
                'main_id' => $server->id,
                'main_type' => Achievements::MAIN_TYPE_SERVER,
                'achievement_id' => 3
            ]);

            if (empty($achievement_3)) {
                $achievement_3 = new AchievementsCounter();
                $achievement_3->achievement_id = 3;
                $achievement_3->main_id = $server->id;
                $achievement_3->main_type = Achievements::MAIN_TYPE_SERVER;
            }

            $achievement_3->counter++;
            $achievement_3->save();
        }

        if ($type == self::RATING_UP && !$server->hasAchievement(1)) {
            $achievement_1 = AchievementsCounter::findOne([
                'main_id' => $server->id,
                'main_type' => Achievements::MAIN_TYPE_SERVER,
                'achievement_id' => 1
            ]);

            if (empty($achievement_1)) {
                $achievement_1 = new AchievementsCounter();
                $achievement_1->achievement_id = 1;
                $achievement_1->main_id = $server->id;
                $achievement_1->main_type = Achievements::MAIN_TYPE_SERVER;
            }

            $achievement_1->counter++;
            $achievement_1->save();
        } else if (!$server->hasAchievement(2)) {
            $achievement_2 = AchievementsCounter::findOne([
                'main_id' => $server->id,
                'main_type' => Achievements::MAIN_TYPE_SERVER,
                'achievement_id' => 2
            ]);

            if (empty($achievement_2)) {
                $achievement_2 = new AchievementsCounter();
                $achievement_2->achievement_id = 2;
                $achievement_2->main_id = $server->id;
                $achievement_2->main_type = Achievements::MAIN_TYPE_SERVER;
            }

            $achievement_2->counter++;
            $achievement_2->save();
        }
    }

    private static function _isAvailable($server_id, $type)
    {
        $lastDay = strtotime(date('Y-m-d H:m:s')) - 86400;
        $check = ServersRating::find()
            ->where(['user_id' => Yii::$app->user->id, 'server_id' => $server_id])
            ->andWhere(['>', 'date', date('Y-m-d H:m:s', $lastDay)])
            ->one();

        if (!empty($check)) {
            Yii::$app->session->setFlash('error', Yii::t('main', 'Вы уже изменяли рейтинг этого сервера, подождите 24 часа.'));

            return false;
        }

        $check2 = ServersRating::find()
            ->where(['user_id' => Yii::$app->user->id, 'server_id' => $server_id])
            ->all();

        if (count($check2) >= 2) {
            Yii::$app->session->setFlash('error', Yii::t('main', 'Вы исчерпали лимит голосов для изменения рейтинга этого сервера.'));

            return false;
        } else if (count($check2) == 1 && $type == $check2[0]->type) {
            Yii::$app->session->setFlash('error', Yii::t('main', 'Вы уже {type} рейтинг этого сервера.',
                ['type' => Yii::t('main', $type == self::RATING_UP ? 'увеличивали' : 'понижали')]));

            return false;
        }


        $checkCount = ServersRating::find()
            ->where(['user_id' => Yii::$app->user->id])
            ->andWhere(['>', 'date', date('Y-m-d H:m:s', $lastDay)])
            ->count();

        if ($checkCount >= 5) {
            Yii::$app->session->setFlash('error', Yii::t('main', 'В сутки Вы можете использовать только 5 голосов. Вы исчерпали лимит :('));

            return false;
        }

        return true;
    }

    public static function calculateByWilson($up, $down)
    {
        if (!$up) return -$down;
        $n = $up + $down;
        $z = 1.64485; //1.0 = 85%, 1.6 = 95%
        $phat = $up / $n;
        return ($phat + $z * $z / (2 * $n) - $z * sqrt(($phat * (1 - $phat) + $z * $z / (4 * $n)) / $n)) / (1 + $z * $z / $n);
    }
}
