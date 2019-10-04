<?php

namespace frontend\modules\developer\controllers;

use frontend\modules\developer\models\QuestionsAnswers;
use frontend\modules\developer\models\QuestionsAnswersRating;
use frontend\modules\developer\models\QuestionsCategories;
use frontend\modules\developer\models\QuestionsComments;
use frontend\modules\developer\models\QuestionsRating;
use frontend\modules\developer\models\QuestionsTags;
use frontend\modules\developer\models\QuestionsTagsRelations;
use frontend\modules\developer\models\search\AnswersSearch;
use Yii;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use frontend\modules\developer\models\Questions;

class QuestionsController extends Controller
{
    public function actionAdd()
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['/site/login']);
        }

        $form = new Questions();

        if ($form->load(Yii::$app->request->post()) && $form->add()) {
            Yii::$app->session->setFlash('success', Yii::t('questions', 'Вы успешно добавили вопрос'));

            return $this->redirect(['/developer/default/index']);
        }

        $categories = QuestionsCategories::find()
            ->where(['<>', 'parent_id', '-1'])
            ->with('parent')
            ->all();

        $resultArray = [];
        foreach ($categories AS $category) {
            $title = $category->parent->title . ' > ' . Yii::t('questions', $category->title);
            $resultArray[$category->parent->title][$category->id] = $title;
        }

        $tagsList = [];
        $tags = QuestionsTags::find()
            ->all();

        foreach ($tags AS $tag) {
            $tagsList[$tag->title] = $tag->title;
        }

        return $this->render('add', [
            'model' => $form,
            'categoriesList' => $resultArray,
            'tagsList' => $tagsList,
        ]);
    }

    public function actionView($category, $child_category, $id, $title)
    {
        $question = Questions::find()
            ->where(['id' => (int)$id])
            ->with('category')
            ->with('tags')
            ->with('comments')
            ->one();

        if (empty($question)) {
            Yii::$app->session->setFlash('error', Yii::t('questions', 'Вопрос не найден.'));
            return $this->redirect(['/developer']);
        }

        $viewedQuestions = Yii::$app->session->get('viewedQuestions', []);
        if (!isset($viewedQuestions[$question->id])) {
            $viewedQuestions[$question->id] = true;
            Yii::$app->session->set('viewedQuestions', $viewedQuestions);

            $question->views_count++;
            $question->save();
        }

        if (!Yii::$app->user->isGuest) {
            $answerForm = new QuestionsAnswers();

            if ($answerForm->load(Yii::$app->request->post()) && $answerForm->add((int) $id)) {
                Yii::$app->session->setFlash('success', Yii::t('questions', 'Ответ успешно добавлен'));
                return $this->refresh();
            }

            $commentForm = new QuestionsComments();
            $commentForm->question_id = (int) $id;

            if ($commentForm->load(Yii::$app->request->post()) && $commentForm->add()) {
                Yii::$app->session->setFlash('success', Yii::t('questions', 'Комментарий успешно добавлен'));
                return $this->refresh();
            }
        } else {
            $answerForm = [];
            $commentForm = [];
        }

        $answersSearch = new AnswersSearch();
        $answersSearch->question_id = (int) $id;
        $answersProvider = $answersSearch->search();

        Yii::$app->params['activeCategory'] = $question->category_id;

        return $this->render('view', [
            'question' => $question,
            'answerModel' => $answerForm,
            'commentModel' => $commentForm,
            'answersProvider' => $answersProvider,
        ]);
    }

    public function actionRating($id, $type)
    {
        if (Yii::$app->user->isGuest) {
            Yii::$app->session->setFlash('warning', Yii::t('questions', 'Авторизуйтесь, чтобы изменять рейтинг.'));
            return $this->goBack();
        }

        $result = QuestionsRating::updateRating((int) $id, $type);

        if ($result) {
            Yii::$app->session->setFlash('success', Yii::t('questions', 'Вы успешно изменили рейтинг.'));
        }

        return $this->goBack();
    }

    public function actionAnswerRating($id, $type)
    {
        if (Yii::$app->user->isGuest) {
            Yii::$app->session->setFlash('warning', Yii::t('questions', 'Авторизуйтесь, чтобы изменять рейтинг.'));
            return $this->goBack();
        }

        $result = QuestionsAnswersRating::updateRating((int) $id, $type);

        if ($result) {
            Yii::$app->session->setFlash('success', Yii::t('questions', 'Вы успешно изменили рейтинг.'));
        }

        return $this->goBack();
    }

    public function actionTag($tag)
    {
        $tagModel = QuestionsTags::findOne(['title_eng' => $tag]);

        if (empty($tagModel)) {
            Yii::$app->session->setFlash('error',Yii::t('questions', 'Тег не найден.'));
            return $this->goBack();
        }

        $model = Questions::find()
            ->where(['in', 'id', ArrayHelper::map(QuestionsTagsRelations::findAll(['tag_id' => $tagModel->id]), 'id', 'question_id')])
            ->with('category')
            ->with('tags');

        $dataProvider = new ActiveDataProvider([
            'query' => $model,
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC,
                ]
            ],
        ]);

        return $this->render('tag', [
            'dataProvider' => $dataProvider,
            'tag' => $tagModel->title,
        ]);
    }

    public function actionCategory($category)
    {
        $categoryModel = QuestionsCategories::findOne(['title_eng' => $category]);

        if (empty($categoryModel)) {
            Yii::$app->session->setFlash('error', Yii::t('main', 'Категория не найдена.'));

            return $this->goBack();
        }

        Yii::$app->params['activeCategory'] = $categoryModel->id;

        $childCategories = QuestionsCategories::find()
            ->where(['parent_id' => $categoryModel->id])
            ->asArray()
            ->all();

        $model = Questions::find()
            ->where(['in', 'category_id', ArrayHelper::map($childCategories, 'id', 'id')])
            ->with('category')
            ->with('tags');

        $dataProvider = new ActiveDataProvider([
            'query' => $model,
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC,
                ]
            ],
        ]);

        return $this->render('category', [
            'dataProvider' => $dataProvider,
            'category' => $categoryModel->title,
        ]);
    }

    public function actionChildCategory($category, $child)
    {
        $parent = QuestionsCategories::findOne(['title_eng' => $category]);
        if (empty($parent)) {
            Yii::$app->session->setFlash('error', Yii::t('main', 'Категория не найдена.'));

            return $this->goBack();
        }

        $categoryModel = QuestionsCategories::findOne(['title_eng' => $child, 'parent_id' => $parent->id]);

        if (empty($categoryModel)) {
            Yii::$app->session->setFlash('error', Yii::t('main', 'Категория не найдена.'));

            return $this->goBack();
        }

        Yii::$app->params['activeCategory'] = $categoryModel->id;

        $model = Questions::find()
            ->where(['category_id' => $categoryModel->id])
            ->with('category')
            ->with('tags');

        $dataProvider = new ActiveDataProvider([
            'query' => $model,
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC,
                ]
            ],
        ]);

        return $this->render('child_category', [
            'dataProvider' => $dataProvider,
            'parent_category' => $categoryModel->parent->title,
            'category' => $categoryModel->title,
        ]);
    }
}