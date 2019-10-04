<?php
namespace frontend\controllers;

use frontend\models\search\NewsSearch;
use yii\web\Controller;
use common\models\News;
use Yii;
use common\models\NewsCategories;

class NewsController extends Controller
{
    public function actionIndex($category = null)
    {
        $news = new NewsSearch();
        $news->category = $category;

        $newsCategories = NewsCategories::find()
            ->all();

        $newsCount = News::find()
            ->where(['language' => Yii::$app->language])
            ->count();

        return $this->render('index', [
            'newsCategories' => $newsCategories,
            'activeCategory' => $category,
            'newsCount' => $newsCount,
            'dataProvider' => $news->search(),
        ]);
    }

    public function actionView($id)
    {
        $news = News::findOne(['id' => (int) $id]);

        if (empty($news)) {
            Yii::$app->session->setFlash('error', Yii::t('main', 'Новость не найдена.'));

            return $this->redirect(['index']);
        }

        $viewedNews = Yii::$app->session->get('viewedNews', []);
        if (!isset($viewedNews[$news->id])) {
            $viewedNews[$news->id] = true;
            Yii::$app->session->set('viewedQuestions', $viewedNews);

            $news->views_count++;
            $news->save();
        }

        return $this->render('view', [
            'news' => $news,
        ]);
    }
}