<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "comments_rating".
 *
 * @property int $id
 * @property int $comment_id
 * @property int $user_id
 * @property int $type
 * @property string $date
 *
 * @property Comments $comment
 * @property User $user
 */
class CommentsRating extends \yii\db\ActiveRecord
{
    const RATING_DOWN = 0;
    const RATING_UP = 1;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'comments_rating';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['comment_id', 'user_id'], 'required'],
            [['comment_id', 'user_id', 'type'], 'integer'],
            [['date'], 'safe'],
            [['comment_id'], 'exist', 'skipOnError' => true, 'targetClass' => Comments::className(), 'targetAttribute' => ['comment_id' => 'id']],
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
            'comment_id' => Yii::t('main', 'ID комментария'),
            'user_id' => Yii::t('main', 'ID пользователя'),
            'type' => Yii::t('main', 'Тип'),
            'date' => Yii::t('main', 'Дата'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComment()
    {
        return $this->hasOne(Comments::className(), ['id' => 'comment_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public static function calculate($comment_id, $type)
    {
        $comment = Comments::findOne(['id' => $comment_id]);

        if (empty($comment)) {
            return false;
        }

        if ($comment->author_id == Yii::$app->user->id) {
            Yii::$app->session->setFlash('error', 'Вы не можете влиять на рейтинг собственного комментария.');

            return false;
        }

        if (!self::_isAvailable($comment_id)) {
            Yii::$app->session->setFlash('error', 'Вы уже изменяли рейтинг этого комментария.');

            return false;
        }

        $model = new CommentsRating();
        $model->comment_id = (int) $comment_id;
        $model->user_id = Yii::$app->user->id;
        $model->type = $type;

        if ($model->save()) {
            if ($comment->type == Comments::TYPE_USER) {
                $author = User::findOne(['id' => $comment->author_id]);
                $user = User::findOne(['id' => Yii::$app->user->id]);

                $user->rating_up += 0.05;
                $user->updateRating();

                if ($type == CommentsRating::RATING_UP) {
                    $author->rating_up += 0.2;
                } else {
                    $author->rating_down += 0.2;
                }

                $author->updateRating();
            }
            if ($type == CommentsRating::RATING_UP) {
                $comment->rating++;
            } else {
                $comment->rating--;
            }

            return $comment->save();
        }

        return false;
    }

    private static function _isAvailable($comment_id)
    {
        $check = CommentsRating::find()
            ->where(['user_id' => Yii::$app->user->id, 'comment_id' => $comment_id])
            ->count();

        return ($check > 0) ? false : true;
    }
}
