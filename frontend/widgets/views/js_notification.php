<?php
$this->registerJs("$.toast({
        text: '{$message}',
        position: 'top-right',
        loaderBg:'#009efb',
        icon: '{$class}',
        hideAfter: 5000,
        stack: 6
    });", 3);
?>