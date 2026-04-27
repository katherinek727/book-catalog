<?php

/** @var app\models\Book $model */
/** @var app\models\Author[] $authors */

$this->title = 'Add Book';
?>
<div class="book-create">
    <h1><?= $this->title ?></h1>
    <?= $this->render('_form', ['model' => $model, 'authors' => $authors]) ?>
</div>
