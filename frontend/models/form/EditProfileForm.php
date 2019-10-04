<?php

namespace frontend\models\form;

use Yii;
use yii\base\Model;
use yii\helpers\HtmlPurifier;
use common\models\User;

/**
 * Login form
 */
class EditProfileForm extends Model
{
    public $about_me;
    public $skype;
    public $telegram;
    public $vk;
    public $oldPassword;
    public $newPassword;
    public $reNewPassword;

    private $_user;


    public function __construct(array $config = [])
    {
        parent::__construct($config);

        $this->about_me = $this->getUser()->about_me;
        $this->telegram = $this->getUser()->telegram;
        $this->vk = $this->getUser()->vk;
        $this->skype = $this->getUser()->skype;
    }

    public function attributeLabels()
    {
        return [
            'about_me' => Yii::t('main', 'Обо мне'),
            'oldPassword' => Yii::t('main', 'Текущий пароль'),
            'newPassword' => Yii::t('main', 'Новый пароль'),
            'reNewPassword' => Yii::t('main', 'Повторите новый пароль'),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['skype', 'telegram', 'vk'], 'string', 'max' => 32, 'min' => 4],
            [['about_me'], 'string', 'max' => 160, 'min' => 10],
            [['oldPassword', 'newPassword', 'reNewPassword'], 'safe'],
            // username and password are both required
            //[['username', 'password'], 'required'],
            // rememberMe must be a boolean value
            //['rememberMe', 'boolean'],
            // password is validated by validatePassword()
            //['password', 'validatePassword'],
            ['newPassword', 'string', 'min' => 6, 'max' => 32],
            ['reNewPassword', 'compare', 'compareAttribute' => 'newPassword', 'message' => Yii::t('main', 'Пароли не совпадают!')],
        ];
    }


    public function saveProfile()
    {
        $user = $this->getUser();

        $user->about_me = HTMLPurifier::process($this->about_me);
        $user->telegram = HTMLPurifier::process($this->telegram);
        $user->vk = HTMLPurifier::process($this->vk);
        $user->skype = HTMLPurifier::process($this->skype);

        if (!empty($this->oldPassword)) {
            if ($user->validatePassword($this->oldPassword)) {
                $user->setPassword($this->newPassword);

                Yii::$app->session->setFlash('info', Yii::t('main', 'Вы успешно сменили пароль.'));
            } else {
                Yii::$app->session->setFlash('error', Yii::t('main', 'Не удалось сменить пароль, проверьте правильность текущего пароля.'));
            }
        }

        return $user->save();
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    protected function getUser()
    {
        if ($this->_user === null) {
            $this->_user = Yii::$app->user->identity;
        }

        return $this->_user;
    }
}
