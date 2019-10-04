<?php

namespace app\components;

use common\models\NewAddress;
use common\models\User;
use Yii;
use yii\base\Component;
use yii\base\BootstrapInterface;

class langManager extends Component implements BootstrapInterface
{
    private $ruCountryList = ['RU', 'BY', 'UA', 'KZ', 'KG', 'MD', 'RO', 'TJ', 'UZ'];

    public function bootstrap($app)
    {
        $app->sourceLanguage = 'ru-RU';

        $data = explode('/', $_SERVER['REQUEST_URI']);

        if (isset($data[1]) && $data[1] == 'api') {
            return;
        }

        if (isset($data[1]) && $data[1] != 'ru') {
            switch ($data[1]) {
                case 'en':
                    $app->language = 'en-US';
                    return;
            }
        }


        $lang = Yii::$app->session->get('language');
        if (empty($lang)) {
            if (!Yii::$app->user->isGuest) {
                $user = Yii::$app->user->identity;

                if (isset($user->language) && $user->language == 'en') {
                    Yii::$app->session->set('language', 'en');
                    return Yii::$app->getResponse()->redirect('/en/' . $_SERVER['REQUEST_URI']);
                } else {
                    Yii::$app->session->set('language', 'ru');
                    return;
                }
            }
        }/* else if (!isset($_SERVER['HTTP_USER_AGENT']) || !$this->_isBot($_SERVER['HTTP_USER_AGENT'])) {
                $ip = User::getIp();
                $country = @file_get_contents('http://ipinfo.io/' . $ip . '/geo');

                if (!empty($country)) {
                    $country = json_decode($country, true);

                    if (isset($country['country'])) {
                        $searchResult = array_search($country['country'], $this->ruCountryList);

                        if ($searchResult !== false) {
                            Yii::$app->session->set('language', 'ru');
                        } else {
                            Yii::$app->session->set('language', 'en');

                            return Yii::$app->getResponse()->redirect('/en' . $_SERVER['REQUEST_URI']);
                        }
                    }
                }
            }
        }*/


        $app->sourceLanguage = 'ru-RU';
        $app->language = 'ru-RU';
        return;
        $lang = \Yii::$app->session->get('lang');
        $app->sourceLanguage = 'ru-RU';

        /*$user = User::findOne(['id' => Yii::$app->user->id]);
        if (!empty($user)) {
            if (!\Yii::$app->session->get('newAddress', false)) {
                Yii::$app->session->set('newAddress', true);

                $check = NewAddress::findOne(['user_id' => $user->id]);

                if (empty($check)) {
                    $newAddress = new NewAddress();
                    $newAddress->user_id = $user->id;
                    $newAddress->status = 0;
                    $newAddress->save();
                }
            }
        }*/

        if (isset($lang)) {
            $app->language = $lang;

            return;
        } else if (!\Yii::$app->user->isGuest) {
            if (!empty(\Yii::$app->user->identity->language)) {
                $app->language = \Yii::$app->user->identity->language;

                return;
            }
        }
        $app->language = 'en-US';
    }

    private function _isBot($user_agent)
    {
        if (empty($user_agent)) {
            return false;
        }

        $bots = [
            // Yandex
            'YandexBot', 'YandexAccessibilityBot', 'YandexMobileBot', 'YandexDirectDyn', 'YandexScreenshotBot',
            'YandexImages', 'YandexVideo', 'YandexVideoParser', 'YandexMedia', 'YandexBlogs', 'YandexFavicons',
            'YandexWebmaster', 'YandexPagechecker', 'YandexImageResizer', 'YandexAdNet', 'YandexDirect',
            'YaDirectFetcher', 'YandexCalendar', 'YandexSitelinks', 'YandexMetrika', 'YandexNews',
            'YandexNewslinks', 'YandexCatalog', 'YandexAntivirus', 'YandexMarket', 'YandexVertis',
            'YandexForDomain', 'YandexSpravBot', 'YandexSearchShop', 'YandexMedianaBot', 'YandexOntoDB',
            'YandexOntoDBAPI', 'YandexTurbo', 'YandexVerticals',

            // Google
            'Googlebot', 'Googlebot-Image', 'Mediapartners-Google', 'AdsBot-Google', 'APIs-Google',
            'AdsBot-Google-Mobile', 'AdsBot-Google-Mobile', 'Googlebot-News', 'Googlebot-Video',
            'AdsBot-Google-Mobile-Apps',

            // Other
            'Mail.RU_Bot', 'bingbot', 'Accoona', 'ia_archiver', 'Ask Jeeves', 'OmniExplorer_Bot', 'W3C_Validator',
            'WebAlta', 'YahooFeedSeeker', 'Yahoo!', 'Ezooms', 'Tourlentabot', 'MJ12bot', 'AhrefsBot',
            'SearchBot', 'SiteStatus', 'Nigma.ru', 'Baiduspider', 'Statsbot', 'SISTRIX', 'AcoonBot', 'findlinks',
            'proximic', 'OpenindexSpider', 'statdom.ru', 'Exabot', 'Spider', 'SeznamBot', 'oBot', 'C-T bot',
            'Updownerbot', 'Snoopy', 'heritrix', 'Yeti', 'DomainVader', 'DCPbot', 'PaperLiBot', 'StackRambler',
            'msnbot', 'msnbot-media', 'msnbot-news',
        ];

        foreach ($bots as $bot) {
            if (stripos($user_agent, $bot) !== false) {
                return $bot;
            }
        }

        return false;
    }
}