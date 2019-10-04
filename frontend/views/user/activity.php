<?php $inverted = true; ?>
<ul class="timeline">
    <?php
    foreach ($activityList AS $activity) {
        $inverted = ($inverted == true) ? false : true;
        $data = [
            'inverted' => $inverted,
            'activity' => $activity,
        ];
        echo $this->render('/activity/type_' . $activity->type, array_merge($data, json_decode($activity->data, true)));
    }
    ?>
</ul>