<?php

namespace frontend\models\form;

use Yii;
use common\models\Servers;

class AddServerForm extends Servers
{
    public $game_id = 1;
    public $reCaptcha;


    public function rules()
    {
        return [
            [['ip', 'port', 'game_id'], 'required'],
            [['ip', 'port'], 'trim'],
            ['ip', 'ip'],
            ['port', 'integer', 'min' => 1024, 'max' => 65535],
            [['reCaptcha'], \himiklab\yii2\recaptcha\ReCaptchaValidator::className()],
        ];
    }

    public function saveServer()
    {
        if (!$this->validate()) {
            return false;
        }

        $check = Servers::find()
            ->where([
                'ip' => $this->ip,
                'port' => $this->port
            ])
            ->one();

        if (!empty($check)) {
            Yii::$app->session->setFlash('warning', Yii::t('main', 'Этот сервер уже добавлен в мониторинг.'));
            return $check;
        }

        $result = Servers::addServer($this->ip, $this->port, $this->game_id);

        if (!$result) {
            Yii::$app->session->setFlash('error', Yii::t('main', 'Ошибка при добавлении сервера, попробуйте позже.'));
        }

        return $result;
    }
}