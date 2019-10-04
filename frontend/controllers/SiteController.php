<?php

namespace frontend\controllers;

use common\models\Activity;
use common\models\Players;
use common\models\Servers;
use common\models\ServersRating;
use common\models\User;
use common\models\UserLoginHistory;
use common\models\UserNotifications;
use common\models\UserUlogin;
use frontend\models\AvatarGenerator;
use frontend\models\search\ServersSearch;
use rmrevin\yii\ulogin\AuthAction;
use rmrevin\yii\ulogin\ULogin;
use Yii;
use yii\base\InvalidArgumentException;
use yii\helpers\HtmlPurifier;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use frontend\models\form\LoginForm;
use frontend\models\form\PasswordResetRequestForm;
use frontend\models\form\ResetPasswordForm;
use frontend\models\form\SignupForm;
use frontend\models\form\ContactForm;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        if ($this->action->id == 'ulogin') {
            $this->enableCsrfValidation = false;
        }

        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup', 'ulogin', 'notification-seen'],
                'rules' => [
                    [
                        'actions' => ['signup', 'ulogin'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            /*'error' => [
                'class' => 'yii\web\ErrorAction',
            ],*/
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionError()
    {
        $this->layout = false;

        $exception = Yii::$app->errorHandler->exception;

        if ($exception !== null) {
            return $this->render('error', ['exception' => $exception]);
        }
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->redirect(['/']);
        //Yii::$app->params['no_layout_card'] = true;

        $searchModel = new ServersSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'serversSearchModel' => $searchModel,
            'serversProvider' => $dataProvider,
        ]);
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        $this->layout = false;
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $recoveryModel = new PasswordResetRequestForm();
        if ($recoveryModel->load(Yii::$app->request->post()) && $recoveryModel->validate()) {
            if ($recoveryModel->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->redirect(Yii::$app->session->get('lastPage', ['/']));
            } else {
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for the provided email address.');
            }
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            Yii::$app->session->setFlash('success', Yii::t('main', 'Вы успешно вошли в аккаунт.'));

            return $this->redirect(Yii::$app->session->get('lastPage', ['/user/profile', 'id' => Yii::$app->user->id]));
        } else {
            $model->password = '';

            return $this->render('login', [
                'model' => $model,
                'recoveryModel' => $recoveryModel,
            ]);
        }
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $this->layout = false;

        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    Yii::$app->session->setFlash('success', Yii::t('main', 'Вы успешно зарегистрировались.'));

                    return $this->redirect(Yii::$app->session->get('lastPage', ['/user/profile', 'id' => $user->id]));
                }
            }
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for the provided email address.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }

    public function actionActivity()
    {
        return $this->render('activity', [
            'data' => Activity::find()
                ->orderBy(['id' => SORT_DESC])
                ->limit(50)
                ->all()
        ]);
    }

    public function actionNotificationsSeen()
    {
        $this->layout = false;

        if (Yii::$app->request->isAjax && !Yii::$app->user->isGuest) {
            $notifications = UserNotifications::find()
                ->where(['user_id' => Yii::$app->user->id, 'seen' => UserNotifications::SEEN_NO])
                ->all();

            foreach ($notifications AS $notification) {
                $notification->seen = UserNotifications::SEEN_YES;
                $notification->save();
            }

            echo 'success';
        }
    }

    public function actionSearch()
    {
        $searchText = Yii::$app->request->get('search', '');

        if (empty($searchText) || strlen($searchText) < 3) {
            return $this->redirect(['index']);
        }

        $searchText = htmlspecialchars(str_replace(["'", "\"", '\"'], "", $searchText));

        $users = User::find()
            ->where(['like', 'username', $searchText . '%', false])
            ->limit(20)
            ->orderBy(['rating' => SORT_DESC])
            ->all();

        //$checkIp =

        $servers = Servers::find()
            ->with('achievements')
            ->where(['like', 'title', $searchText . '%', false]);

        $checkIpDots = explode('.', $searchText);
        $checkIpPort = explode(':', $searchText);

        if (count($checkIpDots) == 4 || count($checkIpPort) == 2) {
            $servers->orWhere(['ip' => $checkIpPort[0]]);
        }

        $servers = $servers->limit(20)
            ->orderBy(['rating' => SORT_DESC])
            ->all();

        $players = Players::find()
            ->where(['like', 'nickname', $searchText . '%', false])
            ->limit(20)
            ->orderBy(['date' => SORT_DESC])
            ->all();

        return $this->render('search', [
            'users' => $users,
            'servers' => $servers,
            'players' => $players,
            'searchText' => $searchText,
        ]);
    }

    public function actionUlogin()
    {
        $post = Yii::$app->request->post();
        if (!isset($post['token'])) {
            return $this->redirect(['/']);
        }
        $data = ULogin::getUserAttributes($post['token']);


        if (empty($data) || isset($data['error'])) {
            Yii::$app->session->setFlash('error', Yii::t('main', 'Ошибка при авторизации, попробуйте позже.'));

            return $this->redirect(['index']);
        }

        $loginCheck = UserUlogin::find()
            ->where(['identity' => $data['identity'], 'network' => $data['network']])
            ->one();

        $userCheck = User::findOne(['email' => $data['email']]);

        if (!empty($loginCheck)) {
            $user = User::findOne(['id' => $loginCheck->user_id, 'status' => User::STATUS_ACTIVE]);

            if (!empty($user)) {
                Yii::$app->user->login($user);

                $history = new UserLoginHistory();
                $history->user_id = $user->id;
                $history->ip = User::getIp();
                $history->save();

                Yii::$app->session->setFlash('success', Yii::t('main', 'Вы успешно авторизовались.'));

                return $this->redirect(Yii::$app->session->get('lastPage', ['/user/profile', 'id' => $user->id]));
            }

            Yii::$app->session->setFlash('error', Yii::t('main', 'Ошибка авторизации, обратитесь к администрации.'));

            return $this->redirect(['/site/login']);
        } else if (!empty($userCheck)) {
            Yii::$app->session->setFlash('error', Yii::t('main', 'Пользователь с таким E-Mail уже зарегистрирован, обратитесь к администрации.'));

            return $this->redirect(['/site/login']);
        }

        $nickname = explode('@', $data['email']);

        $checkExist = User::findOne(['username' => $nickname]);

        if (!empty($checkExist)) {
            $nickname .= '1';
        }

        $user = new User();
        $user->username = $nickname[0];
        $user->email = $data['email'];
        $user->auth_key = '';
        $user->password_hash = '';
        $user->created_at = time();
        $user->updated_at = time();

        if (Yii::$app->language != 'ru-RU') {
            $user->language = 'en';
        }


        if ($user->save()) {
            $userUlogin = new UserUlogin();
            $userUlogin->user_id = $user->id;
            $userUlogin->identity = $data['identity'];
            $userUlogin->network = $data['network'];
            $userUlogin->save();

            $history = new UserLoginHistory();
            $history->user_id = $user->id;
            $history->ip = User::getIp();
            $history->save();

            $activity = new Activity();
            $activity->type = Activity::TYPE_NEW_USER;
            $activity->main_id = $user->id;
            $activity->main_type = Activity::MAIN_TYPE_USER;
            $activity->data = json_encode(['username' => $user->username]);
            $activity->save();

            if (isset($data['photo_big'])) {
                $avatar_hash = md5(time() . rand(0, 10000));

                $explode = explode('.', $data['photo_big']);
                $extension = end($explode);

                $arrContextOptions = array(
                    "ssl" => array(
                        "verify_peer" => false,
                        "verify_peer_name" => false,
                    ),
                );

                $image = imagecreatefromstring(@file_get_contents($data['photo_big'], false, stream_context_create($arrContextOptions)));

                imagepng($image, 'images/avatars/' . $avatar_hash . '.png');

                $user->avatar_hash = $avatar_hash;
                $user->save();
            } else {
                $user->avatar_hash = md5(time() . rand(0, 10000));
                $generateImageStatus = imagepng(AvatarGenerator::generate(400, 'male', md5(time() + rand(0, 1000000))), 'images/avatars/' . $user->avatar_hash . '.png');

                if ($generateImageStatus) {
                    $user->save();
                }
            }


            Yii::$app->user->login($user);

            Yii::$app->session->setFlash('success', Yii::t('main', 'Вы успешно зарегистрировались.'));

            return $this->redirect(Yii::$app->session->get('lastPage', ['/user/profile', 'id' => $user->id]));
        }

        Yii::$app->session->setFlash('error', Yii::t('main', 'Ошибка регистрации, обратитесь к администрации.'));

        return $this->redirect(['/site/signup']);
    }
}