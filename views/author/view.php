<?php

use yii\helpers\Html;

/** @var app\models\Author $author */

$this->title = $author->full_name;
?>
<div class="author-view">
    <h1><?= Html::encode($author->full_name) ?></h1>

    <?php if (!Yii::$app->user->isGuest): ?>
        <?= Html::a('Edit', ['update', 'id' => $author->id], ['class' => 'btn btn-warning']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $author->id], [
            'class' => 'btn btn-danger',
            'data'  => ['confirm' => 'Delete this author?', 'method' => 'post'],
        ]) ?>
    <?php endif; ?>

    <h3 class="mt-4">Books</h3>
    <?php if ($author->books): ?>
        <ul>
            <?php foreach ($author->books as $book): ?>
                <li><?= Html::a(Html::encode($book->title), ['/book/view', 'id' => $book->id]) ?> (<?= $book->year ?>)</li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>No books yet.</p>
    <?php endif; ?>

    <?= Html::a('Back to Authors', ['index'], ['class' => 'btn btn-secondary mt-3']) ?>
</div>
