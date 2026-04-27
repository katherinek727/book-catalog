<?php

/** @var app\models\Author $model */

$this->title = 'Create Author';
?>
<div class="author-create">
    <h1><?= $this->title ?></h1>
    <?= $this->render('_form', ['model' => $model]) ?>
</div>
