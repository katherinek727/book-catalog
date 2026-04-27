<?php

use yii\helpers\Html;

/** @var app\models\Author $model */

$this->title = 'Update: ' . Html::encode($model->full_name);
?>
<div class="author-update">
    <h1><?= Html::encode($this->title) ?></h1>
    <?= $this->render('_form', ['model' => $model]) ?>
</div>
