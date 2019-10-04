<?php

namespace frontend\models\form\advertising;

use common\models\AdvertisingLinks;
use common\models\Links;
use Yii;
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;

class LinkBuyForm extends AdvertisingLinks
{
    public $user_id = 1;
    public $banner_file;
    public $link;

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
    private $_textColorList = [
        'text-light' => '',
        'text-dark' => '',
        'text-danger' => '',
        'text-warning' => '',
        'text-primary' => '',
        'text-info' => '',
        'text-success' => '',
        'text-muted' => '',
    ];

    public function buyLink()
    {
        if (!$this->validate()) {
            return false;
        }

        $user = Yii::$app->user->identity;

        if (($this->days * 20) > $user->balance) {
            Yii::$app->session->setFlash('error', Yii::t('main', 'У вас недостаточно средств для покупки ссылки.'));

            return false;
        }

        if (!isset($this->_backgroundList[$this->background]) || !isset($this->_textColorList[$this->text_color])) {
            Yii::$app->session->setFlash('error', Yii::t('main', 'Ошибка с выбором цвета для фона / текста. Попробуйте еще раз.'));

            return false;
        }

        $linkHref = new Links();
        $linkHref->identifier = md5(time() + rand(0,100000));
        $linkHref->link = $this->link;
        if (!$linkHref->save()) {
            return false;
        }

        $link = new AdvertisingLinks();
        $link->user_id = $user->id;
        $link->title = HtmlPurifier::process($this->title);
        $link->link_id = $linkHref->id;
        $link->background = $this->background;
        $link->text_color = $this->text_color;
        $link->days = $this->days;
        $link->status = AdvertisingLinks::STATUS_ACTIVE;

        $user->balance -= ($this->days * 20);

        if ($user->save()) {
            return $link->save();
        }

        return false;
    }
}