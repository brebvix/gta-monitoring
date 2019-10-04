<?php
use yii\helpers\Url;

?>
<a href="<?= Url::to(['/advertising/banner/buy', 'position' => $id]) ?>"
   class="<?= !empty($title) ? 'card-body' : '' ?>">
    <?= !empty($title) ? '<h4 class="text-center text-muted">' . $size . ' №' . $id . '</h4>' : '' ?>
    <img style="<?= !empty($title) ? 'width: 100%;' : '' ?>" alt="Game image <?= $size ?> №<?= $id ?>" src="/images/default/<?= $size ?>.png">
</a>