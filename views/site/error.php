<?php

use yii\helpers\Html;

$this->title = $name;
$code = $name === 'Not Found' ? '404' : ($name === 'Forbidden' ? '403' : '500');
?>
<div class="error-wrap">
    <div>
        <div class="error-code"><?= $code ?></div>
        <h2><?= Html::encode($name) ?></h2>
        <p><?= nl2br(Html::encode($message)) ?></p>
        <?= Html::a('← Return Home', ['/site/index'], ['class' => 'btn btn-primary']) ?>
    </div>
</div>
