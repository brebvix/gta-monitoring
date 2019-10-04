<?php

namespace frontend\controllers\payments;

use common\models\System;
use common\models\User;
use common\models\UserPayments;
use Yii;
use yii\web\Controller;

class CryptoController extends Controller
{

    public function beforeAction($action)
    {
        Yii::$app->controller->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    private function generateHash($body)
    {
        $hash = $body['secret_hash'];
        unset($body['secret_hash']);
        if ($hash == sha1(implode('&', $body) . '&' . '*SECRET_HERE*')) {
            return true;
        } else {
            return false;
        }
    }

    public function actionResult()
    {
        $post = Yii::$app->request->post();
        if (isset($post['invoice_status'], $post['secret_hash'], $post['invoice_currency'], $post['invoice_amount'], $post['order_id'])) {
            if ($post['invoice_status'] == 'paid') {
                if ($this->generateHash($post)) {
                    $user = User::findOne(['id' => $post['order_id']]);

                    $check2 = UserPayments::find()->where(['user_id' => $post['order_id'], 'amount_usd' => $post['invoice_amount']])->andWhere(['>=', 'date', date('Y-m-d')])->all();

                    if (!empty($check2) && !empty($user)) {
                        return $this->redirect(['/']);
                    }

                    $course = System::findOne(['key' => 'course_rub'])->value;

                    $amount =  $post['invoice_amount'] * $course;

                    if ($amount >= 50) {
                        $amount = $amount * 1.05;
                    }

                    $user->increaseBalance($amount, ucfirst($post['checkout_currency']), Yii::t('main', 'Пополнение'));

                    Yii::$app->session->setFlash('success', Yii::t('main', 'Средства успешно зачислены на ваш баланс.'));

                    return $this->redirect(['/user/balance']);
                }
            }
        }

        Yii::$app->session->setFlash('error', Yii::t('main', 'Ошибка оплаты, обратитесь к администрации.'));

        return $this->redirect(['/user/balance']);
    }

    public function actionSuccess()
    {

        Yii::$app->session->setFlash('success', Yii::t('main', 'Средства успешно зачисленны на Ваш баланс.'));

        return $this->redirect(['/user/balance']);
    }

    public function actionFailure()
    {
        Yii::$app->session->setFlash('error', Yii::t('main', 'Вы отказались от оплаты, средства не зачислены.'));

        return $this->redirect(['/user/balance']);
    }
}
