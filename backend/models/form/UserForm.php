<?php
namespace backend\models\form;

use Yii;
use yii\base\Model;
use common\models\User;

/**
 * Login form
 */
class UserForm extends Model
{
    public $id;
    public $username;
    public $password;
    public $email;
    public $status;
    public $balance;

    private $_user;

    public function __construct(User $user, $config = []) {
        $this->_user = $user;
        parent::__construct($config);
    }

    public function init() {
        $this->id = $this->_user->id;
        $this->email = $this->_user->email;
        $this->username = $this->_user->username;
        $this->status = $this->_user->status;
        $this->balance = $this->_user->balance;

        parent::init();
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'email', 'status', 'balance'], 'required'],
            ['password', 'string'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'username' => 'Имя пользователя',
            'password' => 'Пароль',
            'email' => 'E-Mail',
            'status' => 'Статус',
            'balance' => 'Баланс',
        ];
    }

    public function update() {
        if ($this->validate()) {
            $user = $this->_user;
            $user->username = $this->username;
            $user->email = $this->email;
            $user->status = $this->status;
            $user->balance = $this->balance;

            if (!empty($this->password)) {
                $user->setPassword($this->password);
            }

            return $user->save();
        } else {
            return false;
        }
    }
}