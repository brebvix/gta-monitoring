<?php
namespace frontend\controllers\freelance;

use common\models\FreelanceServices;
use common\models\FreelanceVacancies;
use common\models\FreelanceVacanciesList;
use frontend\models\search\freelance\ServicesSearch;
use frontend\models\form\freelance\ServiceAddForm;
use yii\filters\AccessControl;
use yii\web\Controller;
use Yii;

class ServicesController extends Controller
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

        $searchModel = new ServicesSearch();
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

        $form = new ServiceAddForm();

        if ($form->load(Yii::$app->request->post()) && $form->addService()) {
            Yii::$app->session->setFlash('success', Yii::t('main', 'Услуга успешно добавлена.'));

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

        $service = FreelanceServices::findOne(['id' => (int) $id, 'status' => FreelanceServices::STATUS_ACTIVE]);

        if (empty($service)) {
            Yii::$app->session->setFlash('warning', Yii::t('main', 'Услуга не найдена.'));

            return $this->redirect(['index']);
        }

        return $this->render('view', [
            'vacancies_list' => FreelanceVacanciesList::find()->all(),
            'model' => $service,
        ]);
    }
}