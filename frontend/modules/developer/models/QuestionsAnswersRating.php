<?php

namespace frontend\modules\developer\models;

use common\models\Activity;
use Yii;
use common\models\User;

/**
 * This is the model class for table "questions_answers_rating".
 *
 * @property int $id
 * @property int $user_id Пользователь
 * @property int $answer_id Ответ
 * @property string $date Дата
 *
 * @property QuestionsAnswers $answer
 * @property User $user
 */
class QuestionsAnswersRating extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'questions_answers_rating';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'answer_id'], 'required'],
            [['user_id', 'answer_id'], 'integer'],
            [['date'], 'safe'],
            [['answer_id'], 'exist', 'skipOnError' => true, 'targetClass' => QuestionsAnswers::className(), 'targetAttribute' => ['answer_id' => 'id']],
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
            'answer_id' => Yii::t('questions', 'Ответ'),
            'date' => Yii::t('questions', 'Дата'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAnswer()
    {
        return $this->hasOne(QuestionsAnswers::className(), ['id' => 'answer_id']);
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
        $questionModel = QuestionsAnswers::findOne(['id' => $id]);

        if (empty($questionModel) || $questionModel->user_id == Yii::$app->user->id) {
            return false;
        }

        $checkExist = self::findOne(['answer_id' => $id, 'user_id' => Yii::$app->user->id]);

        if (!empty($checkExist) || !in_array($type, ['up', 'down'])) {
            Yii::$app->session->setFlash('warning', Yii::t('questions', 'Вы уже изменяли рейтинг этого ответа.'));

            return false;
        }

        $model = new QuestionsAnswersRating();
        $model->user_id = Yii::$app->user->id;
        $model->answer_id = $id;
        $model->save();

        $activity = new Activity();
        $activity->main_id = $model->user_id;
        $activity->main_type = Activity::MAIN_TYPE_USER;
        $activity->type = Activity::TYPE_QUESTION_ANSWER_RATING_CHANGE;

        $activity->data = json_encode([
            'username' => $model->user->username,
            'question_id' => $model->answer->question_id,
            'parent_category_eng' => $model->answer->question->category->parent->title_eng,
            'category_eng' => $model->answer->question->category->title_eng,
            'title_eng' => $model->answer->question->title_eng,
            'title' => $model->answer->question->title,
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
