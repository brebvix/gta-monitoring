<?php

namespace frontend\widgets;

use common\models\Achievements;
use common\models\AchievementsCounter;
use common\models\Activity;
use common\models\News;
use common\models\Servers;
use common\models\User;
use common\models\UserNotifications;
use frontend\models\form\AddCommentForm;
use frontend\models\form\ContactForm;
use Yii;
use common\models\Comments;
use yii\data\ActiveDataProvider;

class CommentsWidget extends \yii\bootstrap\Widget
{
    const TYPE_SERVER = 0;
    const TYPE_USER = 1;
    const TYPE_NEWS = 2;

    public $id;
    public $type;

    public function run()
    {
        $query = Comments::find()
            ->where(['main_id' => $this->id, 'type' => $this->type]);

        $provider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 5
            ],
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC,
                ]
            ],
        ]);

        $addCommentModel = new AddCommentForm();
        $addCommentModel->main_id = $this->id;
        $addCommentModel->type = $this->type;

        if (!Yii::$app->user->isGuest) {

            if ($addCommentModel->load(Yii::$app->request->post()) && $addCommentModel->saveComment()) {
                Yii::$app->session->setFlash('success', 'Комментарий успешно добавлен.');

                $user = Yii::$app->user->identity;
                $user->rating_up += 0.5;
                $user->updateRating();

                if ($addCommentModel->type == Comments::TYPE_USER && $addCommentModel->author_id != $addCommentModel->main_id) {
                    $author = User::findOne(['id' => $addCommentModel->author_id]);
                    if ($addCommentModel->type_positive == Comments::POSITIVE) {
                        $author->rating_up += 1;
                    } else {
                        $author->rating_down += 1;
                    }
                    $author->updateRating();
                    $notification = new UserNotifications();
                    $notification->user_id = $addCommentModel->main_id;
                    $notification->type = UserNotifications::TYPE_NEW_USER_COMMENT;
                    $notification->data = json_encode([
                        'username' => Yii::$app->user->identity->username,
                        'comment_id' => $addCommentModel->id,
                        'type_positive' => $addCommentModel->type_positive,
                    ]);
                    $notification->save();
                } else if ($addCommentModel->type == Comments::TYPE_SERVER) {
                    $server = Servers::findOne(['id' => $addCommentModel->main_id]);

                    if ($addCommentModel->type_positive == Comments::POSITIVE) {
                        $server->rating_up += 2;
                    } else {
                        $server->rating_down += 2;
                    }

                    $server->fastCalculateRating();

                    $this->_checkAchievements($server, $addCommentModel->type_positive);
                }

                if ($addCommentModel->type == Comments::TYPE_USER && $addCommentModel->author_id == $addCommentModel->main_id) {
                    Yii::$app->controller->refresh();
                    return;
                }

                if ($addCommentModel->type == Comments::TYPE_SERVER) {
                    $title = Servers::findOne(['id' => $addCommentModel->main_id])->title;
                } else if ($addCommentModel->type == Comments::TYPE_USER) {
                    $title = User::findOne(['id' => $addCommentModel->main_id])->username;
                } else {
                    $title = News::findOne(['id' => $addCommentModel->main_id])->title;
                }

                $activity = new Activity();
                $activity->type = Activity::TYPE_NEW_COMMENT;
                $activity->main_id = Yii::$app->user->id;
                $activity->main_type = Activity::MAIN_TYPE_USER;
                $activity->data = json_encode([
                    'author' => Yii::$app->user->identity->username,
                    'type_positive' => $addCommentModel->type_positive,
                    'title' => $title,
                    'object_type' => $addCommentModel->type,
                    'text' => $addCommentModel->text,
                    'object_id' => $addCommentModel->main_id,
                ]);
                $activity->save();

                Yii::$app->controller->refresh();
                return;
            }
        }

        $addCommentModel->text = '';

        return $this->render('comments/list', [
            'provider' => $provider,
            'addCommentModel' => $addCommentModel,
            'type' => $this->type,
        ]);
    }

    private function _checkAchievements($server, $type_positive)
    {
        if ($type_positive == Comments::POSITIVE) {
            if (!$server->hasAchievement(8) || !$server->hasAchievement(10)) {
                if (!$server->hasAchievement(8)) {
                    $achievement_8 = AchievementsCounter::findOne([
                        'main_id' => $server->id,
                        'main_type' => Achievements::MAIN_TYPE_SERVER,
                        'achievement_id' => 8
                    ]);

                    if (empty($achievement_8)) {
                        $achievement_8 = new AchievementsCounter();
                        $achievement_8->main_id = $server->id;
                        $achievement_8->main_type = Achievements::MAIN_TYPE_SERVER;
                        $achievement_8->achievement_id = 8;
                        $achievement_8->counter = 0;
                    }

                    $achievement_8->counter++;
                    $achievement_8->save();
                }

                $achievement_10 = AchievementsCounter::findOne([
                    'main_id' => $server->id,
                    'main_type' => Achievements::MAIN_TYPE_SERVER,
                    'achievement_id' => 10
                ]);

                if (empty($achievement_10)) {
                    $achievement_10 = new AchievementsCounter();
                    $achievement_10->main_id = $server->id;
                    $achievement_10->main_type = Achievements::MAIN_TYPE_SERVER;
                    $achievement_10->achievement_id = 10;
                    $achievement_10->counter = 0;
                }

                $achievement_10->counter++;
                $achievement_10->save();
            }
        } else {
            if (!$server->hasAchievement(9) || !$server->hasAchievement(11)) {
                if (!$server->hasAchievement(9)) {
                    $achievement_9 = AchievementsCounter::findOne([
                        'main_id' => $server->id,
                        'main_type' => Achievements::MAIN_TYPE_SERVER,
                        'achievement_id' => 9
                    ]);

                    if (empty($achievement_9)) {
                        $achievement_9 = new AchievementsCounter();
                        $achievement_9->main_id = $server->id;
                        $achievement_9->main_type = Achievements::MAIN_TYPE_SERVER;
                        $achievement_9->achievement_id = 9;
                        $achievement_9->counter = 0;
                    }

                    $achievement_9->counter++;
                    $achievement_9->save();
                }

                $achievement_11 = AchievementsCounter::findOne([
                    'main_id' => $server->id,
                    'main_type' => Achievements::MAIN_TYPE_SERVER,
                    'achievement_id' => 11
                ]);

                if (empty($achievement_11)) {
                    $achievement_11 = new AchievementsCounter();
                    $achievement_11->main_id = $server->id;
                    $achievement_11->main_type = Achievements::MAIN_TYPE_SERVER;
                    $achievement_11->achievement_id = 11;
                    $achievement_11->counter = 0;
                }

                $achievement_11->counter++;
                $achievement_11->save();
            }
        }
    }
}