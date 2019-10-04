<?php

namespace frontend\modules\hosting\models;

use Yii;
use yii\db\Exception;

/**
 * This is the model class for table "hosting_locations".
 *
 * @property int $id
 * @property string $title
 * @property string $ip
 * @property string $username
 * @property string $password
 * @property int $status
 *
 * @property HostingServers[] $hostingServers
 */
class HostingLocations extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hosting_locations';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'ip', 'username', 'password'], 'required'],
            [['status'], 'integer'],
            [['title', 'username', 'password'], 'string', 'max' => 32],
            [['ip'], 'string', 'max' => 15],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('main', 'ID'),
            'title' => Yii::t('main', 'Title'),
            'ip' => Yii::t('main', 'Ip'),
            'username' => Yii::t('main', 'Username'),
            'password' => Yii::t('main', 'Password'),
            'status' => Yii::t('main', 'Status'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHostingServers()
    {
        return $this->hasMany(HostingServers::className(), ['location_id' => 'id']);
    }

    /**
     * @param $username
     * @param $password
     * @return bool
     */
    public function createDatabase($username, $password)
    {
        try {
            $link = mysqli_connect($this->ip, $this->username, $this->password);
            mysqli_query($link, 'CREATE DATABASE db' . $username . ';');
            mysqli_query($link, "CREATE USER '$username'@'%' IDENTIFIED BY '$password';");
            mysqli_query($link, "GRANT ALL PRIVILEGES ON db{$username} . * TO '{$username}'@'%';");
            mysqli_query($link, "FLUSH PRIVILEGES;");
            mysqli_close($link);
            return true;
        } catch (Exception $exception) {
            return false;
        }
    }
}
