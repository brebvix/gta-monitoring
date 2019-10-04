<?php

namespace frontend\modules\developer\models;

use common\models\Activity;
use Yii;
use common\models\User;
use common\models\MarkdownParse;
use yii\helpers\HtmlPurifier;

/**
 * This is the model class for table "questions".
 *
 * @property int $id
 * @property int $user_id Пользователь
 * @property int $category_id Категория
 * @property string $title Заголовок
 * @property string $title_eng Заголовок, англ
 * @property string $message Текст вопроса
 * @property string $short_message Краткий текст
 * @property string $date Дата
 * @property int $rating Рейтинг
 * @property int $views_count Просмотры
 * @property int $hasAnswer Получен ли ответ
 * @property int $answers_count Ответы
 *
 * @property QuestionsCategories $category
 * @property User $user
 * @property QuestionsAnswers[] $questionsAnswers
 * @property QuestionsComments[] $questionsComments
 * @property QuestionsRating[] $questionsRatings
 * @property QuestionsTagsRelations[] $questionsTagsRelations
 */
class Questions extends \yii\db\ActiveRecord
{
    public $tagsList;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'questions';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'category_id', 'title', 'title_eng', 'message'], 'required'],
            [['user_id', 'category_id', 'rating', 'views_count', 'hasAnswer', 'answers_count'], 'integer'],
            [['message', 'short_message'], 'string', 'min' => 64, 'max' => 4096],
            [['date', 'tagsList', 'short_message'], 'safe'],
            [['title'], 'string', 'min' => 16, 'max' => 64],
            [['title'], 'trim'],
            [['title_eng'], 'string', 'max' => 160],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => QuestionsCategories::className(), 'targetAttribute' => ['category_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('questions', 'ID'),
            'user_id' => Yii::t('questions', 'Пользователь'),
            'category_id' => Yii::t('questions', 'Категория'),
            'title' => Yii::t('questions', 'Заголовок'),
            'title_eng' => Yii::t('questions', 'Заголовок, англ'),
            'message' => Yii::t('questions', 'Текст вопроса'),
            'date' => Yii::t('questions', 'Дата'),
            'rating' => Yii::t('questions', 'Рейтинг'),
            'views_count' => Yii::t('questions', 'Просмотры'),
            'hasAnswer' => Yii::t('questions', 'Получен ли ответ'),
            'answers_count' => Yii::t('questions', 'Ответы'),
            'tags' => Yii::t('questions', 'Теги'),
            'tagsList' => Yii::t('questions', 'Список тегов'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(QuestionsCategories::className(), ['id' => 'category_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuestionsAnswers()
    {
        return $this->hasMany(QuestionsAnswers::className(), ['question_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuestionsComments()
    {
        return $this->hasMany(QuestionsComments::className(), ['question_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuestionsRatings()
    {
        return $this->hasMany(QuestionsRating::className(), ['question_id' => 'id']);
    }

    public function getComments()
    {
        return $this->hasMany(QuestionsComments::className(), ['question_id' => 'id'])
            ->where(['answer_id' => -1]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTags()
    {
        return $this->hasMany(QuestionsTagsRelations::className(), ['question_id' => 'id'])
            ->with('tag');
    }

    public static function translit($str) {
        $str = preg_replace ("/[^a-zA-Zа-яА-Я .-]/u","",trim($str));
        $str = trim($str);

        $alphavit = array(
            /* -- */
            'а' => 'a', 'б' => 'b', 'в' => 'v', 'г' => 'g', 'д' => 'd', 'е' => 'e',
            'ё' => 'yo', 'ж' => 'j', 'з' => 'z', 'и' => 'i', 'й' => 'i', 'к' => 'k', 'л' => 'l', 'м' => 'm',
            'н' => 'n', 'о' => 'o', 'п' => 'p', 'р' => 'r', 'с' => 's', 'т' => 't',
            'у' => 'y', 'ф' => 'f', 'х' => 'h', 'ц' => 'c', 'ч' => 'ch', 'ш' => 'sh', 'щ' => 'sh',
            'ы' => 'i', 'э' => 'e', 'ю' => 'u', 'я' => 'ya', '   ' => '-', '  ' => '-', ' ' => '-', ',' => '', '"' => '', "'" => '',
            '>' => '', '<' => '', '?' => '', '@' => '', '--' => '-', '__' => '', '-_' => '', '_-' => '', '/' => '', '.' => '_', '*' => '',
            /* -- */
            'А' => 'A', 'Б' => 'B', 'В' => 'V', 'Г' => 'G', 'Д' => 'D', 'Е' => 'E', 'Ё' => 'Yo',
            'Ж' => 'J', 'З' => 'Z', 'И' => 'I', 'Й' => 'I', 'К' => 'K', 'Л' => 'L', 'М' => 'M',
            'Н' => 'N', 'О' => 'O', 'П' => 'P', 'Р' => 'R', 'С' => 'S', 'Т' => 'T', 'У' => 'Y',
            'Ф' => 'F', 'Х' => 'H', 'Ц' => 'C', 'Ч' => 'Ch', 'Ш' => 'Sh', 'Щ' => 'Sh',
            'Ы' => 'I', 'Э' => 'E', 'Ю' => 'U', 'Я' => 'Ya',
            'ь' => '', 'Ь' => '', 'ъ' => '', 'Ъ' => ''
        );
        $str = strtolower(strtr($str,  $alphavit));

        return strtr($str, $alphavit);
    }


    public function add()
    {
        $this->user_id = Yii::$app->user->id;
        $this->title = HtmlPurifier::process($this->title);
        $this->title_eng = Questions::translit($this->title);
        $this->message = Questions::markdownParse($this->message);
        $this->short_message = $this->_generateShort($this->message);

        if (!$this->validate()) {
            return false;
        }

        if (!$this->save()) {
            return false;
        }

        if (!empty($this->tagsList)) {
            foreach ($this->tagsList AS $tag) {
                $tagModel = QuestionsTags::findOne(['title' => $tag]);
                if (empty($tagModel)) {
                    $tagModel = new QuestionsTags();
                    $tagModel->title = HtmlPurifier::process($tag);
                    $tagModel->title_eng = Questions::translit($tagModel->title);
                    $tagModel->count = 0;
                }

                $tagModel->count++;
                $tagModel->save();

                $tagRelation = new QuestionsTagsRelations();
                $tagRelation->tag_id = $tagModel->id;
                $tagRelation->question_id = $this->id;
                $tagRelation->save();
            }
        }
        $category = $this->category;
        $category->count++;
        $category->save();

        $parent = $this->category->parent;

        if (!empty($parent)) {
            $parent->count++;
            $parent->save();
        }

        return true;
    }

    private function _generateShort($string)
    {
        if (strpos($string, '<pre>') > 0 && strpos($string, '<pre>') < 200) {
            $string = mb_substr($string, 0, strpos($string, '<pre>'));
            $string = rtrim($string, "!,.-");
            $string = mb_substr($string, 0, strrpos($string, ' '));

            $string = $string . '...';

            return HtmlPurifier::process($string);
        }

        $string = mb_substr($string, 0, 200);
        $string = rtrim($string, "!,.-");
        $string = mb_substr($string, 0, strrpos($string, ' '));
        $string  = $string . "...";

        return HtmlPurifier::process($string);
    }

    public static function markdownParse($text)
    {
        $parser = new MarkdownParse();
        $parser->setMarkupEscaped(true);
        return $parser->text(str_replace('javascript','javascript\:', $text));
    }

    public static function lastCount()
    {
        $lastDay = strtotime(date('Y-m-d H:m:s')) - 86400;

        return self::find()
            ->where(['>=', 'date', date('Y-m-d H:m:s', $lastDay)])
            ->count();
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes); // TODO: Change the autogenerated stub

        if (!$insert) {
            return true;
        }

        $activity = new Activity();
        $activity->main_id = $this->user_id;
        $activity->main_type  = Activity::MAIN_TYPE_USER;
        $activity->type = Activity::TYPE_NEW_QUESTION;
        $activity->data = json_encode([
            'username' => $this->user->username,
            'question_id' => $this->id,
            'parent_category_eng' => $this->category->parent->title_eng,
            'category_eng' => $this->category->title_eng,
            'parent_category_title' => $this->category->parent->title,
            'parent_category_color' => $this->category->parent->color,
            'category_title' => $this->category->title,
            'category_color' => $this->category->color,
            'title_eng' => $this->title_eng,
            'title' => $this->title,
        ]);
        $activity->save();
    }
}
