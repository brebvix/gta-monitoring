<?php

namespace frontend\modules\developer\models;

use common\models\Activity;
use Yii;
use common\models\User;

/**
 * This is the model class for table "questions_rating".
 *
 * @property int $id
 * @property int $user_id Пользователь
 * @property int $question_id Вопрос
 * @property string $date Дата
 *
 * @property Questions $question
 * @property User $user
 */
class QuestionsRating extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'questions_rating';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'question_id'], 'required'],
            [['user_id', 'question_id'], 'integer'],
            [['date'], 'safe'],
            [['question_id'], 'exist', 'skipOnError' => true, 'targetClass' => Questions::className(), 'targetAttribute' => ['question_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('questions', 'ID'),
            'user_id' => Yii::t('questions', 'Пользователь'),
            'question_id' => Yii::t('questions', 'Вопрос'),
            'date' => Yii::t('questions', 'Дата'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuestion()
    {
        return $this->hasOne(Questions::className(), ['id' => 'question_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public static function updateRating($id, $type)
    {
        $questionModel = Questions::findOne(['id' => $id]);

        if (empty($questionModel) || $questionModel->user_id == Yii::$app->user->id) {
            return false;
        }

        $checkExist = self::findOne(['question_id' => $id, 'user_id' => Yii::$app->user->id]);

        if (!empty($checkExist) || !in_array($type, ['up', 'down'])) {
            Yii::$app->session->setFlash('warning', Yii::t('questions', 'Вы уже изменяли рейтинг этого вопроса.'));

            return false;
        }

        $model = new QuestionsRating();
        $model->user_id = Yii::$app->user->id;
        $model->question_id = $id;
        $model->save();

        $activity = new Activity();
        $activity->main_id = $model->user_id;
        $activity->main_type = Activity::MAIN_TYPE_USER;
        $activity->type = Activity::TYPE_QUESTION_RATING_CHANGE;

        $activity->data = json_encode([
            'username' => $model->user->username,
            'question_id' => $model->question_id,
            'parent_category_eng' => $model->question->category->parent->title_eng,
            'category_eng' => $model->question->category->title_eng,
            'title_eng' => $model->question->title_eng,
            'title' => $model->question->title,
            'type_positive' => $type,
        ]);

        $activity->save();

        if ($type == 'up') {
            $questionModel->rating++;
        } else {
            $questionModel->rating--;
        }

        return $questionModel->save();
    }
}
