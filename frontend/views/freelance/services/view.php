<?php

use yii\widgets\ListView;
use yii\helpers\Html;
use kartik\markdown\Markdown;
use yii\helpers\Url;
use common\models\FreelanceVacancies;

$this->title = trim($model->title) . ' '. Yii::t('main', '/ Фриланс');
Yii::$app->params['breadcrumbs'][] = ['label' => Yii::t('main', 'Фриланс'), 'url' => ['/freelance/services']];
Yii::$app->params['breadcrumbs'][] = ['label' => Yii::t('main', 'Исполнители'), 'url' => ['/freelance/services']];
Yii::$app->params['breadcrumbs'][] = $model->title;

Yii::$app->params['description'] = $model->title . ' ' . Yii::t('main', $model->vacancie->title) . Yii::t('main', '- услуга фриланс');
?>
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="row">
                <?= $this->render('_left', ['vacancies_list' => $vacancies_list, 'active' => $model->vacancie_id]) ?>
                <div class="col-xlg-9 col-lg-9 col-md-9">
                    <br>
                    <div class="card-body" itemscope itemtype="https://schema.org/Service">
                        <div class="row">
                            <div class="col-md-8">
                                <h1 class="font-18" itemprop="name"><?= $model->vacancie->icon ?> <?= $model->title ?></h1>
                                <p class="text-muted" itemprop="description"><?= Markdown::convert($model->text) ?></p>
                                <?php if (!empty($model->portfolio_link)): ?>
                                    <?= Yii::t('main', 'Портфолио') ?>: <?= Html::a($model->portfolio_link, $model->portfolio_link, ['target' => '_blank']) ?>
                                <?php endif; ?>
                            </div>
                            <div class="col-md-4">
                                <?php if (!Yii::$app->user->isGuest): ?>
                                    <a href="<?= Url::to(['/user/profile', 'id' => Yii::$app->user->id, 'type' => 'message', 'type_id' => $model->user->id]) ?>"
                                       class="btn btn-primary <?= Yii::$app->user->id == $model->user_id ? 'disabled' : '' ?> m-b-20 p-10 btn-block waves-effect waves-light">
                                        <span class="text-left"><i class="fa fa-paper-plane-o"></i></span>
                                        <?= Yii::t('main', 'Написать') ?>
                                    </a>
                                <?php endif; ?>
                                <br>
                                <div class="list-group">
                                    <?php if (!empty($model->user->skype)): ?>
                                        <a href="skype:<?= $model->user->skype ?>?chat" target="_blank" itemprop="sameAs"
                                           class="list-group-item list-group-item-action flex-column align-items-start">
                                            <div class="d-flex w-100 justify-content-between">
                                                <h5 class="mb-1"><i class="mdi mdi-skype"></i> Skype</h5>
                                                <small><?= $model->user->skype ?></small>
                                            </div>
                                        </a>
                                    <?php endif; ?>
                                    <?php if (!empty($model->user->telegram)): ?>
                                        <a href="https://telegram.me/<?= $model->user->telegram ?>" target="_blank" itemprop="sameAs"
                                           class="list-group-item list-group-item-action flex-column align-items-start">
                                            <div class="d-flex w-100 justify-content-between">
                                                <h5 class="mb-1"><i class="mdi mdi-telegram"></i> Telegram</h5>
                                                <small><?= $model->user->telegram ?></small>
                                            </div>
                                        </a>
                                    <?php endif; ?>
                                    <?php if (!empty($model->user->vk)): ?>
                                        <a href="https://vk.com/<?= $model->user->vk ?>" target="_blank" itemprop="sameAs"
                                           class="list-group-item list-group-item-action flex-column align-items-start">
                                            <div class="d-flex w-100 justify-content-between">
                                                <h5 class="mb-1"><i class="mdi mdi-vk-box"></i> VK</h5>
                                                <small><?= $model->user->vk ?></small>
                                            </div>
                                        </a>
                                    <?php endif; ?>
                                </div>
                                <br>
                                <div class="list-group">

                                    <a href="#" target="_blank"
                                       class="list-group-item list-group-item-action flex-column align-items-start">
                                        <div class="d-flex w-100 justify-content-between">
                                            <h5 class="mb-1"><i
                                                        class="mdi mdi-clock"></i> <?= Yii::t('main', 'Стоимость часа работы') ?>
                                            </h5>
                                            <small><?= $model->price_per_hour ?><?= Yii::t('main', 'р.') ?></small>
                                        </div>
                                    </a>
                                    <a href="#" target="_blank"
                                       class="list-group-item list-group-item-action flex-column align-items-start">
                                        <div class="d-flex w-100 justify-content-between">
                                            <h5 class="mb-1"><i
                                                        class="mdi mdi-clock"></i> <?= Yii::t('main', 'Минимальная оплата') ?>
                                            </h5>
                                            <small><?= $model->minimum_price ?><?= Yii::t('main', 'р.') ?></small>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <?= Yii::t('main', 'Добавил') ?>
                        <b><?= Html::a($model->user->username, ['/user/profile', 'id' => $model->user_id]) ?></b> |
                        <?= Yii::$app->formatter->asRelativeTime($model->date) ?> |
                        <span class="badge badge-<?= $model->vacancie->getBadge() ?>" itemprop="serviceType">
                            <?= Yii::t('main', $model->vacancie->title) ?>
                        </span>
                        <div class="pull-left m-r-10 m-t-0"><img src="<?= $model->user->getAvatarLink() ?>" class="img-circle img-responsive" style="max-width:70px;"></div>
                        <h5 class="m-t-10"><?= Yii::t('main', 'Рейтинг исполнителя') ?>
                            <span class="pull-right">
                                        <?= number_format($model->user->rating, 2, '.', ' ') ?>
                                    </span>
                        </h5>
                        <div class="progress">
                            <div class="progress-bar bg-<?= $model->user->getRatingColor() ?>"
                                 role="progressbar" aria-valuenow="<?= $model->user->rating * 10 ?>"
                                 aria-valuemin="0" aria-valuemax="100"
                                 style="width:<?= $model->user->rating * 10 ?>%; height:6px;"><span
                                        class="sr-only"><?= number_format($model->user->rating, 2, '.', ' ') ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>