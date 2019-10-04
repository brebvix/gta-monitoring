<?php

namespace common\models;

use common\models\api\SampApi;
use frontend\modules\developer\models\Questions;
use GameQ\GameQ;
use Yii;
use yii\helpers\HtmlPurifier;

/**
 * This is the model class for table "servers".
 *
 * @property int $id
 * @property int $game_id
 * @property string $ip
 * @property string $port
 * @property string $title
 * @property string $title_eng
 * @property string $mode
 * @property string $language
 * @property string $version
 * @property string $site
 * @property int $players
 * @property int $maxplayers
 * @property int $average_online
 * @property int $maximum_online
 * @property int $offline_count
 * @property double $rating
 * @property int $rating_up
 * @property int $rating_down
 * @property string $created_at
 * @property int $status
 * @property string $background
 * @property int $vip
 * @property string $description
 * @property int $views
 *
 * @property Games $game
 * @property ServersOwner[] $serversOwners
 */
class Servers extends \yii\db\ActiveRecord
{
    const VIP_NO = 0;
    const VIP_YES = 1;

    const TOP_NO = 0;
    const TOP_YES = 1;

    const STATUS_ACTIVE = 1;
    const STATUS_OFFLINE = 0;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'servers';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['game_id', 'ip', 'port'], 'required'],
            [['game_id', 'players', 'maxplayers', 'average_online', 'maximum_online', 'offline_count', 'status', 'views'], 'integer'],
            [['rating', 'rating_up', 'rating_down'], 'number'],
            [['created_at', 'vip', 'background'], 'safe'],
            [['ip'], 'string', 'max' => 15],
            [['port'], 'string', 'max' => 5],
            [['title', 'title_eng'], 'string', 'max' => 148],
            [['mode', 'language', 'site'], 'string', 'max' => 32],
            [['version'], 'string', 'max' => 12],
            [['game_id'], 'exist', 'skipOnError' => true, 'targetClass' => Games::className(), 'targetAttribute' => ['game_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'game_id' => Yii::t('main', 'Игра'),
            'ip' => Yii::t('main', 'IP'),
            'port' => Yii::t('main', 'Порт'),
            'title' => Yii::t('main', 'Заголовок'),
            'title_eng' => Yii::t('main', 'Заголовок, Анг.'),
            'description' => Yii::t('main', 'Описание'),
            'mode' => Yii::t('main', 'Мод'),
            'language' => Yii::t('main', 'Язык'),
            'version' => Yii::t('main', 'Версия'),
            'site' => Yii::t('main', 'Сайт'),
            'players' => Yii::t('main', 'Игроки'),
            'maxplayers' => Yii::t('main', 'Максимальное количество игроков'),
            'average_online' => Yii::t('main', 'Средний онлайн'),
            'maximum_online' => Yii::t('main', 'Максимальный онлайн'),
            'offline_count' => Yii::t('main', 'Количество проверок на офлайн'),
            'rating' => Yii::t('main', 'Рейтинг'),
            'rating_up' => Yii::t('main', 'Рейтинг вверх'),
            'rating_down' => Yii::t('main', 'Рейтинг вниз'),
            'created_at' => Yii::t('main', 'Дата'),
            'status' => Yii::t('main', 'Статус'),
            'background' => Yii::t('main', 'Фон'),
            'text_color' => Yii::t('main', 'Цвет текста'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGame()
    {
        return $this->hasOne(Games::className(), ['id' => 'game_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getServersOwners()
    {
        return $this->hasMany(ServersOwner::className(), ['server_id' => 'id']);
    }

    public function getStatistic()
    {
        return $this->hasMany(ServersStatistic::className(), ['server_id' => 'id']);
    }

    public function getStatisticMonth()
    {
        return $this->hasMany(ServersStatisticMonth::className(), ['server_id' => 'id']);
    }

    public function getLastStatistic()
    {
        return $this->getStatisticMonth()
            ->orderBy(['id' => SORT_DESC]);
    }

    public function getRating()
    {
        return $this->hasMany(ServersRating::className(), ['server_id' => 'id']);
    }

    public function getCommentsToServer()
    {
        return $this->hasMany(Comments::className(), ['server_id' => 'id']);
    }

    public function fastCalculateRating()
    {
        $this->rating = ServersRating::calculateByWilson($this->rating_up, $this->rating_down) * 10;
        return $this->save();
    }

    public static function addServer($ip, $port, $game_id, $checkAvailable = true, $returnId = false)
    {
        if ($game_id == 4) {
            return self::addMtaServer($ip, $port);
        }

        if ($checkAvailable) {
            $GameQ = new GameQ();
            $GameQ->setOption('timeout', 2);

            $GameQ->addServer(['type' => 'samp', 'host' => $ip . ':' . $port]);
            $apiResult = $GameQ->process();
            $apiResult = $apiResult[$ip . ':' . $port];

            if (!$apiResult['gq_online']) {
                return false;
            }
        } else {
            $apiResult = ['gq_online' => 0, 'servername' => 'Servers.Fun Hosting'];
        }

        $server = new Servers();
        $server->ip = $ip;
        $server->port = (string)$port;

        if (isset($apiResult['servername'])) {
            try {
                $server->title = HtmlPurifier::process(trim(iconv('windows-1251', 'utf-8', $apiResult['servername'])));
            } catch (\Exception $exception) {
                $server->title = HtmlPurifier::process(trim($apiResult['servername']));
            }

            $server->title_eng = Questions::translit($server->title);
        }

        if (empty($server->title)) {
            return false;
        }

        if (isset($apiResult['gq_numplayers'])) {
            $server->players = $apiResult['gq_numplayers'];
        }

        if (isset($apiResult['gq_maxplayers'])) {
            $server->maxplayers = $apiResult['gq_maxplayers'];
        }

        if (isset($apiResult['gametype'])) {
            $server->mode = HtmlPurifier::process($apiResult['gametype']);
        }

        if (isset($apiResult['version'])) {
            if ($apiResult['version'] == 'crce' || $apiResult['version'] == 'cr037') {
                $server->game_id = 2;
            } else {
                $server->game_id = 1;
            }

            $server->version = $apiResult['version'];
        } else {
            $server->game_id = 1;
        }

        if (isset($apiResult['weburl'])) {
            $server->site = $apiResult['weburl'];
        }

        if (isset($apiResult['language']) && !empty($apiResult['language'])) {
            $server->language = HtmlPurifier::process(iconv('windows-1251', 'utf-8', $apiResult['language']));
        }


        $server->rating_up = 1;
        $server->rating_down = 1;
        $server->status = Servers::STATUS_ACTIVE;


        $saveStatus = $server->save();

        if ($returnId && $saveStatus) {
            return $server->id;
        }

        return $server->save();
    }

    public function addMtaServer($ip, $port)
    {
        $GameQ = new GameQ();
        $GameQ->setOption('timeout', 2);

        $GameQ->addServer(['type' => 'mta', 'host' => $ip . ':' . $port]);
        $serverInfo = $GameQ->process();

        if (!empty($serverInfo)) {
            $serverInfo = $serverInfo[$ip . ':' . $port];

            if ($serverInfo['gq_online']) {
                $server = new Servers();
                $server->ip = $ip;
                $server->port = (string)$port;
                $server->game_id = 4;

                $server->title = HtmlPurifier::process($serverInfo['gq_hostname']);
                $server->title_eng = Questions::translit($server->title);

                if (isset($serverInfo['version'])) {
                    $server->version = $serverInfo['version'];
                }
                $server->players = (int)$serverInfo['gq_numplayers'];
                $server->maxplayers = (int)$serverInfo['gq_maxplayers'];
                $server->mode = HtmlPurifier::process($serverInfo['gq_gametype']);

                $server->rating_up = 1;
                $server->rating_down = 1;
                $server->status = Servers::STATUS_ACTIVE;

                return $server->save();
            } else {
                return false;
            }
        }
    }

    public function getPlayers()
    {
        return $this->hasMany(PlayersRelations::className(), ['server_id' => 'id']);
    }

    public function getAchievements()
    {
        return $this->hasMany(Achievements::className(), ['main_id' => 'id'])
            ->with('achievement')
            ->where(['main_type' => Achievements::MAIN_TYPE_SERVER]);
    }

    public function hasAchievement($achievement_id)
    {
        return Achievements::find()
                ->where([
                    'main_id' => $this->id,
                    'main_type' => Achievements::MAIN_TYPE_SERVER,
                    'achievement_id' => $achievement_id
                ])
                ->count() > 0;
    }

    public function connectHref()
    {
        switch ($this->game_id) {
            case 1:
                return 'samp://' . $this->ip . ':' . $this->port;
            case 2:
                return 'crmp://' . $this->ip . ':' . $this->port;
            case 3:
                return 'fivem://connect/' . $this->ip . ':' . $this->port;
            case 4:
                return 'mtasa://' . $this->ip . ':' . $this->port;
            case 7:
                return 'rage://v/connect?ip=' . $this->ip . ':' . $this->port;
        }
    }

    public function game()
    {
        switch ($this->game_id) {
            case 1:
                return 'samp';
            case 2:
                return 'crmp';
            case 3:
                return 'fivem';
            case 4:
                return 'mta';
            case 7:
                return 'rage-multiplayer';
        }
    }

    public static function getByIdentifier($identifier)
    {
        if (is_numeric($identifier)) {
            $server = Servers::findOne(['id' => (int)$identifier]);
        } else {
            $address = explode(':', $identifier);

            if (!is_array($address) || count($address) != 2) {
                return false;
            }

            $server = Servers::findOne(['ip' => $address[0], 'port' => (int)$address[1]]);
        }

        return $server;
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes); // TODO: Change the autogenerated stub

        if (empty($this->title)) {
            $this->status = 0;
        }
    }
}
