<?php

use yii\helpers\Html;

/** @var app\models\Book $model */
/** @var app\models\Author[] $authors */
/** @var int[] $selectedAuthorIds */

$this->title = 'Update: ' . Html::encode($model->title);
?>
<div class="book-update">
    <h1><?= Html::encode($this->title) ?></h1>
    <?= $this->render('_form', [
        'model'             => $model,
        'authors'           => $authors,
        'selectedAuthorIds' => $selectedAuthorIds,
    ]) ?>
</div>
