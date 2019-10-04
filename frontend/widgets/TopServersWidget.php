<?php

namespace frontend\widgets;

use common\models\Servers;

class TopServersWidget extends \yii\bootstrap\Widget
{
    public function run()
    {
        $topServers = Servers::find()
            ->select(['id', 'game_id', 'ip', 'port', 'title', 'title_eng', 'rating'])
            ->with('game')
            ->where(['top' => Servers::TOP_YES])
            ->orderBy(['game_id' => SORT_ASC])
            ->all();

        return $this->render('top/main', ['servers' => $topServers]);
    }
}