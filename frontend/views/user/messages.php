<?php
use yii\bootstrap\ActiveForm;
use common\models\Messages;
use yii\helpers\Url;
use yii\widgets\Pjax;
use yii\helpers\Html;
use common\models\User;

$this->registerJsFile('/js/chat.js', ['depends' => 'yii\web\JqueryAsset']);
?>
<?php Pjax::begin(['enablePushState' => false, 'timeout' => 5000]); ?>
    <div class="card m-b-0">
        <div class="chat-main-box">
            <div class="chat-left-aside">
                <div class="open-panel"><i class="ti-angle-right"></i></div>
                <div class="chat-left-inner">
                    <ul class="chatonline style-none ">
                        <?php foreach ($dialogList as $dialog):
                            $dialogUser = User::findOne(['id' => $dialog->user_one == Yii::$app->user->id ? $dialog->user_two : $dialog->user_one]);
                            $lastMessage = Messages::find()
                                ->where(['dialog_id' => $dialog->id])
                                ->orderBy(['id' => SORT_DESC])
                                ->limit(1)
                                ->one();
                            ?>
                            <li>
                                <a href="<?= Url::to(['/message/view-dialog', 'id' => $dialog->id]) ?>"
                                   class="<?= $lastMessage->seen == Messages::SEEN_NO ? 'active' : '' ?>">
                                    <img src="<?= $dialogUser->getAvatarLink() ?>" alt="user-img"
                                         class="img-circle">
                                    <span>
                                    <?= $dialogUser->username; ?>
                                        <small class="pull-right"><?= Yii::$app->formatter->asRelativeTime($lastMessage->date) ?></small>
                                    <small class="text-muted"><?= $lastMessage->user->username ?>
                                        : <i><?= $lastMessage->message ?></i></small>
                                </span>
                                </a>
                            </li>
                        <?php endforeach; ?>
                        <li class="p-20"></li>
                    </ul>
                </div>
            </div>

            <?php if (!empty($dialogData)): ?>
                <div class="chat-right-aside">
                    <div class="chat-main-header">
                        <div class="p-20 b-b">
                            <h3 class="box-title"><?= Yii::t('main', 'Диалог') ?>: <?= Html::a($newMessage['user']->username, ['/user/profile', 'id' => $newMessage['user']->id]) ?></h3>
                        </div>
                    </div>
                    <div class="chat-rbox">
                        <ul class="chat-list p-20">
                            <?php foreach ($dialogData AS $message):
                                $isAuthor = $message->user_id == Yii::$app->user->id;
                                ?>
                                <li class="<?= $isAuthor ? 'reverse' : '' ?>">
                                    <?php if ($isAuthor): ?>
                                        <div class="chat-time"><?= Yii::$app->formatter->asRelativeTime($message->date) ?></div>
                                    <?php else: ?>
                                        <div class="chat-img"><img src="<?= $message->user->getAvatarLink() ?>"
                                                                   alt="user"></div>
                                    <?php endif; ?>
                                    <div class="chat-content">
                                        <h5><?= $message->user->username ?></h5>
                                        <div class="box bg-light-<?= $isAuthor ? 'info' : 'success' ?>"><?= $message->message ?></div>
                                    </div>
                                    <?php if ($isAuthor): ?>
                                        <div class="chat-img"><img src="<?= $message->user->getAvatarLink() ?>"
                                                                   alt="user"></div>
                                    <?php else: ?>
                                        <div class="chat-time"><?= Yii::$app->formatter->asRelativeTime($message->date) ?></div>
                                    <?php endif; ?>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    <div class="card-body b-t">
                        <?php $form = ActiveForm::begin(['action' => ['/message/send'], 'options' => ['data-pjax' => '']]); ?>
                        <?= $form->field($newMessage['sendMessageForm'], 'user_id')->hiddenInput(['value' => $newMessage['user']->id])->label(false) ?>
                        <div class="row">
                            <div class="col-10">
                                <?= $form->field($newMessage['sendMessageForm'], 'message')->textarea(['class' => 'form-control b-0', 'style' => 'width:100%;'])->label(false) ?>
                            </div>
                            <div class="col-2 text-right">
                                <button type="input" class="btn btn-info btn-circle btn-lg"><i
                                            class="fa fa-mail-forward"></i></button>
                            </div>
                        </div>
                        <?php ActiveForm::end(); ?>
                    </div>
                </div>
            <?php endif; ?>
            <?php if (empty($dialogData) && $newMessage): ?>
                <div class="chat-right-aside">
                    <div class="chat-main-header">
                        <div class="p-20 b-b">
                            <h3 class="box-title"><?= Yii::t('main', 'Диалог') ?>: <?= $newMessage['user']->username ?></h3>
                        </div>
                    </div>
                    <div class="chat-rbox">
                        <ul class="chat-list p-20">
                        </ul>
                    </div>
                    <div class="card-body b-t">
                        <?php $form = ActiveForm::begin(['action' => ['/message/send'], 'options' => ['data-pjax' => '']]); ?>
                        <?= $form->field($newMessage['sendMessageForm'], 'user_id')->hiddenInput(['value' => $newMessage['user']->id])->label(false) ?>
                        <div class="row">
                            <div class="col-10">
                                <?= $form->field($newMessage['sendMessageForm'], 'message')->textarea(['class' => 'form-control b-0', 'style' => 'width:100%;'])->label(false) ?>
                            </div>
                            <div class="col-2 text-right">
                                <button type="input" class="btn btn-info btn-circle btn-lg"><i
                                            class="fa fa-mail-forward"></i></button>
                            </div>
                        </div>
                        <?php ActiveForm::end(); ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
<?php Pjax::end();