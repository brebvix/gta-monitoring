<?php

namespace frontend\modules\hosting\models\form;

ignore_user_abort(true);
set_time_limit(0);

use common\models\Servers;
use common\models\User;
use frontend\models\form\ServerBuyTopForm;
use frontend\modules\hosting\models\HostingGamesVersions;
use frontend\modules\hosting\models\HostingLocations;
use frontend\modules\hosting\models\HostingServers;
use frontend\modules\hosting\models\Ssh;
use Yii;
use frontend\modules\hosting\models\HostingGames;
use yii\base\Model;

class HostingFinalOrderForm extends Model
{
    public $slots;
    public $months;
    public $game_id;
    public $location_id;
    public $version_id;

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['slots', 'months', 'game_id', 'location_id', 'version_id'], 'required'],
            [['slots, months', 'game_id', 'location_id', 'version_id'], 'integer'],
        ];
    }

    /**
     * @param HostingGames $gameModel
     * @param HostingLocations $locationModel
     * @param HostingGamesVersions $versionModel
     * @return bool
     */
    public function validateOrder(HostingGames $gameModel, HostingLocations $locationModel, HostingGamesVersions $versionModel)
    {
        if ($this->slots > $gameModel->max_slots || $this->slots < $gameModel->min_slots) {
            $this->addError('slots', Yii::t('main', 'Неверное количество слотов.'));

            return false;
        }

        if ($this->months > 12 || $this->months < 1) {
            $this->addError('months', Yii::t('main', 'Неверный срок аренды сервера.'));

            return false;
        }

        return $this->_completeOrder($gameModel, $locationModel, $versionModel);
    }

    private function _completeOrder(HostingGames $gameModel, HostingLocations $locationModel, HostingGamesVersions $versionModel)
    {
        $user = User::findOne(['id' => Yii::$app->user->id]);

        $amount = $this->slots * $gameModel->price * $this->months;

        if (!$user->checkBalanceAvailable($amount)) {
            return false;
        }

        $hostingServerModel = new HostingServers();
        $hostingServerModel->user_id = $user->id;
        $hostingServerModel->game_id = $gameModel->id;
        $hostingServerModel->location_id = $locationModel->id;
        $hostingServerModel->version_id = $versionModel->id;
        $hostingServerModel->port = HostingServers::getAvailablePort($gameModel);
        $hostingServerModel->slots = $this->slots;
        $hostingServerModel->end_date = date('Y-m-d H:i:s', time() + (2592000 * $this->months));
        $hostingServerModel->cpu_load = 0;
        $hostingServerModel->ram_load = 0;
        $hostingServerModel->ftp_password = $this->_randomPassword(10);
        $hostingServerModel->database_password = $this->_randomPassword(10);
        $hostingServerModel->status = HostingServers::STATUS_ACTIVE;
        $insertStatus = $hostingServerModel->save();

        if (!$insertStatus) {
            return false;
        }

        $fullLocationModel = HostingLocations::findOne(['id' => $locationModel->id]);
        $databaseCreate = $fullLocationModel->createDatabase('fun' . $hostingServerModel->id, $hostingServerModel->database_password);

        if (!$databaseCreate) {
            HostingServers::deleteAll(['id' => $hostingServerModel->id]);

            return false;
        }

        $ssh = new Ssh();

        if (!$ssh->connect($fullLocationModel)) {
            HostingServers::deleteAll(['id' => $hostingServerModel->id]);

            return false;
        }

        $createServer = $ssh->action('server/add', [
            'id' => 'fun' . $hostingServerModel->id,
            'password' => $hostingServerModel->ftp_password,
            'archiveName' => $versionModel->archive
        ]);

        if ($createServer != 'ok') {
            HostingServers::deleteAll(['id' => $hostingServerModel->id]);

            return false;
        }

        $user->decreaseBalance($amount, 'Hosting #' . $hostingServerModel->id);

        $config = HostingGames::getBaseConfig($hostingServerModel, $locationModel);

        $ssh->action('server/start', [
            'id' => 'fun' . $hostingServerModel->id,
            'game_id' => $hostingServerModel->game_id,
            'config' => json_encode($config)
        ]);

        $serverIdInMontoring = Servers::addServer(
            $locationModel->ip,
            $hostingServerModel->port,
            1,
            false,
            true);

        if ($serverIdInMontoring !== false) {
            $buyVipModel = new ServerBuyTopForm();
            $buyVipModel->server_id = $serverIdInMontoring;
            $buyVipModel->days = 7;
            $buyVipModel->buyLink(true);
        }
        return true;
    }

    private function _randomPassword($length)
    {
        $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $pass = array();
        $alphaLength = strlen($alphabet) - 1;
        for ($i = 0; $i < $length; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass);
    }
}