<?php

namespace frontend\controllers;

use common\models\Dialogs;
use Yii;
use yii\web\Controller;
use frontend\models\form\SendMessageForm;
use yii\filters\AccessControl;

/**
 * Site controller
 */
class MessageController extends Controller
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

    public function actionSend()
    {
        $form = new SendMessageForm();

        if ($form->load(Yii::$app->request->post()) && $form->send()) {
            return Yii::$app->runAction('/user/profile', [
                'id' => Yii::$app->user->id,
                'type' => 'view-dialog',
                'type_id' => $form->dialog_id,
            ]);
        } else {
            return $this->redirect(['/user/profile', 'id' => Yii::$app->user->id]);
        }
    }

    public function actionViewDialog($id)
    {
        return Yii::$app->runAction('/user/profile', [
            'id' => Yii::$app->user->id,
            'type' => 'view-dialog',
            'type_id' => $id,
        ]);
    }
}