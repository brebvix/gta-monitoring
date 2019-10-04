<?php
namespace frontend\modules\developer;

use Yii;

class Module extends \yii\base\Module
{
    public function init()
    {
        Yii::$app->params['no_layout_card'] = true;
        Yii::$app->params['main_title'] =  Yii::t('questions', 'Разработка серверов') . ' Servers.Fun';

        parent::init();
    }
}