<?php
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'FAQ';
Yii::$app->params['breadcrumbs'][] = Yii::t('main', 'Помощь');
Yii::$app->params['breadcrumbs'][] = $this->title;

Yii::$app->params['description'] = Yii::t('main', 'Ответы на вопросы по использованию сайта');
?>


<div id="accordion2" role="tablist" class="minimal-faq" aria-multiselectable="true">
    <div class="card m-b-0">
        <div class="card-header" role="tab" id="headingOne11">
            <h5 class="m-l-20 mb-0">
                <a data-toggle="collapse" data-parent="#accordion2" href="#collapseOne11" aria-expanded="true"
                   aria-controls="collapseOne11" class="">
                    1. <?= Yii::t('main' ,'Проект') ?> Servers.Fun
                </a>
            </h5>
        </div>
        <div id="collapseOne11" class="collapse show" role="tabpanel" aria-labelledby="headingOne11" style="">
            <div class="card-body">
                <?= Yii::t('main' ,'Servers.Fun - мониторинг игровых серверов с расширенными и уникальными возможностями. На данный момент пользователям нашего сайта доступны такие возможности как добавление серверов, просмотр существующих (их статистики, рейтинга, отзывов, а так же WEB-Модулей для размещения на собственных сайтах); профили пользователей с возможностью общения; фриланс (размещение вакансий, услуг (резюме), и коммуникация), возможность пополнения баланса и покупки платных усуг. Это лишь малая часть проделанной работы, и список функционала пополняеться регулярно.') ?>
            </div>
        </div>
    </div>
    <div class="card m-b-0">
        <div class="card-header" role="tab" id="headingTwo22">
            <h5 class="m-l-20 mb-0">
                <a class="collapsed" data-toggle="collapse" data-parent="#accordion2" href="#collapseTwo22"
                   aria-expanded="false" aria-controls="collapseTwo22">
                    2. <?= Yii::t('main' ,'Как происходит вычисление рейтинга серверов?') ?>
                </a>
            </h5>
        </div>
        <div id="collapseTwo22" class="collapse" role="tabpanel" aria-labelledby="headingTwo22" style="">
            <div class="card-body">
                <?= Yii::t('main' ,'Каждый сервер в мониторинге Servers.Fun имеет оцену от 0 до 10, может иметь положительные и отриццательные оценки, а для расчета самого рейтинга используеться формула Эдвина Уилсона. На сам рейтинг сервера влияют не только "лайки" и "дизлайки", а еще и много сопутствующих факторов - стабильность онлайна, количество комментариев (с особенностью их положительный/отрицательный настрой), количество просмотров страницы сервера и так далее. Однако, даже у нового, но при этом интересного сервера есть хорошие шансы находиться рядом с "крупными" и зажиточными серверами.') ?>
            </div>
        </div>
    </div>
    <div class="card m-b-0">
        <div class="card-header" role="tab" id="headingThree33">
            <h5 class="m-l-20  mb-0">
                <a class="collapsed" data-toggle="collapse" data-parent="#accordion2" href="#collapseThree33"
                   aria-expanded="false" aria-controls="collapseThree33">
                    3. <?= Yii::t('main' ,'Как происходит вычисление рейтинга пользователей?') ?>
                </a>
            </h5>
        </div>
        <div id="collapseThree33" class="collapse" role="tabpanel" aria-labelledby="headingThree33">
            <div class="card-body">
                <?= Yii::t('main' ,'В основу расчета рейтинга взята всё та же формула Эдвина Уилсона, однако, в отличии от серверов - нет возможности поставить пользователю "лайк" или же "дизлайк", однако при этом учитываеться много факторов, некоторые из них: отзывы о пользователях (отрицательные и положительные отзывы имеют разное влияние на рейтинг), количество комментариев/лайков/дизлайков оставленных пользователем. Даже лайки/дизлайки на оставленный пользователем комментарий имеют влияние на конечный рейтинг пользователя.') ?>
            </div>
        </div>
    </div>
    <div class="card m-b-0">
        <div class="card-header" role="tab" id="headingOne111">
            <h5 class="m-l-20 mb-0">
                <a data-toggle="collapse" data-parent="#accordion2" href="#collapseOne111" aria-expanded="false"
                   aria-controls="collapseOne111" class="collapsed">
                    4. <?= Yii::t('main' ,'Платные услуги') ?>
                </a>
            </h5>
        </div>
        <div id="collapseOne111" class="collapse" role="tabpanel" aria-labelledby="headingOne111">
            <div class="card-body">
                <?= Yii::t('main' ,'Servers.Fun предлагает обширный список платных услуг, направленных в первую очередь на возможность быстрого развития серверов. С полным списком услуг можно ознакомится на странице') ?>
                "<?= Html::a(Yii::t('main', 'Реклама'), ['/advertising']) ?>".
                <?= Yii::t('main' ,'Обратите внимание, ни одна из платных услуг не позволяет влиять на рейтинг серверов/пользователей.') ?>
            </div>
        </div>
    </div>
    <div class="card m-b-0">
        <div class="card-header" role="tab" id="headingTwo222">
            <h5 class="m-l-20 mb-0">
                <a class="collapsed" data-toggle="collapse" data-parent="#accordion2" href="#collapseTwo222"
                   aria-expanded="false" aria-controls="collapseTwo222">
                    5. <?= Yii::t('main' ,'Фриланс') ?>
                </a>
            </h5>
        </div>
        <div id="collapseTwo222" class="collapse" role="tabpanel" aria-labelledby="headingTwo222">
            <div class="card-body">
                <?= Yii::t('main' ,'В данном направлении Servers.Fun предлагает, пока что, не очень обширный - но достаточно нужный и удобный функционал. Если Вам нужны сотрудники - просто зайдите в раздел') ?>
                "<?= Html::a(Yii::t('main', 'Вакансии'), ['/freelance/vacancies']) ?>"
                <?= Yii::t('main' ,'и разместите соответствующее объявление. Будьте уверены - в ближайшее время Вы получите достаточно предложений (не забывайте о необходимости указать контактную информацию в своем профиле).<br> В случае же, если Вы находитесь в поиске разовой/постоянной работы - Вы можете зайти в раздел') ?>
                "<?= Html::a(Yii::t('main', 'Услуги'), ['/freelance/services']) ?>"
                <?= Yii::t('main' ,'и разместить объявление о предоставлении услуг в какой либо сфере.') ?>
            </div>
        </div>
    </div>
    <div class="card m-b-0">
        <div class="card-header" role="tab" id="headingThree666">
            <h5 class="m-l-20 mb-0">
                <a class="collapsed" data-toggle="collapse" data-parent="#accordion2" href="#collapseThree666"
                   aria-expanded="false" aria-controls="collapseThree666">
                    6. <?= Yii::t('main' ,'WEB-Модули') ?>
                </a>
            </h5>
        </div>
        <div id="collapseThree666" class="collapse" role="tabpanel" aria-labelledby="headingThree666">
            <div class="card-body">
                <?= Yii::t('main' ,'На странице каждого сервера доступна вкладка "WEB-Модули", где Вы можете найти готовую статистику сервера, доступную для встраивания на абсолютно любой сайт. Вам достаточно только скопировать код, и вставить в желаемом месте на сайте.') ?>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header" role="tab" id="headingThree445">
            <h5 class="m-l-20 mb-0">
                <a class="collapsed" data-toggle="collapse" data-parent="#accordion2" href="#collapseThree445"
                   aria-expanded="false" aria-controls="collapseThree445">
                    7. API
                </a>
            </h5>
        </div>
        <div id="collapseThree445" class="collapse" role="tabpanel" aria-labelledby="headingThree445">
            <div class="card-body">
                <?= Yii::t('main' ,'Если Вас не устраивают готовые WEB-Модули, а статистику всё же хочеться - воспользуйтесь API.') ?>
                <code><?= Yii::$app->urlManager->createAbsoluteUrl(['/api/as-json']) ?>?server_id=&lt;SERVER_ID&gt;</code> - <?= Yii::t('main' ,'где') ?> <code>&lt;SERVER_ID&gt;</code> -
                <?= Yii::t('main' ,'ID сервера, для которого хотите получить информациюо сервере. Обратите внимание, данные будут возвращеные в формате') ?>
                <code>JSON</code>.
                <hr>
                <h4><?= Yii::t('main' ,'Пример') ?>, PHP:</h4>
                <code>$server =
                    json_decode(file_get_contents('<?= Yii::$app->urlManager->createAbsoluteUrl(['/api/as-json']) ?>?server_id=&lt;SERVER_ID&gt;'), true);<br>
                    echo "<?= Yii::t('main', 'Игроки') ?>: {$server['players']['online']} /
                    {$server['players']['maxplayers']} &lt;br&gt;";<br>
                    echo "<?= Yii::t('main', 'Заголовок сервера') ?>: {$server['title']} &lt;br&gt;";<br>
                    echo "<?= Yii::t('main', 'Адрес') ?>: {$server['ip']}:{$server['port']} &lt;br&gt;";<br>
                    echo "<?= Yii::t('main', 'Рейтинг') ?>: {$server['rating']} / 10 &lt;br&gt;";<br>
                    echo "<?= Yii::t('main', 'Статус') ?>: " . $server['status'] == 0 ?
                    '<?= Yii::t('main', 'Оффлайн') ?>' : '<?= Yii::t('main', 'Онлайн') ?>' . " &lt;br&gt;";
                </code>
                <br><br>
                <h4><?= Yii::t('main' ,'Пример') ?>, JavaScript:</h4>
                <code>
                    &lt;script src="<?= Yii::$app->urlManager->createAbsoluteUrl(['/api/as-json']) ?>?server_id=&lt;SERVER_ID&gt;&jsVariable=true"&gt;&lt;/script&gt;<br>
                    &lt;b&gt;<?= Yii::t('main', 'Игроки') ?>:&lt;/b&gt; &lt;i&gt;&lt;script&gt;document.write(server.players.online + ' / ' + server.players.maxplayers);&lt;/script&gt;&lt;/i&gt;&lt;br&gt;<br>
                    &lt;b&gt;<?= Yii::t('main', 'Заголовок сервера') ?>:&lt;/b&gt; &lt;i&gt;&lt;script&gt;document.write(server.title);&lt;/script&gt;&lt;/i&gt;&lt;br&gt;<br>
                    &lt;b&gt;<?= Yii::t('main', 'Адрес') ?>:&lt;/b&gt; &lt;i&gt;&lt;script&gt;document.write(server.ip+ ':' + server.port);&lt;/script&gt;&lt;/i&gt;&lt;br&gt;<br>
                    &lt;b&gt;<?= Yii::t('main', 'Рейтинг') ?>:&lt;/b&gt; &lt;i&gt;&lt;script&gt;document.write(server.rating);&lt;/script&gt; / 10&lt;/i&gt;&lt;br&gt;<br>
                    &lt;b&gt;<?= Yii::t('main', 'Статус') ?>:&lt;/b&gt; &lt;i&gt;&lt;script&gt;document.write(server.status == 0 ? '<?= Yii::t('main', 'Оффлайн') ?>' : '<?= Yii::t('main', 'Онлайн') ?>');&lt;/script&gt;&lt;/i&gt;
                </code>
            </div>
        </div>
    </div>
</div>