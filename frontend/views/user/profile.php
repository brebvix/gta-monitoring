<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use common\models\User;

$this->title = Yii::t('main', 'Профиль') . ' ' . $user->username;
Yii::$app->params['breadcrumbs'][] = Yii::t('main', 'Пользователи');
Yii::$app->params['breadcrumbs'][] = $user->username;

Yii::$app->params['description'] = $user->username . ' - ' . Yii::t('main', 'отзывы, профиль, активность, контактная информация. Написать сообщение.');

$this->registerJsFile('/js/page_profile.js', ['depends' => 'yii\web\JqueryAsset']);
?>

<div class="row" itemscope itemtype="http://schema.org/CreativeWork">
    <meta itemprop="description" content="User <?= $user->username ?> page"/>
    <div class="col-lg-4 col-xlg-3 col-md-5">
        <div class="card">
            <div class="card-body">
                <center class="m-t-30">
                    <img itemprop="image" src="<?= $user->getAvatarLink() ?>"
                         alt="User <?= $user->username ?> avatar"
                         title="<?= (Yii::$app->user->id == $user->id) ? Yii::t('main', 'Нажмите, чтобы изменить аватарку') : '' ?>"
                         class="img-circle <?= (Yii::$app->user->id == $user->id) ? 'user-avatar' : '' ?>" width="150"/>
                    <?php
                    if (Yii::$app->user->id == $user->id) {
                        $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]);
                        echo $form->field($avatarUploadModel, 'avatar')->fileInput(['class' => 'd-none'])->label(false);
                        ActiveForm::end();
                    }
                    ?>
                    <h1 class="card-title m-t-10" itemprop="name"><?= $user->username ?></h1>
                    <h6 class="card-subtitle"><?= $user->about_me ?></h6>
                    <?php if (!Yii::$app->user->isGuest && $user->id != Yii::$app->user->id): ?>
                        <a href="<?= Url::to(['/user/profile', 'id' => Yii::$app->user->id, 'type' => 'message', 'type_id' => $user->id]) ?>"
                           class="btn btn-danger m-b-20 p-10 btn-block waves-effect waves-light">
                            <span class="text-left"><i class="fa fa-paper-plane-o"></i></span>
                            <?= Yii::t('main', 'Написать') ?>
                        </a>
                    <?php endif; ?>
                    <div class="row text-center justify-content-md-center">
                        <div class="col-4">
                            <a href="#" class="link mytooltip">
                                <i class="mdi mdi-thumb-down"></i>
                                <font class="font-medium"><?= $rating_down_count ?></font>
                                <span class="tooltip-content3"><?= Yii::t('main', 'Понизил рейтинг') ?>
                                    <b><?= $rating_down_count ?></b> <?= Yii::t('main', 'раз') ?> :(</span>
                            </a>
                        </div>
                        <div class="col-4">
                            <a href="#" class="link mytooltip">
                                <i class="mdi mdi-comment-processing"></i>
                                <font class="font-medium"><?= $comments_count ?></font>
                                <span class="tooltip-content3"><?= Yii::t('main', 'Написал') ?>
                                    <b><?= $comments_count ?></b> <?= Yii::t('main', 'комментариев') ?> ;)</span>
                            </a>
                        </div>
                        <div class="col-4">
                            <a href="#" class="link mytooltip">
                                <i class="mdi mdi-thumb-up"></i>
                                <font class="font-medium"><?= $rating_up_count ?></font>
                                <span class="tooltip-content3"><?= Yii::t('main', 'Повысил рейтинг') ?>
                                    <b><?= $rating_up_count ?></b> <?= Yii::t('main', 'раз') ?> :)</span>
                            </a>
                        </div>
                    </div>
                    <div itemprop="aggregateRating"
                         itemscope itemtype="http://schema.org/AggregateRating">
                        <h5 class="m-t-30"><?= Yii::t('main', 'Рейтинг') ?> <span
                                    class="pull-right"
                                    itemprop="ratingValue"><?= number_format($user->rating, 2, '.', '') ?></span></h5>
                        <meta itemprop="worstRating" content="0"/>
                        <meta itemprop="bestRating" content="10"/>
                        <meta itemprop="ratingCount" content="<?= round($user->rating_up + $user->rating_down) ?>"/>
                        </h2>
                        <div class="progress">
                            <div class="progress-bar bg-<?= $user->getRatingColor() ?>" role="progressbar"
                                 aria-valuenow="<?= $user->rating * 10 ?>"
                                 aria-valuemin="0" aria-valuemax="10"
                                 style="width:<?= $user->rating * 10 ?>%; height:6px;">
                                <span class="sr-only"><?= number_format($user->rating, 2, '.', '') ?>% Complete</span>
                            </div>
                        </div>
                    </div>
                </center>
            </div>
            <div>
                <hr>
            </div>
            <div class="card-body">
                <?php if (!empty($user->vk)): ?>
                    <small class="text-muted">VK</small>
                    <h6><?= Html::a($user->vk, 'https://vk.com/' . $user->vk, ['target' => '_blank', 'itemprop' => 'sameAs']) ?></h6>
                <?php endif; ?>
                <?php if (!empty($user->telegram)): ?>
                    <small class="text-muted">Telegram</small>
                    <h6><?= Html::a($user->telegram, 'https://telegram.me/' . $user->telegram, ['target' => '_blank', 'itemprop' => 'sameAs']) ?></h6>
                <?php endif; ?>
                <?php if (!empty($user->skype)): ?>
                    <small class="text-muted">Skype</small>
                    <h6><?= Html::a($user->skype, 'skype:' . $user->skype . '?chat', ['target' => '_blank', 'itemprop' => 'sameAs']) ?></h6>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <!-- Column -->
    <!-- Column -->
    <div class="col-lg-8 col-xlg-9 col-md-7">
        <div class="card">
            <!-- Nav tabs -->
            <ul class="nav nav-tabs profile-tab" role="tablist">
                <li class="nav-item"><a class="nav-link <?= $active == 'home' ? 'active' : '' ?>" data-toggle="tab"
                                        href="#home" role="tab"><?= Yii::t('main', 'Активность') ?></a>
                </li>
                <li class="nav-item"><a class="nav-link <?= $active == 'comments' ? 'active' : '' ?>" data-toggle="tab"
                                        href="#reviews" role="tab"><?= Yii::t('main', 'Отзывы') ?> <span
                                class="badge badge-info ml-auto"><?= $reviews_count ?></span></a>
                </li>
                <?php if ($user->id == Yii::$app->user->id): ?>
                    <li class="nav-item"><a class="nav-link <?= $active == 'message' ? 'active' : '' ?>"
                                            data-toggle="tab" href="#messages"
                                            role="tab"><?= Yii::t('main', 'Сообщения') ?></a>
                    </li>
                    <li class="nav-item"><a class="nav-link <?= $active == 'settings' ? 'active' : '' ?>"
                                            data-toggle="tab" href="#settings"
                                            role="tab"><?= Yii::t('main', 'Настройки') ?></a>
                    </li>
                <?php endif; ?>
            </ul>
            <!-- Tab panes -->
            <div class="tab-content">
                <div class="tab-pane <?= $active == 'home' ? 'active' : '' ?>" id="home" role="tabpanel">
                    <div class="card-body">
                        <?= $this->render('activity', ['activityList' => $activity]) ?>
                    </div>
                </div>
                <div class="tab-pane <?= $active == 'comments' ? 'active' : '' ?>" id="reviews" role="tabpanel">
                    <div class="card-body">
                        <?= \frontend\widgets\CommentsWidget::widget(['id' => $user->id, 'type' => \common\models\Comments::TYPE_USER]) ?>
                    </div>
                </div>
                <?php if ($user->id == Yii::$app->user->id): ?>
                    <div class="tab-pane <?= $active == 'message' ? 'active' : '' ?>" id="messages" role="tabpanel">
                        <?= $this->render('messages', [
                            'user' => $user,
                            'dialogList' => $dialogList,
                            'newMessage' => isset($newMessage) ? $newMessage : false,
                            'dialogData' => isset($dialogData) ? $dialogData : false,
                        ]); ?>
                    </div>
                    <div class="tab-pane <?= $active == 'settings' ? 'active' : '' ?>" id="settings" role="tabpanel">
                        <div class="card-body">
                            <div style="display:flex;">
                                <b>Telegram bot</b>:
                                <?php
                                $disabled = false;
                                if ($user->telegram_status == User::TELEGRAM_STATUS_DISABLED) {
                                    $disabled = true;
                                }
                                ?>
                                <div class="switch">
                                    <label><input id="telegramCheckbox"
                                                  type="checkbox" <?= !$disabled ? 'checked' : '' ?>><span
                                                class="lever switch-col-purple"></span></label>
                                </div>
                                <?php if ($user->telegram_status == User::TELEGRAM_STATUS_WAIT): ?>
                                    <?= Yii::t('main', 'Добавьте бота') ?>&nbsp;<a
                                            href="https://t.me/ServersFun_bot">@ServersFun_bot</a>&nbsp;
                                    <?= Yii::t('main', 'и отправьте ему сообщение') ?>&nbsp;
                                    <code>/auth <?= $user->telegram_user_id ?></code>
                                <?php elseif ($user->telegram_status == User::TELEGRAM_STATUS_ENABLED): ?>
                                    <?= Yii::t('main', 'Ваш аккаунт успешно подключен к Telegram боту') ?>.
                                <?php endif; ?>
                            </div>
                            <p><?= Yii::t('main', 'После подключения аккаунта к Telegram боту вы сможете мгновенно получать важные уведомления с сайта, а так же ежедневные отчеты по серверам, которые добавлены в') ?>
                                <?= Html::a(Yii::t('main', 'избранное'), ['/servers/favorites']) ?>.</p>
                            <hr>
                            <?php $form = ActiveForm::begin(['id' => 'edit-profile-form', 'options' => ['class' => 'form-horizontal form-material']]); ?>

                            <?= $form->field($editProfileModel, 'skype')->textInput() ?>
                            <?= $form->field($editProfileModel, 'vk')->textInput() ?>
                            <?= $form->field($editProfileModel, 'telegram')->textInput() ?>
                            <?= $form->field($editProfileModel, 'about_me')->textarea(['class' => 'form-control form-control-line', 'rows' => 5]) ?>
                            <?php if (!empty($user->password_hash)): ?>
                                <h3 class="text-muted text-center"><?= Yii::t('main', 'Смена пароля') ?></h3>
                                <?= $form->field($editProfileModel, 'oldPassword')->passwordInput() ?>
                                <?= $form->field($editProfileModel, 'newPassword')->passwordInput() ?>
                                <?= $form->field($editProfileModel, 'reNewPassword')->passwordInput() ?>
                            <?php endif; ?>
                            <div class="form-group">
                                <div class="col-sm-12 text-center">
                                    <button class="btn btn-success"><?= Yii::t('main', 'Обновить профиль') ?></button>
                                </div>
                            </div>
                            <?php ActiveForm::end() ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <!-- Column -->
</div>