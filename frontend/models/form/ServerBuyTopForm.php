<?php

namespace frontend\models\form;

use common\models\User;
use Yii;
use common\models\Servers;
use common\models\ServersVip;

class ServerBuyTopForm extends ServersVip
{
    public $server_id;
    public $days;

    public function rules()
    {
        return [
            ['days', 'integer', 'min' => 1, 'max' => 30],
        ];
    }

    public function buyLink($free = false)
    {
        $user = User::findOne(['id' => Yii::$app->user->id]);
        $server = Servers::findOne(['id' => $this->server_id]);

        if ($free === false) {
            if (!$this->validate()) {
                return false;
            }
            if ($user->balance < ($this->days * 5)) {
                Yii::$app->session->setFlash('error', Yii::t('main', 'У вас недостаточно средств для покупки данной услуги.'));

                return false;
            }

            $server = Servers::findOne(['id' => $this->server_id]);

            if (empty($server) || $server->vip == Servers::VIP_YES) {
                Yii::$app->session->setFlash('error', Yii::t('main', 'Для данного сервера уже куплена услуга "Поднятие в ТОП".'));

                return false;
            }

            $user->balance -= ($this->days * 5);
            $user->save();
        }

        $server->vip = Servers::VIP_YES;
        $server->save();

        $vip = new ServersVip();
        $vip->user_id = $user->id;
        $vip->server_id = $server->id;
        $vip->days = $this->days;
        $vip->type = ServersVip::TYPE_TOP;
        $vip->status = ServersVip::STATUS_ACTIVE;
        return $vip->save();
    }
}