<?php
namespace frontend\controllers\freelance;

use common\models\FreelanceVacancies;
use common\models\FreelanceVacanciesList;
use frontend\models\form\freelance\VacancieAddForm;
use frontend\models\search\freelance\VacanciesSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use Yii;

class VacanciesController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['add'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }


    public function actionIndex()
    {
        Yii::$app->params['no_layout_card'] = true;

        $searchModel = new VacanciesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'vacancies_list' => FreelanceVacanciesList::find()->all(),
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
            'active' => $searchModel->vacancie_id,
        ]);
    }

    public function actionAdd()
    {
        Yii::$app->params['no_layout_card'] = true;

        $form = new VacancieAddForm();

        if ($form->load(Yii::$app->request->post()) && $form->addVacancie()) {
            Yii::$app->session->setFlash('success', Yii::t('main', 'Вакансия успешно добавлена.'));

            return $this->redirect(['index']);
        }

        return $this->render('add', [
            'vacancies_list' => FreelanceVacanciesList::find()->all(),
            'addModel' => $form,
        ]);
    }

    public function actionView($id)
    {
        Yii::$app->params['no_layout_card'] = true;

        $vacancie = FreelanceVacancies::findOne(['id' => (int) $id, 'status' => FreelanceVacancies::STATUS_ACTIVE]);

        if (empty($vacancie)) {
            Yii::$app->session->setFlash('warning', Yii::t('main', 'Вакансия не найдена.'));

            return $this->redirect(['index']);
        }

        return $this->render('view', [
            'vacancies_list' => FreelanceVacanciesList::find()->all(),
            'model' => $vacancie,
        ]);
    }

    public function actionUp($id)
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['view']);
        }

        $vacancie = FreelanceVacancies::findOne(['id' => (int) $id, 'status' => FreelanceVacancies::STATUS_ACTIVE]);

        if (empty($vacancie) || $vacancie->user_id != Yii::$app->user->id) {
            Yii::$app->session->setFlash('warning', Yii::t('main', 'Вакансия не найдена.'));

            return $this->redirect(['index']);
        }

        $timeCheck = time() - strtotime($vacancie->date);

        if ($timeCheck >= (60 * 60 * 24)) {
            $vacancie->date = date('Y-m-d H:i:s');
            $vacancie->save();

            Yii::$app->session->setFlash('success', Yii::t('main', 'Вакансия поднята на первое место.'));
        } else {
            Yii::$app->session->setFlash('error', Yii::t('main', 'Поднимать вакансию на первое место можно только один раз в сутки.'));
        }

        return $this->redirect(['view', 'id' => $id]);
    }
}