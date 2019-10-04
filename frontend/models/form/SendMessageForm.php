<?php
namespace frontend\models\form;

use common\models\Messages;
use Yii;
use common\models\Dialogs;
use yii\base\Model;
use common\models\UserNotifications;

class SendMessageForm extends Model
{
    public $user_id;
    public $message;
    public $dialog_id = -1;

    public function rules()
    {
        return [
            [['message'], 'string', 'max' => 1024, 'min' => 5],
            [['user_id'], 'safe'],
        ];
    }

    public function send()
    {
        if (!$this->validate()) {
            return false;
        }

        $dialog = Dialogs::getDialogByUser(Yii::$app->user->id, $this->user_id);

        if (!$dialog) {
            return false;
        }

        $this->dialog_id = $dialog->id;

        $message = new Messages();
        $message->user_id = Yii::$app->user->id;
        $message->dialog_id = $dialog->id;
        $message->message = $this->message;

        if ($message->save()) {
            $needUser = $dialog->user_one == $message->user_id ? $dialog->user_two : $dialog->user_one;

            $notification = new UserNotifications();
            $notification->user_id = $needUser;
            $notification->type = UserNotifications::TYPE_NEW_MESSAGE;
            $notification->data = json_encode([
                'username' => Yii::$app->user->identity->username,
                'dialog_id' => $dialog->id
            ]);
            $notification->save();
        }

        return true;
    }

}