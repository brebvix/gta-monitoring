<?php
namespace frontend\models\form;

use Yii;
use common\models\Servers;
use common\models\ServersVip;

class ServerBuyBackgroundForm extends Servers
{
    public $server_id;
    public $background;
    public $days;
    private $_backgroundList = [
        'bg-light' => '',
        'bg-dark' => '',
        'bg-danger' => '',
        'bg-warning' => '',
        'bg-primary' => '',
        'bg-info' => '',
        'bg-success' => '',
        'bg-secondary' => '',
        'bg-light-danger' => '',
        'bg-light-warning' => '',
        'bg-light-primary' => '',
        'bg-light-info' => '',
        'bg-light-success' => '',
    ];

    public function rules()
    {
        return [
            [['background', 'days'], 'required'],
            ['background', 'string'],
            ['days', 'integer', 'min' => 1, 'max' => 30],
        ];
    }

    public function buyBackground()
    {
        if (!$this->validate()) {
            return false;
        }

        $user = Yii::$app->user->identity;

        if ($user->balance < ($this->days * 5)) {
            Yii::$app->session->setFlash('error', Yii::t('main', 'У вас недостаточно средств для покупки данной услуги.'));

            return false;
        }

        $server = Servers::findOne(['id' => $this->server_id]);

        if (empty($server) || !empty($server->background)) {
            Yii::$app->session->setFlash('error', Yii::t('main', 'Для данного сервера уже куплена услуга "Выделение сервера".'));

            return false;
        }

        if (!isset($this->_backgroundList[$this->background])) {
            Yii::$app->session->setFlash('error', Yii::t('main', 'Ошибка с выбором цвета для фона. Попробуйте еще раз.'));

            return false;
        }

        $user->balance -= ($this->days * 5);
        $user->save();

        $server->background = $this->background;
        $server->save();

        $vip = new ServersVip();
        $vip->user_id = $user->id;
        $vip->server_id = $server->id;
        $vip->days = $this->days;
        $vip->type = ServersVip::TYPE_BACKGROUND;
        $vip->status = ServersVip::STATUS_ACTIVE;
        return $vip->save();
    }
}