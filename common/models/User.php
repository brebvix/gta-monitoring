<?php

namespace common\models;

use frontend\modules\telegram\models\TelegramApi;
use frontend\modules\telegram\models\TelegramUser;
use Telegram\Bot\Laravel\Facades\Telegram;
use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property string $auth_key
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $password write-only password
 * @property float $rating
 * @property float $rating_up
 * @property float $rating_down
 * @property float $balance
 * @property string $language
 * @property string $avatar_hash
 * @property int $telegram_status
 * @property int $telegram_user_id
 */
class User extends ActiveRecord implements IdentityInterface
{
    const STATUS_NO_ACTIVE = 0;
    const STATUS_BANNED = 5;
    const STATUS_ACTIVE = 10;

    const TELEGRAM_STATUS_DISABLED = 0;
    const TELEGRAM_STATUS_WAIT = 1;
    const TELEGRAM_STATUS_ENABLED = 2;

    const AVATAR_EXIST = 1;
    const AVATAR_NO_EXIST = 0;


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['username', 'email'], 'required'],
            ['email', 'email'],
            [['telegram_status', 'telegram_user_id'], 'integer'],
            ['avatar_hash', 'safe'],
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_BANNED, self::STATUS_NO_ACTIVE]],
        ];
    }

    public function attributeLabels()
    {
        return [
            'username' => Yii::t('main', 'Никнейм'),
            'email' => Yii::t('main', 'E-Mail'),
            'password' => Yii::t('main', 'Пароль'),
            'rePassword' => Yii::t('main', 'Повторите пароль'),
        ];
    }

    public static function getStatusList()
    {
        return [
            self::STATUS_NO_ACTIVE => Yii::t('main', 'Не активирован'),
            self::STATUS_BANNED => Yii::t('main', 'Забанен'),
            self::STATUS_ACTIVE => Yii::t('main', 'Активирован'),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return bool
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int)substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }

    public function isAdmin()
    {
        $role = \Yii::$app->authManager->getRolesByUser($this->id);
        return isset($role['admin']) ? true : false;
    }

    public function getServers()
    {
        return $this->hasMany(ServersOwner::className(), ['id' => 'user_id']);
    }

    public function getAvatarLink()
    {
        if (!empty($this->avatar_hash)) {
            $avatar = 'avatars/' . $this->avatar_hash . '.png';
        } else {
            $avatar = 'default.png';
        }

        if (isset(Yii::$app->urlManager->queryParam)) {
            return Yii::$app->urlManager->createAbsoluteUrl(['/images/' . $avatar, Yii::$app->urlManager->queryParam => null]);
        } else {
            return Yii::$app->urlManager->createAbsoluteUrl(['/images/' . $avatar]);
        }
    }

    public function getCommentsToUser()
    {
        return $this->hasMany(Comments::className(), ['user_id' => 'id']);
    }

    public function getCommentsByUser()
    {
        return $this->hasMany(Comments::className(), ['author_id' => 'id']);
    }

    public function updateRating()
    {
        $this->rating = ServersRating::calculateByWilson($this->rating_up, $this->rating_down);
        return $this->save();
    }

    public function getNotifications()
    {
        return $this->hasMany(UserNotifications::className(), ['user_id' => 'id']);
    }

    public function getFreelanceServices()
    {
        return $this->hasMany(FreelanceServices::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFreelanceVacancies()
    {
        return $this->hasMany(FreelanceVacancies::className(), ['user_id' => 'id']);
    }

    public function getRatingColor()
    {
        if ($this->rating < 2) {
            return 'danger';
        } else if ($this->rating < 4) {
            return 'warning';
        } else if ($this->rating < 6) {
            return 'info';
        } else if ($this->rating < 8) {
            return 'primary';
        } else {
            return 'success';
        }
    }

    public function getPayments()
    {
        return $this->hasMany(UserPayments::className(), ['user_id' => 'id'])->orderBy(['id' => SORT_DESC]);
    }

    public static function getIp()
    {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }

        if (strlen($ip) > 15) {
            $ip = explode(',', $ip);
            $ip = $ip[0];
        }

        return $ip;
    }

    public function haveTelegram()
    {
        return $this->telegram_status == User::TELEGRAM_STATUS_ENABLED;
    }

    public function sendTelegramMessage($message)
    {
        if (!$this->haveTelegram()) {
            return true;
        }

        $telegramUser = TelegramUser::findOne(['telegram_user_id' => $this->telegram_user_id]);
        $telegram = TelegramApi::getMainObject();

        if (strlen($message) > 3900) {
            return TelegramApi::sendBigMessage($telegram, $telegramUser->chat_id, $message);
        }

        return $telegram->sendMessage(TelegramApi::formatMessage($telegramUser->chat_id, $message));
    }

    public function increaseBalance($amount, $paymentSystem, $comment, $status = UserPayments::STATUS_SUCCESS)
    {
        if ($status == UserPayments::STATUS_SUCCESS) {
            $this->balance = number_format((float)$this->balance + (float)$amount, 2, '.', '');
            $this->save();
        }

        $course = System::findOne(['key' => 'course_rub'])->value;

        $paymentLogModel = new UserPayments();
        $paymentLogModel->user_id = $this->id;
        $paymentLogModel->amount_rub = number_format((float)$amount, 2, '.', '');
        $paymentLogModel->amount_usd = number_format((float)$amount / (float)$course, 2, '.', '');
        $paymentLogModel->payment_system = $paymentSystem;
        $paymentLogModel->type = UserPayments::TYPE_INCREASE;
        $paymentLogModel->comment = $comment;
        $paymentLogModel->status = $status;
        $insertStatus = $paymentLogModel->save();

        if ($insertStatus) {
            return $paymentLogModel;
        }

        return false;
    }

    public function decreaseBalance($amount, $comment)
    {
        if ($amount > $this->balance) {
            return false;
        }

        $this->balance = number_format($this->balance - $amount, 2, '.', '');
        $this->save();

        $course = System::findOne(['key' => 'course_rub'])->value;

        $paymentLogModel = new UserPayments();
        $paymentLogModel->user_id = $this->id;
        $paymentLogModel->amount_rub = number_format((float)$amount, 2, '.', '');
        $paymentLogModel->amount_usd = number_format((float)$amount / (float)$course, 2, '.', '');
        $paymentLogModel->payment_system = 'Servers.Fun';
        $paymentLogModel->type = UserPayments::TYPE_DECREASE;
        $paymentLogModel->comment = $comment;
        $paymentLogModel->status = UserPayments::STATUS_SUCCESS;
        return $paymentLogModel->save();
    }

    public function checkBalanceAvailable($amount)
    {
        if ($amount > $this->balance) {
            return false;
        }

        return true;
    }
}