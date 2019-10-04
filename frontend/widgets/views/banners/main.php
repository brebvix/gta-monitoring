<?php
use yii\helpers\Url;
?>
<a href="<?= $link ?>" target="_blank" class="card-body">
    <?=(!empty($title) && $hasTitle) ? '<h4 class="text-center text-muted">' . $title . '</h4>' : '' ?>
    <img alt="Advertising" src="<?= $image_path ?>" style="<?= !empty($title) ? 'width: 100%;' : '' ?>">
</a>