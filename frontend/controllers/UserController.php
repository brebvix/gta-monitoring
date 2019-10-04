<?php

namespace frontend\controllers;

use common\models\Activity;
use common\models\Comments;
use common\models\Dialogs;
use common\models\ServersRating;
use common\models\System;
use common\models\UserPayments;
use frontend\models\form\AvatarUploadForm;
use Yii;
use common\models\User;
use yii\web\Controller;
use frontend\models\form\EditProfileForm;
use yii\web\UploadedFile;
use frontend\models\form\SendMessageForm;
use yii\filters\AccessControl;


class UserController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['balance', 'payment-free-kassa', 'payment-payeer', 'payment-perfect-money', 'telegram-change'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['profile'],
                        'allow' => true,
                    ]
                ],
            ],
        ];
    }

    public function beforeAction($action)
    {
        if ($action->id == 'telegram-change') {
            $this->enableCsrfValidation = false;
        }

        return parent::beforeAction($action);
    }

    public function actionProfile($id = null, $type = null, $type_id = null)
    {
        Yii::$app->params['no_layout_card'] = true;

        if (!isset($id) && !Yii::$app->user->isGuest) {
            $id = Yii::$app->user->id;
        }
        $user = User::findOne(['id' => $id]);

        if (empty($user)) {
            Yii::$app->session->setFlash('error', Yii::t('main', 'Пользователь не найден.'));

            return $this->redirect(['/site/index']);
        }

        $viewData = [
            'user' => $user,
            'rating_up_count' => ServersRating::userRatingCount($user->id, ServersRating::RATING_UP),
            'rating_down_count' => ServersRating::userRatingCount($user->id, ServersRating::RATING_DOWN),
            'comments_count' => count($user->commentsByUser),
            'reviews_count' => Comments::getCountById($user->id, Comments::TYPE_USER),
        ];

        if ($user->id == Yii::$app->user->id) {
            $editProfileModel = new EditProfileForm();

            if ($editProfileModel->load(Yii::$app->request->post()) && $editProfileModel->saveProfile()) {
                Yii::$app->session->setFlash('success', Yii::t('main', 'Изменения успешно сохранены.'));

                return $this->redirect(['profile', 'id' => $user->id, 'type' => 'settings']);
            } else {
                $editProfileModel->load($user);
            }

            $viewData['editProfileModel'] = $editProfileModel;

            $avatarUploadModel = new AvatarUploadForm();

            if (Yii::$app->request->isPost) {
                $avatarUploadModel->avatar = UploadedFile::getInstance($avatarUploadModel, 'avatar');

                if ($avatarUploadModel->avatar && $avatarUploadModel->validate()) {
                    if (is_file('images/avatars/' . $user->avatar_hash . '.png')) {
                        unlink('images/avatars/' . $user->avatar_hash . '.png');
                    }

                    $user->avatar_hash = md5(time() . rand(0, 10000));
                    $user->save();

                    $avatarUploadModel->avatar->saveAs('images/avatars/' . $user->avatar_hash . '.png');

                    return $this->refresh();
                }
            }

            if (!isset($type)) {
                $type = null;
            }

            switch ($type) {
                case 'message':
                    if (isset($type_id)) {
                        $check = Dialogs::checkDialog(Yii::$app->user->id, $type_id);
                        if (!empty($check)) {
                            return Yii::$app->runAction('user/profile', ['id' => Yii::$app->user->id, 'type' => 'view-dialog', 'type_id' => $check->id]);
                        }

                        $viewData['newMessage'] = [
                            'user' => User::findOne(['id' => $type_id]),
                            'sendMessageForm' => new SendMessageForm(),
                        ];
                    }

                    $viewData['active'] = 'message';
                    break;
                case 'settings':
                    $viewData['active'] = 'settings';
                    break;
                case 'comments':
                    $viewData['active'] = 'comments';
                    break;
                case 'dialog':
                    $viewData['active'] = 'message';
                    break;
                case 'view-dialog':
                    $viewData['active'] = 'message';
                    $viewData['dialogData'] = Dialogs::getMessagesById($type_id);
                    $dialog = Dialogs::findOne(['id' => $type_id]);
                    $viewData['newMessage'] = [
                        'user' => User::findOne(['id' => ($dialog->user_one == Yii::$app->user->id ? $dialog->user_two : $dialog->user_one)]),
                        'sendMessageForm' => new SendMessageForm(),
                    ];

                    break;
            }

            $viewData['avatarUploadModel'] = $avatarUploadModel;
            $viewData['dialogList'] = Dialogs::getDialogsByUser($user->id);
        }

        $viewData['activity'] = Activity::find()
            ->where(['main_id' => $user->id, 'main_type' => Activity::MAIN_TYPE_USER])
            ->limit(30)
            ->orderBy(['id' => SORT_DESC])
            ->all();

        if (!isset($viewData['active'])) {
            $viewData['active'] = 'home';
        }

        return $this->render('profile', $viewData);
    }

    public function actionBalance()
    {
        $user = Yii::$app->user->identity;

        return $this->render('balance', [
            'user' => $user,
            'payments' => $user->payments,
        ]);
    }

    public function actionPaymentFreeKassa()
    {
        $amount_rub = Yii::$app->request->post('amount_rub');

        if (empty($amount_rub) || $amount_rub < 10) {
            Yii::$app->session->setFlash('error', Yii::t('main', 'Сумма пополнения не может быть меньше 10р.'));

            return $this->redirect(['balance']);
        }

        $user = User::findOne(['id' => Yii::$app->user->id]);

        $paymentModel = $user->increaseBalance(
            (float)$amount_rub,
            'Free-Kassa',
            'Пополнение',
            UserPayments::STATUS_WAIT);

        return $this->render('payment_redirect/free-kassa', [
            'payment' => $paymentModel
        ]);
    }

    public function actionPaymentPayeer()
    {
        $amount_rub = Yii::$app->request->post('amount_rub');

        if (empty($amount_rub) || $amount_rub < 10) {
            Yii::$app->session->setFlash('error', Yii::t('main', 'Сумма пополнения не может быть меньше 10р.'));

            return $this->redirect(['balance']);
        }

        $user = User::findOne(['id' => Yii::$app->user->id]);

        $paymentModel = $user->increaseBalance(
            (float)$amount_rub,
            'Payeer',
            'Пополнение',
            UserPayments::STATUS_WAIT);

        return $this->render('payment_redirect/payeer', [
            'payment' => $paymentModel
        ]);
    }

    public function actionPaymentPerfectMoney()
    {
        $amount_rub = Yii::$app->request->post('amount_rub');

        if (empty($amount_rub) || $amount_rub < 10) {
            Yii::$app->session->setFlash('error', Yii::t('main', 'Сумма пополнения не может быть меньше 10р.'));

            return $this->redirect(['balance']);
        }

        $user = User::findOne(['id' => Yii::$app->user->id]);

        $paymentModel = $user->increaseBalance(
            (float)$amount_rub,
            'Perfect Money',
            'Пополнение',
            UserPayments::STATUS_WAIT);

        return $this->render('payment_redirect/perfect-money', [
            'payment' => $paymentModel
        ]);
    }

    public function actionTelegramChange()
    {
        $user = User::findOne(['id' => Yii::$app->user->id]);

        if (empty($user)) {
            Yii::$app->session->setFlash('error', Yii::t('main', 'Пользователь не найден.'));

            return $this->redirect(['/site/index']);
        }

        if ($user->telegram_status == User::TELEGRAM_STATUS_DISABLED) {
            $user->telegram_status = User::TELEGRAM_STATUS_WAIT;
            $user->telegram_user_id = round((time() + Yii::$app->user->id + rand(1, 1000000)) * rand(1, 10000) / rand(1, 100));

            if ($user->telegram_user_id <= 0) {
                $user->telegram_user_id = $user->telegram_user_id * (-1);
            }

            $user->save();

            Yii::$app->session->setFlash('success', Yii::t('main', 'Вы начали процедуру подключения аккаунта к Telegram боту, следуйте дальнейшим инструкциям.'));
        } else {
            $user->telegram_status = User::TELEGRAM_STATUS_DISABLED;
            $user->save();

            Yii::$app->session->setFlash('success', Yii::t('main', 'Вы отключили привязку аккаунта к Telegram боту.'));
        }

        return $this->redirect(['user/profile', 'id' => $user->id, 'type' => 'settings']);
    }
}