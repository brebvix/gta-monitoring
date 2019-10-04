<?php

namespace frontend\controllers;

use Codeception\Step\Comment;
use common\models\AchievementsCounter;
use common\models\Activity;
use common\models\Comments;
use common\models\Servers;
use common\models\UserNotifications;
use Yii;
use yii\db\ActiveRecordInterface;
use yii\filters\AccessControl;
use yii\web\Controller;
use common\models\ServersRating;
use common\models\CommentsRating;

/**
 * Site controller
 */
class RatingController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionUp($server_id)
    {
        if (Yii::$app->user->isGuest) {
            Yii::$app->session->setFlash('error', Yii::t('main', 'Голосование доступно только авторизованным пользователям.'));
            return $this->redirect(['/site/login']);
        }

        $result = ServersRating::calculate((int) $server_id, ServersRating::RATING_UP);

        if ($result) {
            $activity = new Activity();
            $activity->main_id = Yii::$app->user->id;
            $activity->main_type = Activity::MAIN_TYPE_USER;
            $activity->type = Activity::TYPE_SERVER_RATING_CHANGE;
            $activity->data = json_encode([
                'username' => Yii::$app->user->identity->username,
                'server_id' => $server_id,
                'title' => Servers::findOne(['id' => $server_id])->title,
                'rating_type' => ServersRating::RATING_UP,
            ]);
            $activity->save();

            Yii::$app->session->setFlash('success', Yii::t('main', 'Вы успешно повысили рейтинг сервера.'));
        }

        return $this->redirect(['/server/view', 'id' => $server_id]);
    }

    public function actionDown($server_id)
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['/site/login']);
            Yii::$app->session->setFlash('error', Yii::t('main', 'Голосование доступно только авторизованным пользователям.'));
        }

        $result = ServersRating::calculate($server_id, ServersRating::RATING_DOWN);

        if ($result) {
            $activity = new Activity();
            $activity->main_id = Yii::$app->user->id;
            $activity->main_type = Activity::MAIN_TYPE_USER;
            $activity->type = Activity::TYPE_SERVER_RATING_CHANGE;
            $activity->data = json_encode([
                'username' => Yii::$app->user->identity->username,
                'server_id' => $server_id,
                'title' => Servers::findOne(['id' => $server_id])->title,
                'rating_type' => ServersRating::RATING_DOWN,
            ]);
            $activity->save();

            Yii::$app->session->setFlash('success', Yii::t('main', 'Вы успешно понизили рейтинг сервера.'));
        }

        return $this->redirect(['/server/view', 'id' => $server_id]);
    }

    public function actionCommentUp($comment_id)
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['/site/login']);
            Yii::$app->session->setFlash('error', Yii::t('main', 'Голосование доступно только авторизованным пользователям.'));
        }

        $result = CommentsRating::calculate($comment_id, CommentsRating::RATING_UP);

        if ($result) {
            Yii::$app->session->setFlash('success', Yii::t('main', 'Вы успешно повысили рейтинг комментария.'));
        } else {
            return $this->goBack();
        }

        $comment = Comments::findOne(['id' => (int)$comment_id]);

        if (!empty($comment)) {
            $activity = new Activity();
            $activity->main_id = Yii::$app->user->id;
            $activity->main_type = Activity::MAIN_TYPE_USER;
            $activity->type = Activity::TYPE_COMMENT_RATING_CHANGE;
            $activity->data = json_encode([
                'username' => Yii::$app->user->identity->username,
                'comment_author_id' => $comment->author_id,
                'comment_message' => $comment->text,
                'rating_type' => CommentsRating::RATING_UP,
            ]);
            $activity->save();

            $notification = new UserNotifications();
            $notification->user_id =  $comment->author_id;
            $notification->type = UserNotifications::TYPE_COMMENT_RATING_CHANGE;
            $notification->data = json_encode([
                'username' => Yii::$app->user->identity->username,
                'comment_message' => $comment->text,
                'comment_type' => $comment->type,
                'type_positive' => CommentsRating::RATING_UP,
            ]);
            $notification->save();

            return $this->redirect($comment->type == Comments::TYPE_USER ? ['/user/profile', 'id' => $comment->user_id] : ['/server/view', 'id' => $comment->server_id]);
        }

        return $this->goBack();
    }

    public function actionCommentDown($comment_id)
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['/site/login']);
            Yii::$app->session->setFlash('error', Yii::t('main', 'Голосование доступно только авторизованным пользователям.'));
        }

        $result = CommentsRating::calculate($comment_id, CommentsRating::RATING_DOWN);

        if ($result) {
            Yii::$app->session->setFlash('success', Yii::t('main', 'Вы успешно понизили рейтинг комментария.'));
        } else {
            return $this->goBack();
        }

        $comment = Comments::findOne(['id' => (int)$comment_id]);

        if (!empty($comment)) {
            $activity = new Activity();
            $activity->main_id = Yii::$app->user->id;
            $activity->main_type = Activity::MAIN_TYPE_USER;
            $activity->type = Activity::TYPE_COMMENT_RATING_CHANGE;
            $activity->data = json_encode([
                'username' => Yii::$app->user->identity->username,
                'comment_author_id' => $comment->author_id,
                'comment_message' => $comment->text,
                'rating_type' => CommentsRating::RATING_DOWN,
            ]);
            $activity->save();

            $notification = new UserNotifications();
            $notification->user_id =  $comment->author_id;
            $notification->type = UserNotifications::TYPE_COMMENT_RATING_CHANGE;
            $notification->data = json_encode([
                'username' => Yii::$app->user->identity->username,
                'comment_message' => $comment->text,
                'comment_type' => $comment->type,
                'type_positive' => CommentsRating::RATING_DOWN,
            ]);
            $notification->save();

            return $this->redirect($comment->type == Comments::TYPE_USER ? ['/user/profile', 'id' => $comment->user_id] : ['/server/view', 'id' => $comment->server_id]);
        }

        return $this->goBack();
    }
}