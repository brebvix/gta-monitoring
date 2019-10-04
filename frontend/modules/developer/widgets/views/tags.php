<?php

use yii\helpers\Url;

$first = true;
echo '<div style="display:inline-block">';
foreach ($tagsList as $tag): ?><?= !$first ? ', ' : '' ?><a class="font-14"
    href="<?= Url::to(['/developer/questions/tag', 'tag' => $tag->title_eng]) ?>"><?= $tag->title ?> (<?= $tag->count ?>)</a><?php
    $first = false;
endforeach;
echo '</div>';
?>
