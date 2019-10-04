<?php
namespace console\controllers;

use common\models\AchievementsList;
use common\models\AdvertisingBanners;
use frontend\modules\developer\models\QuestionsCategories;
use Yii;
use yii\console\Controller;
use common\models\User;
use common\models\FreelanceVacanciesList;

class RbacController extends Controller
{
    public function actionInit()
    {
        $auth = Yii::$app->authManager;

        $user = $auth->createRole('user');
        $admin = $auth->createRole('admin');

        $user->description = 'Пользователь';
        $admin->description = 'Администратор';

        $auth->add($admin);
        $auth->add($user);

        $this->actionAddAdmin();
        $this->actionVacanciesInit();
        $this->actionInitBanners();
        $this->actionInitAchievements();
        $this->actionInitQuestionCategories();
    }

    public function actionInit2()
    {
        $auth = Yii::$app->authManager;

        $support = $auth->createRole('support');
        $support->description = 'Поддержка';

        $auth->add($support);
    }

    public function actionAddAdmin()
    {
        $user = new User();
        $user->id = 1;
        $user->username = 'admin';
        $user->email = 'servers.fun@gmail.com';
        $user->setPassword('qwerty');
        $user->generateAuthKey();
        $user->save();

        $auth = Yii::$app->authManager;
        $authorRole = $auth->getRole('admin');
        $auth->assign($authorRole, $user->getId());
    }

    public function actionVacanciesInit()
    {
        $list = [
            ['title' => 'Pawn скриптер', 'icon' => '<i class="fa fa-code"></i>'],
            ['title' => 'Маппер', 'icon' => '<i class="fa fa-houzz"></i>'],
            ['title' => 'Дизайнер', 'icon' => '<i class="fa fa-pencil"></i>'],
            ['title' => 'WEB-Программист', 'icon' => '<i class="fa fa-terminal"></i>'],
            ['title' => 'Инвестор', 'icon' => '<i class="fa fa-money"></i>'],
            ['title' => 'Спонсор', 'icon' => '<i class="fa fa-credit-card"></i>'],
        ];

        foreach ($list AS $one) {
            $vacancie = new FreelanceVacanciesList();
            $vacancie->title = $one['title'];
            $vacancie->icon = $one['icon'];
            $vacancie->save();
        }
    }

    public function actionInitBanners()
    {
        $banner = new AdvertisingBanners();
        $banner->id = 1;
        $banner->size = '480x68';
        $banner->title = AdvertisingBanners::TITLE_NO;
        $banner->status = AdvertisingBanners::STATUS_FREE;
        $banner->price = 25;
        $banner->save();

        $banner = new AdvertisingBanners();
        $banner->id = 2;
        $banner->size = '250x250';
        $banner->title = AdvertisingBanners::TITLE_YES;
        $banner->status = AdvertisingBanners::STATUS_FREE;
        $banner->price = 10;
        $banner->save();

        $banner = new AdvertisingBanners();
        $banner->id = 3;
        $banner->size = '250x250';
        $banner->title = AdvertisingBanners::TITLE_YES;
        $banner->status = AdvertisingBanners::STATUS_FREE;
        $banner->price = 10;
        $banner->save();

        $banner = new AdvertisingBanners();
        $banner->id = 4;
        $banner->size = '250x250';
        $banner->title = AdvertisingBanners::TITLE_YES;
        $banner->status = AdvertisingBanners::STATUS_FREE;
        $banner->price = 10;
        $banner->save();

        $banner = new AdvertisingBanners();
        $banner->id = 5;
        $banner->size = '250x250';
        $banner->title = AdvertisingBanners::TITLE_YES;
        $banner->status = AdvertisingBanners::STATUS_FREE;
        $banner->price = 10;
        $banner->save();

        $banner = new AdvertisingBanners();
        $banner->id = 6;
        $banner->size = '250x250';
        $banner->title = AdvertisingBanners::TITLE_YES;
        $banner->status = AdvertisingBanners::STATUS_FREE;
        $banner->price = 10;
        $banner->save();
    }

    public function actionInitAchievements()
    {
        $achievement = new AchievementsList();
        $achievement->id = 1;
        $achievement->title = '10 &#128077;';
        $achievement->description = 'Получить 10 положительных голосов';
        $achievement->icon = '<i class="mdi mdi-thumb-up"></i>';
        $achievement->type_positive = AchievementsList::TYPE_POSITIVE_YES;
        $achievement->save();

        $achievement = new AchievementsList();
        $achievement->id = 2;
        $achievement->title = '10 &#128078;';
        $achievement->description = 'Получить 10 отрицательных голосов';
        $achievement->icon = '<i class="mdi mdi-thumb-down"></i>';
        $achievement->type_positive = AchievementsList::TYPE_POSITIVE_NO;
        $achievement->save();

        $achievement = new AchievementsList();
        $achievement->id = 3;
        $achievement->title = '100 &#128405;';
        $achievement->description = 'Получить 100 голосов';
        $achievement->icon = '<i class="mdi mdi-thumbs-up-down"></i>';
        $achievement->type_positive = AchievementsList::TYPE_POSITIVE_YES;
        $achievement->save();

        $achievement = new AchievementsList();
        $achievement->id = 4;
        $achievement->title = '100 &#128108;';
        $achievement->description = 'Достигнуть онлайна 100';
        $achievement->icon = '<i class="mdi mdi-human-child"></i>';
        $achievement->type_positive = AchievementsList::TYPE_POSITIVE_YES;
        $achievement->save();

        $achievement = new AchievementsList();
        $achievement->id = 5;
        $achievement->title = '200 &#128109;';
        $achievement->description = 'Достигнуть онлайна 200';
        $achievement->icon = '<i class="mdi mdi-human"></i>';
        $achievement->type_positive = AchievementsList::TYPE_POSITIVE_YES;
        $achievement->save();

        $achievement = new AchievementsList();
        $achievement->id = 6;
        $achievement->title = '500 &#128107;';
        $achievement->description = 'Достигнуть онлайна 500';
        $achievement->icon = '<i class="mdi mdi-human-pregnant"></i>';
        $achievement->type_positive = AchievementsList::TYPE_POSITIVE_YES;
        $achievement->save();

        $achievement = new AchievementsList();
        $achievement->id = 7;
        $achievement->title = '1000 &#128106;';
        $achievement->description = 'Достигнуть онлайна 1000';
        $achievement->icon = '<i class="mdi mdi-human-handsup"></i>';
        $achievement->type_positive = AchievementsList::TYPE_POSITIVE_YES;
        $achievement->save();

        $achievement = new AchievementsList();
        $achievement->id = 8;
        $achievement->title = '5 &#128172;';
        $achievement->description = 'Получить 5 положительных комментариев';
        $achievement->icon = '<i class="mdi mdi-comment-check-outline"></i>';
        $achievement->type_positive = AchievementsList::TYPE_POSITIVE_YES;
        $achievement->save();

        $achievement = new AchievementsList();
        $achievement->id = 9;
        $achievement->title = '5 &#128020;';
        $achievement->description = 'Получить 5 отрицательных комментариев';
        $achievement->icon = '<i class="mdi mdi-comment-alert-outline"></i>';
        $achievement->type_positive = AchievementsList::TYPE_POSITIVE_NO;
        $achievement->save();

        $achievement = new AchievementsList();
        $achievement->id = 10;
        $achievement->title = '20 &#128173;';
        $achievement->description = 'Получить 20 положительных комментариев';
        $achievement->icon = '<i class="mdi mdi-comment-check"></i>';
        $achievement->type_positive = AchievementsList::TYPE_POSITIVE_YES;
        $achievement->save();

        $achievement = new AchievementsList();
        $achievement->id = 11;
        $achievement->title = '20 &#128019;';
        $achievement->description = 'Получить 20 отрицательных комментариев';
        $achievement->icon = '<i class="mdi mdi-comment-alert"></i>';
        $achievement->type_positive = AchievementsList::TYPE_POSITIVE_NO;
        $achievement->save();
    }

    public function actionInitQuestionCategories()
    {
        $category = new QuestionsCategories();
        $category->id = 1;
        $category->title = 'SAMP';
        $category->title_eng = 'samp';
        $category->color = 'success';
        $category->save();

        $category = new QuestionsCategories();
        $category->title = 'Вопросы по скриптингу';
        $category->title_eng = 'questions-about-scripting';
        $category->parent_id = 1;
        $category->color = 'light-success';
        $category->save();

        $category = new QuestionsCategories();
        $category->title = 'Вопросы по маппингу';
        $category->title_eng = 'questions-about-mapping';
        $category->parent_id = 1;
        $category->color = 'light-primary';
        $category->save();

        $category = new QuestionsCategories();
        $category->title = 'Решение ошибок';
        $category->title_eng = 'solutions-of-errors';
        $category->parent_id = 1;
        $category->color = 'light-info';
        $category->save();

        $category = new QuestionsCategories();
        $category->id = 5;
        $category->title = 'CRMP';
        $category->title_eng = 'crmp';
        $category->parent_id = -1;
        $category->color = 'warning';
        $category->save();

        $category = new QuestionsCategories();
        $category->title = 'Вопросы по скриптингу';
        $category->title_eng = 'questions-about-scripting';
        $category->parent_id = 5;
        $category->color = 'light-success';
        $category->save();

        $category = new QuestionsCategories();
        $category->title = 'Вопросы по маппингу';
        $category->title_eng = 'questions-about-mapping';
        $category->parent_id = 5;
        $category->color = 'light-primary';
        $category->save();

        $category = new QuestionsCategories();
        $category->title = 'Решение ошибок';
        $category->title_eng = 'solutions-of-errors';
        $category->parent_id = 5;
        $category->color = 'light-info';
        $category->save();


        $category = new QuestionsCategories();
        $category->id = 12;
        $category->title = 'MTA';
        $category->title_eng = 'mta';
        $category->parent_id = -1;
        $category->color = 'info';
        $category->save();

        $category = new QuestionsCategories();
        $category->title = 'Вопросы по скриптингу';
        $category->title_eng = 'questions-about-scripting';
        $category->parent_id = 12;
        $category->color = 'light-success';
        $category->save();

        $category = new QuestionsCategories();
        $category->title = 'Вопросы по маппингу';
        $category->title_eng = 'questions-about-mapping';
        $category->parent_id = 12;
        $category->color = 'light-primary';
        $category->save();

        $category = new QuestionsCategories();
        $category->title = 'Решение ошибок';
        $category->title_eng = 'solutions-of-errors';
        $category->parent_id = 12;
        $category->color = 'light-info';
        $category->save();

        $category = new QuestionsCategories();
        $category->id = 18;
        $category->title = 'WEB';
        $category->title_eng = 'web';
        $category->parent_id = -1;
        $category->color = 'danger';
        $category->save();

        $category = new QuestionsCategories();
        $category->title = 'Веб-разработка';
        $category->title_eng = 'web-development';
        $category->parent_id = 18;
        $category->color = 'light-danger';
        $category->save();
    }
}