<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var string $name */
/** @var string $message */

$this->title = $name;
?>
<div class="site-error" style="text-align:center;padding:60px 20px;">
    <div style="font-size:5rem;color:#dee2e6;margin-bottom:16px;">
        <?= $name === 'Not Found' ? '404' : '⚠' ?>
    </div>
    <h1 style="color:#2c3e50;"><?= Html::encode($name) ?></h1>
    <p style="color:#6c757d;max-width:480px;margin:12px auto 28px;">
        <?= nl2br(Html::encode($message)) ?>
    </p>
    <?= Html::a('← Back to Home', ['/site/index'], ['class' => 'btn btn-primary']) ?>
</div>
