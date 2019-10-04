<?php

namespace frontend\modules\hosting\models;

use Exception;

class Ssh
{
    private $_instance;

    public function connect(HostingLocations $location)
    {
        try {
            $this->_instance = ssh2_connect($location->ip);
            return ssh2_auth_password($this->_instance, $location->username, $location->password);
        } catch (Exception $exception) {
            return false;
        }
    }

    public function action($action, $params)
    {
        if (!is_resource($this->_instance)) {
            return false;
        }

        $buildParams = '';

        foreach ($params AS $value) {
            $buildParams .= "'$value'" . ' ';
        }

        $stream = ssh2_exec($this->_instance, "cd /home/hosting/server && php yii $action $buildParams");

        stream_set_blocking($stream, true);
        $stream_out = ssh2_fetch_stream($stream, SSH2_STREAM_STDIO);
        return stream_get_contents($stream_out);
    }

    public function close()
    {
        unset($this->_instance);
    }
}