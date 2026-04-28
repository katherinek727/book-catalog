<?php

use yii\helpers\Html;

/** @var yii\web\View $this */

$this->title = Yii::$app->name;
?>
<div class="site-index" style="text-align:center;padding:60px 20px;">
    <h1 style="font-size:2.4rem;margin-bottom:12px;"><?= Html::encode(Yii::$app->name) ?></h1>
    <p style="color:#6c757d;font-size:1.1rem;max-width:520px;margin:0 auto 36px;">
        Browse books, discover authors, and subscribe to get SMS notifications on new releases.
    </p>

    <div style="display:flex;gap:16px;justify-content:center;flex-wrap:wrap;">
        <?= Html::a('Browse Books', ['/book/index'], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('View Authors', ['/author/index'], ['class' => 'btn btn-secondary']) ?>
        <?= Html::a('Subscribe', ['/subscription/subscribe'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Top-10 Report', ['/report/index'], ['class' => 'btn btn-secondary']) ?>
    </div>
</div>
