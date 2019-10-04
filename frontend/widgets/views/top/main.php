<h4 class="text-center text-muted"><?= Yii::t('main', 'Сервер дня') ?></h4>
<table class="table stylish-table" style="margin-bottom: 0;">
    <tbody>
    <?php use yii\helpers\Url;

    foreach ($servers AS $server):
        ?>

        <tr class="active" style="border-left: 4px solid <?= $server->game->getColor() ?>;">
            <td>
                <h6>
                    <a href="<?= \yii\helpers\Url::to(['/servers/' . $server->game()]) ?>"><?= $server->game->title ?></a>
                </h6>
                <a href="<?= Url::to(['/server/view', 'id' => $server->id, 'title_eng' => $server->title_eng, 'game' => $server->game()]);
                ?>">
                    <small class="text-muted"><?= $server->title ?></small>
                </a>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>