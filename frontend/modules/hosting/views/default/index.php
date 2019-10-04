<?php

use yii\helpers\Url;
use yii\widgets\ListView;

$this->registerJsFile('/template_assets/plugins/horizontal-timeline/js/horizontal-timeline.js', ['depends' => 'yii\web\JqueryAsset']);
$this->registerCssFile('/template_assets/plugins/horizontal-timeline/css/horizontal-timeline.css');

$this->title = Yii::t('main', 'Хостинг игровых серверов') . ' SAMP, CRMP';
Yii::$app->params['breadcrumbs'][] = Yii::t('main', 'Игровой хостинг серверов');

Yii::$app->params['description'] = Yii::t('main', 'Арендовать игровой хостинг SAMP, CRMP серверов.');
?>
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="row">
                <div class="col-xlg-3 col-lg-3 col-md-3" itemscope itemtype="http://schema.org/SiteNavigationElement">
                    <?= $this->render('/_left') ?>
                </div>
                <div class="col-xlg-9 col-lg-9 col-md-8">
                    <div class="card-body">
                        <h1 class="text-center"><?= Yii::t('main', 'Игровой хостинг серверов') ?></h1>
                        <section class="cd-horizontal-timeline">
                            <div class="timeline">
                                <div class="events-wrapper">
                                    <div class="events">
                                        <ol>
                                            <li><a href="#0" data-date="01/01/2010" class="selected"><i
                                                            class="fa fa-telegram"></i></a></li>
                                            <li><a href="#0" data-date="01/01/2011"><i class="fa fa-rocket"></i></a>
                                            </li>
                                            <li><a href="#0" data-date="01/01/2012"><i class="fa fa-tasks"></i></a></li>
                                            <li><a href="#0" data-date="01/01/2013"><i class="fa fa-star-o"></i></a>
                                            </li>
                                            <li><a href="#0" data-date="01/01/2014"><i class="fa fa-gears"></i></a></li>
                                            <li><a href="#0" data-date="01/01/2015"><i class="fa fa-question"></i></a>
                                            </li>
                                            <li><a href="#0" data-date="01/01/2016"><i class="fa fa-lock"></i></a></li>
                                            <li><a href="#0" data-date="01/01/2017"><i class="fa fa-check-square-o"></i></a>
                                            </li>
                                            <li><a href="#0" data-date="01/01/2018"><i class="fa fa-money"></i></a></li>
                                        </ol>
                                        <span class="filling-line" aria-hidden="true"></span>
                                    </div>
                                    <!-- .events -->
                                </div>
                                <!-- .events-wrapper -->
                                <ul class="cd-timeline-navigation">
                                    <li><a href="#0" class="prev inactive"><?= Yii::t('main', 'Назад') ?></a></li>
                                    <li><a href="#0" class="next"><?= Yii::t('main', 'Вперед') ?></a></li>
                                </ul>
                                <!-- .cd-timeline-navigation -->
                            </div>
                            <!-- .timeline -->
                            <div class="events-content">
                                <ol>
                                    <li class="selected" data-date="01/01/2010">
                                        <h2><?= Yii::t('main', 'Управление с помощью Telegram?') ?><br/>
                                            <small><?= Yii::t('main', 'Добавить бота') ?> <a
                                                        href="https://t.me/ServersFun_bot"
                                                        target="_blank">@ServersFun_bot</a>
                                            </small>
                                        </h2>
                                        <hr class="m-t-40">
                                        <p class="m-t-40">
                                            <?= Yii::t('main', 'Надоели скучные WEB интерфейсы? Надоело тратить много времени на простые действия?<br> Только мы можем предложить Вам по настоящему достойное решение:<br> Свяжите свой Telegram с аккаунтом на сайте и сразу после аренды сервера Вам будет доступно ПОЛНОЕ управление сервером с помощью Telegram`a - запуск, остановка, перезапуск сервера, получение последних логов сервера. А так же <u>мгновенные</u> уведомления о перебоях в работе сервера, просмотр основной информации в реальном времени.') ?>
                                        </p>
                                    </li>
                                    <li data-date="01/01/2011">
                                        <h2><?= Yii::t('main', 'Скорость') ?><br/>
                                            <small><?= Yii::t('main', 'Мы готовы Вас удивить!') ?></small>
                                        </h2>
                                        <hr class="m-t-40">
                                        <p class="m-t-40">
                                            <?= Yii::t('main', 'Благодаря возможности выбора территориального расположения сервера Вы можетепредложить своим игрокам минимальный пинг, в зависимости от расположенияосновной аудитории игроков. Все сервера расположены в крупных Дата центрах ипредлагают полосу пропускания 1GiB.') ?>
                                        </p>
                                    </li>
                                    <li data-date="01/01/2012">
                                        <h2><?= Yii::t('main', 'Лучшее оборудование') ?><br/>
                                            <small><?= Yii::t('main', 'Попробуйте загрузить его полностью!') ?></small>
                                        </h2>
                                        <hr class="m-t-40">
                                        <p class="m-t-40">
                                            <?= Yii::t('main', 'При сравнительно небольшой нагрузке SAMP и CRMP серверов мы уверены, что только лучшие выделенные сервера смогут поддерживать постоянное бесперебойное соединение пользователей с сервером. А благодаря использованию SSD дисков Вы можете быть уверены, что игровой сервер будет работать с максимально возможной скоростью и мощностю!') ?>
                                        </p>
                                    </li>
                                    <li data-date="01/01/2013">
                                        <h2><?= Yii::t('main', 'Бонусы для клиентов') ?><br/>
                                            <small><?= Yii::t('main', 'Заинтересовались?') ?> =)</small>
                                        </h2>
                                        <hr class="m-t-40">
                                        <p class="m-t-40">
                                            <?= Yii::t('main', 'Servers.Fun - большая платформа, предлагающая игрокам и разработчикам много интересного и полезного функционала. Благодаря этому, у нас есть возможность предложить клиентам помимо функционала игрового хостинга еще и дополнительные бонусы. При заказе игрового хостинга Ваш сервер получит VIP статус в') ?>
                                            <a href="<?= Url::to(['/']) ?>"><?= Yii::t('main', 'мониторинге') ?></a> <?= Yii::t('main', 'и будет помещен на <u>первую страницу</u> на одну неделю.') ?>
                                        </p>
                                    </li>
                                    <li data-date="01/01/2014">
                                        <h2><?= Yii::t('main', 'Полный доступ') ?><br/>
                                            <small><?= Yii::t('main', 'FTP, База Данных - почти безлимит!') ?></small>
                                        </h2>
                                        <hr class="m-t-40">
                                        <p class="m-t-40">
                                            <?= Yii::t('main', 'Мы предоставляем своим клиентам полный доступ к файлам сервера с помощью FTP, а так же Базу Данных MySQL (в комплекте с PHPMyAdmin). К сожалению, мы не можем гарантировать полный безлимит всем нашим пользователям из-за дороговизны SSD исков, однако если для Вашего сервера нужно больше места - Вы можете бесплатно его увеличить, обратившись в поддержку.') ?>
                                        </p>
                                    </li>
                                    <li data-date="01/01/2015">
                                        <h2><?= Yii::t('main', 'Поддержка') ?><br/>
                                            <small><?= Yii::t('main', 'Ответим на большинство вопросов!') ?></small>
                                        </h2>
                                        <hr class="m-t-40">
                                        <p class="m-t-40">
                                            <?= Yii::t('main', 'Поддержка доступна 7 дней в неделю, среднее время ответа составляет от 15 до 45 минут. К сожалению, мы можем гарантировать исключительно решение проблем связанных с технической частью игрового хостинга Servers.Fun. Если у Вас возникли проблемы с установкой игрового мода - свяжитесь с нами, и если проблема будет на нашей стороне - она будет решена в ближайшее время.') ?>
                                        </p>
                                    </li>
                                    <li data-date="01/01/2016">
                                        <h2><?= Yii::t('main', 'Защита') ?><br/>
                                            <small><?= Yii::t('main', 'Отбросьте все сомнения!') ?></small>
                                        </h2>
                                        <hr class="m-t-40">
                                        <p class="m-t-40">
                                            <?= Yii::t('main', 'Наши клиенты надежно спрятаны за толстым слоем защиты, направленной на отсечение всяких попыток влиять на работоспособность наших серверов. Мы гарантируем максимальную работоспособность всех наших сервисов при любых нагрузках. К слову, весь проект Servers.Fun, и если Вы считаете иначе - попробуйте нас переубедить!') ?>
                                        </p>
                                    </li>
                                    <li data-date="01/01/2017">
                                        <h2><?= Yii::t('main', 'Заказ') ?><br/>
                                            <small><?= Yii::t('main', 'Всего 2 минуты и Ваш сервер уже работает!') ?></small>
                                        </h2>
                                        <hr class="m-t-40">
                                        <p class="m-t-40">
                                            <?= Yii::t('main', 'Весь процесс заказа сервера состоит из четырех интуитивно понятных шагов. Выбор игры => Выбор версии игрового сервера => Выбор расположения => Выбор количества игровых слотов и срока аренды сервера, подтверждение. Обратите внимание, что для аренды у Вас должно быть достаточно средств на счету. Для пополнения нажмите по текущему балансу в правом верхнем углу.') ?>
                                        </p>
                                    </li>
                                    <li data-date="01/01/2018">
                                        <h2><?= Yii::t('main', 'Стоимость') ?><br/>
                                            <small><?= Yii::t('main', 'Это ведь совсем недорого, правда?') ?></small>
                                        </h2>
                                        <hr class="m-t-40">
                                        <p class="m-t-40">
                                            <?= Yii::t('main', 'При абсолютно средней рыночной цене (<b>1.5р/Слот</b> для SAMP, CRMP серверов) мы предлагаем нашим клиентам гораздо больше, чем просто хостинг для сервера.<br>Если дочитали до этого пункта - скорее всего Вы уже сами в этом убедились.') ?>
                                            =)
                                        </p>
                                    </li>
                                </ol>
                            </div>
                            <!-- .events-content -->
                        </section>
                        <hr>
                        <div class="row pricing-plan" style="margin-right: 5%;">
                            <div class="col-md-2"></div>
                            <div class="col-md-4 col-xs-12 col-sm-6 no-padding">
                                <div class="pricing-box">
                                    <div class="pricing-body b-l">
                                        <div class="pricing-header">
                                            <h4 class="text-center">SAMP</h4>
                                            <h2 class="text-center">1.5<sub style="font-size: 16px;"><i
                                                            class="mdi mdi-currency-rub"></i></sub></h2>
                                            <p class="uppercase"><?= Yii::t('main', 'за слот') ?></p>
                                        </div>
                                        <div class="price-table-content">
                                            <div class="price-row"><i class="fa fa-flip-vertical"></i> SA-MP 0.3DL R1
                                            </div>
                                            <div class="price-row"><i class="fa fa-flip-vertical"></i> SA-MP 0.3.7 R2-1
                                            </div>
                                            <div class="price-row"><i
                                                        class="icon-user"></i> <?= Yii::t('main', 'от 50 слотов') ?>
                                            </div>
                                            <div class="price-row"><i class="fa fa-server"></i> FTP
                                                <small class="text-muted">500Mb</small>
                                            </div>
                                            <div class="price-row"><i class="fa fa-database"></i> MySQL
                                                <small class="text-muted">500Mb</small>
                                            </div>
                                            <div class="price-row"><i class="fa fa-telegram"></i> Telegram bot</div>
                                            <div class="price-row"><i
                                                        class="fa fa-rocket"></i> <?= Yii::t('main', 'Мгновенная установка') ?>
                                            </div>
                                            <div class="price-row"><i
                                                        class="fa fa-clock-o"></i> <?= Yii::t('main', 'Поддержка') ?>
                                            </div>
                                            <div class="price-row"><i
                                                        class="fa fa-lock"></i> <?= Yii::t('main', 'Защита от DDOS') ?>
                                            </div>
                                            <div class="price-row">
                                                <a href="<?= Url::to(['/hosting/order/step-two', 'game_id' => 1]) ?>"
                                                   class="btn btn-primary btn-block waves-effect waves-light"
                                                   style="width: 50%;"><?= Yii::t('main', 'Заказать') ?></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-xs-12 col-sm-6 no-padding">
                                <div class="pricing-box featured-plan">
                                    <div class="pricing-body">
                                        <div class="pricing-header">
                                            <h4 class="price-lable text-white bg-primary"> <?= Yii::t('main', 'Популярно') ?></h4>
                                            <h4 class="text-center">CRMP</h4>
                                            <h2 class="text-center">1.5<sub style="font-size: 16px;"><i
                                                            class="mdi mdi-currency-rub"></i></sub></h2>
                                            <p class="uppercase"><?= Yii::t('main', 'за слот') ?></p>
                                        </div>
                                        <div class="price-table-content">
                                            <div class="price-row"><i class="fa fa-flip-vertical"></i> CR-MP 0.3.7 C5
                                                (2.4)
                                            </div>
                                            <div class="price-row"><i class="fa fa-flip-vertical"></i> CR-MP 0.3E C3
                                            </div>
                                            <div class="price-row"><i
                                                        class="icon-user"></i> <?= Yii::t('main', 'от 50 слотов') ?>
                                            </div>
                                            <div class="price-row"><i class="fa fa-server"></i> FTP
                                                <small class="text-muted">500Mb</small>
                                            </div>
                                            <div class="price-row"><i class="fa fa-database"></i> MySQL
                                                <small class="text-muted">500Mb</small>
                                            </div>
                                            <div class="price-row"><i class="fa fa-telegram"></i> Telegram bot</div>
                                            <div class="price-row"><i
                                                        class="fa fa-rocket"></i> <?= Yii::t('main', 'Мгновенная установка') ?>
                                            </div>
                                            <div class="price-row"><i
                                                        class="fa fa-clock-o"></i> <?= Yii::t('main', 'Поддержка') ?>
                                            </div>
                                            <div class="price-row"><i
                                                        class="fa fa-lock"></i> <?= Yii::t('main', 'Защита от DDOS') ?>
                                            </div>
                                            <div class="price-row">
                                                <a href="<?= Url::to(['/hosting/order/step-two', 'game_id' => 1]) ?>"
                                                   class="btn btn-primary btn-block waves-effect waves-light"
                                                   style="width: 50%;"><?= Yii::t('main', 'Заказать') ?></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>