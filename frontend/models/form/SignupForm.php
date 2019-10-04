<?php

namespace frontend\models\form;

use common\models\Activity;
use frontend\models\AvatarGenerator;
use Yii;
use yii\base\Model;
use common\models\User;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $username;
    public $email;
    public $password;
    public $rePassword;
    public $reCaptcha;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => 'Это имя занято.'],
            ['username', 'string', 'min' => 2, 'max' => 16],
            ['username', 'match', 'pattern' => '/^[a-zA-Z0-9_-]+$/', 'message' => Yii::t('main', 'Введите никнейм в правильном формате.')],

            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'Этот E-Mail занят.'],

            [['password', 'rePassword'], 'required'],
            [['password', 'rePassword'], 'string', 'min' => 6],
            ['rePassword', 'compare', 'compareAttribute' => 'password', 'message' => Yii::t('main', 'Пароли не совпадают.')],

            [['reCaptcha'], \himiklab\yii2\recaptcha\ReCaptchaValidator::className()],

        ];
    }

    public function attributeLabels()
    {
        $user = new User();
        return $user->attributeLabels();
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }

        $user = new User();
        $user->username = $this->username;
        $user->email = $this->email;
        $user->setPassword($this->password);

        if (Yii::$app->language != 'ru-RU') {
            $user->language = 'en';
        }

        $user->generateAuthKey();

        if ($user->save()) {
            $user->avatar_hash = md5(time() . rand(0, 10000));
            $generateImageStatus = imagepng(AvatarGenerator::generate(400, 'male', md5(time() + rand(0,1000000))), 'images/avatars/' . $user->avatar_hash . '.png');

            if ($generateImageStatus) {
                $user->save();
            }

            $auth = Yii::$app->authManager;
            $authorRole = $auth->getRole('user');
            $auth->assign($authorRole, $user->getId());

            $activity = new Activity();
            $activity->type = Activity::TYPE_NEW_USER;
            $activity->main_id = $user->id;
            $activity->main_type = Activity::MAIN_TYPE_USER;
            $activity->data = json_encode(['username' => $user->username]);
            $activity->save();

            return $user;
        } else {
            return null;
        }
    }
}
