<?php

use common\models\UserNotifications;

$notifications = UserNotifications::find()
    ->where(['user_id' => $user->id, 'seen' => UserNotifications::SEEN_NO])
    ->orderBy(['id' => SORT_DESC])
    ->all();

if (count($notifications) == 0) {
    $notifications = UserNotifications::find()
        ->where(['user_id' => $user->id, 'seen' => UserNotifications::SEEN_YES])
        ->orderBy(['id' => SORT_DESC])
        ->limit(5)
        ->all();

    $showNotify = false;
} else {
    $showNotify = true;
}
?>
<a class="nav-link dropdown-toggle text-muted text-muted waves-effect waves-dark" href="" id="notificationLink" data-toggle="dropdown"
   aria-haspopup="true" aria-expanded="false"> <i class="mdi mdi-message"></i>
    <?php if ($showNotify): ?>
        <div class="notify"><span class="heartbit"></span> <span class="point"></span></div>
    <?php endif; ?>
</a>
<div class="dropdown-menu dropdown-menu-right mailbox scale-up">
    <ul>
        <li>
            <div class="drop-title"><?= Yii::t('main', 'Уведомления') ?></div>
        </li>
        <li>
            <div class="message-center">
                <?php
                foreach ($notifications AS $notification) {
                    $data = [
                        'user' => $user,
                        'notification' => $notification,
                    ];
                    echo $this->render('//notifications/type_' . $notification->type, array_merge($data, json_decode($notification->data, true)));
                }
                ?>
            </div>
        </li>
    </ul>
</div>