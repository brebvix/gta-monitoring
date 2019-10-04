<?php

namespace console\controllers;

error_reporting(E_ALL);
ini_set('display_errors', '1');
ini_set("memory_limit", "512M");

use common\models\FreelanceServices;
use common\models\FreelanceVacancies;
use common\models\NewsCategories;
use common\models\Servers;
use common\models\User;
use frontend\modules\developer\models\Questions;
use frontend\modules\developer\models\QuestionsCategories;
use Yii;
use yii\base\Controller;
use yii\base\Module;
use common\models\News;

class SitemapController extends Controller
{
    const SITE_LINK = 'https://servers.fun/';
    const MAX_LINKS = 49000;

    private $_path = null;
    private $_file = 'sitemap0.xml';
    private $_handler;
    private $_linksCount = 0;
    private $_currentFile = 0;
    private $_time = 0;

    public function __construct($id, Module $module, array $config = [])
    {
        parent::__construct($id, $module, $config);

        $this->_path = Yii::getAlias('@frontend') . '/web/sitemap/';
        $this->_time = gmdate("Y-m-d", time() + 3600 * (3 + date("I")));
    }

    public function __destruct()
    {
        $handler = fopen(Yii::getAlias('@frontend') . '/web/sitemap.xml', "w");

        fwrite($handler, "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\r\n");
        fwrite($handler, "<sitemapindex xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">\r\n");

        $this->_currentFile++;

        for ($i = 0; $i < $this->_currentFile; $i++) {
            fwrite($handler, "<sitemap>\r\n");
            fwrite($handler, "<loc>https://servers.fun/sitemap/sitemap{$i}.xml</loc>\r\n");
            fwrite($handler, "<lastmod>{$this->_time}</lastmod>\r\n");
            fwrite($handler, "</sitemap>\r\n");
        }

        fwrite($handler, "</sitemapindex>\r\n");

        $this->_sendToSearch(null, true);
    }

    public function actionGenerate()
    {
        $this->_write('', 1.0, false, 'hourly');
        $this->_write('samp', 1.0, false, 'hourly');
        $this->_write('crmp', 1.0, false, 'hourly');
        $this->_write('mta', 1.0, false, 'hourly');
        $this->_write('fivem', 1.0, false, 'hourly');
        $this->_write('rage-multiplayer', 1.0, false, 'hourly');
        $this->_write('developer', 0.9, false, 'daily');
        $this->_write('site/activity', 0.9, false, 'hourly');
        $this->_write('freelance/vacancies', 0.9, false, 'daily');
        $this->_write('freelance/services', 0.9, false, 'daily');
        $this->_write('advertising', 0.7, false, 'monthly');
        $this->_write('news', 1.0, false, 'weekly');
        $this->_write('help/faq', 0.8, false, 'monthly');
        $this->_write('help/api', 0.8, false, 'monthly');
        $this->_write('help/telegram-bot', 0.9, false, 'monthly');
        $this->_write('players', 0.9, false, 'always');

        foreach (NewsCategories::find()->all() AS $category) {
            $this->_write("news/{$category->title_eng}", 0.9, false, 'weekly');
        }

        foreach (News::find()->with('categorie')->all() AS $one) {
            $this->_write(($one->language == 'ru-RU' ? '' : 'en/') . "news/{$one->categorie->title_eng}/{$one->title_eng}/{$one->id}", 0.9, $one->date, 'weekly', false);
        }

        foreach (QuestionsCategories::find()->with('parent')->all() AS $one) {
            if ($one->parent_id != '-1') {
                $this->_write("developer/{$one->parent->title_eng}/{$one->title_eng}", 0.9, false, 'daily');
            } else {
                $this->_write("developer/{$one->title_eng}", 0.9, false, 'daily');
            }
        }

        foreach (Questions::find()->with('category')->with('tags')->all() AS $one) {
            $this->_write("developer/{$one->category->parent->title_eng}/{$one->category->title_eng}/" . urlencode($one->title_eng) . "/{$one->id}", 0.8, $one->date, 'weekly');
        }

        $servers = Servers::find()
            ->select(['id', 'title', 'title_eng', 'game_id'])
            ->orderBy(['id' => SORT_DESC])
            ->all();

        foreach ($servers AS $key => $server) {
            if (!empty($server->title) && !empty($server->title_eng)) {
                $this->_write("{$server->game()}/{$server->title_eng}/{$server->id}", 0.8, false, 'hourly');
            }

            unset($servers[$key]);
        }

        unset($servers);

        $users = User::find()
            ->select(['id'])
            ->all();

        foreach ($users AS $key => $one) {
            $this->_write("user/profile?id={$one->id}", 0.7, false, 'weekly');
            unset($users[$key]);
        }

        unset($users);

        $freelanceVacancies = FreelanceVacancies::find()
            ->all();

        foreach ($freelanceVacancies AS $one) {
            $this->_write("freelance/vacancies/view?id={$one->id}", 0.7, $one->date, 'monthly');
        }

        $freelanceServices = FreelanceServices::find()
            ->all();

        foreach ($freelanceServices AS $one) {
            $this->_write("freelance/services/view?id={$one->id}", 0.7, $one->date, 'monthly');
        }

//        $count = Players::find()->count();
//
//        $iCount = round($count / 49000);
//
//        for ($i = 0; $i < $iCount; $i++) {
//            $players = Players::find()
//                ->offset($i * 49000)
//                ->limit(49000)
//                ->asArray()
//                ->all();
//
//            foreach ($players AS $player) {
//                $this->_write("players/{$player['nickname_eng']}/{$player['id']}", 0.6, $player['date'], 'daily');
//            }
//
//            unset($players);
//        }

        $this->_endHandler();
    }

    private function _initHandler()
    {
        if (empty($this->_handler)) {
            $this->_createFile();
        }

        if ($this->_linksCount >= SitemapController::MAX_LINKS) {
            $this->_endHandler();

            echo 'File ' . $this->_currentFile . ' end' . PHP_EOL;

            $this->_currentFile++;
            $this->_linksCount = 0;

            $this->_file = "sitemap{$this->_currentFile}.xml";

            $this->_createFile();
        }
    }


    private function _write($url, $priority = 0.7, $lastMod = false, $changefreq = 'weekly', $generateEnglish = true)
    {
        $this->_initHandler();

        if (empty($lastMod)) {
            $lastMod = $this->_time;
        } else {
            $date = explode(' ', $lastMod);
            $lastMod = $date[0];
        }

        fwrite($this->_handler, "<url>\r\n");
        fwrite($this->_handler, "<loc>" . SitemapController::SITE_LINK . "{$url}</loc>\r\n");
        fwrite($this->_handler, "<lastmod>{$lastMod}</lastmod>\r\n");
        fwrite($this->_handler, "<changefreq>{$changefreq}</changefreq>\r\n");
        fwrite($this->_handler, "<priority>{$priority}</priority>\r\n");
        fwrite($this->_handler, "</url>\r\n");


        if ($generateEnglish) {
            //English version
            fwrite($this->_handler, "<url>\r\n");
            fwrite($this->_handler, "<loc>" . SitemapController::SITE_LINK . "en/{$url}</loc>\r\n");
            fwrite($this->_handler, "<lastmod>{$lastMod}</lastmod>\r\n");
            fwrite($this->_handler, "<changefreq>{$changefreq}</changefreq>\r\n");
            fwrite($this->_handler, "<priority>{$priority}</priority>\r\n");
            fwrite($this->_handler, "</url>\r\n");

            $this->_linksCount += 2;
        } else {
            $this->_linksCount += 1;
        }
    }

    private function _createFile()
    {
        $this->_handler = fopen($this->_path . $this->_file, "w");;

        fwrite($this->_handler, "<?xml version=\"1.0\" encoding=\"utf-8\"?>\r\n");
        fwrite($this->_handler, "<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">\r\n");
    }

    private function _endHandler()
    {
        fwrite($this->_handler, "</urlset>");
        fclose($this->_handler);
        echo 'closed';
        sleep(3);

        //$this->_sendToSearch($this->_file);
    }

    private function _sendToSearch($sitemapFile, $main = false)
    {
        if ($main) {
            $url = SitemapController::SITE_LINK . 'sitemap.xml';
        } else {
            $url = SitemapController::SITE_LINK . 'sitemap/' . $sitemapFile;
        }

        $searchList = [
            "http://google.com/webmasters/sitemaps/ping?sitemap={$url}",
            "http://bing.com/webmaster/ping.aspx?siteMap={$url}",
            "http://blogs.yandex.ru/pings/?status=success&url={$url}",
        ];

        foreach ($searchList AS $sitemapengine) {
            $parse = parse_url($sitemapengine);
            if (!isset($parse['host']))
                continue;
            $host = $parse['host'];
            $port = isset($parse['port']) ? $parse['port'] : 80;
            $path = isset($parse['path']) ? $parse['path'] : '/';
            $query = isset($parse['query']) ? $parse['query'] : '/';

            if ($ping = @fsockopen($host, $port, $errno, $errstr, 1)) {
                fputs($ping, "GET " . $path . "?" . $query . " HTTP/1.0\r\n" .
                    "User-Agent: Admin\r\n" .
                    "Host: " . $host . "\r\n\r\n");
            }

            @fclose($ping);
        }
    }
}