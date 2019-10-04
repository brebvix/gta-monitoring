
<?php
use yii\helpers\Url;

foreach ($links AS $link): ?>
    <a href="<?= Url::to(['/links/go', 'identifier' => $link->link->identifier]) ?>" target="_blank" class="list-group-item <?= $link->background ?> <?= $link->text_color ?>"><?= $link->title ?></a>
<?php endforeach; ?>