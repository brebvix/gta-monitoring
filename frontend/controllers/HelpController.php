<?php
namespace frontend\controllers;

use Yii;
use frontend\models\form\ContactForm;
use yii\web\Controller;

class HelpController extends Controller
{
    public function actionIndex()
    {
        return $this->redirect(['/']);
    }

    public function actionFaq()
    {
        return $this->render('faq');
    }

    public function actionApi()
    {
        Yii::$app->params['no_layout_card'] = true;

        return $this->render('api');
    }

    public function actionTelegramBot()
    {
        Yii::$app->params['no_layout_card'] = true;

        return $this->render('telegram-bot');
    }

    public function actionRules()
    {
        return $this->render('/rules/main', [
            'hasTitle' => true,
        ]);
    }

    public function actionFeedback()
    {
        $form = new ContactForm();

        if ($form->load(Yii::$app->request->post()) && $form->validate() && $form->sendEmail('servers.fun@gmail.com')) {
            Yii::$app->session->setFlash('success', Yii::t('main', 'Сообщение успешно доставлено администрации.'));

            return $this->redirect(['feedback']);
        }

        return $this->render('feedback', [
            'model' => $form,
        ]);
    }
}