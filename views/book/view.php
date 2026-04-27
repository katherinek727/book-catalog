<?php

use yii\helpers\Html;

/** @var app\models\Book $book */

$this->title = $book->title;
?>
<div class="book-view">
    <div class="row">
        <div class="col-md-3">
            <?php if ($book->cover_image): ?>
                <img src="<?= Yii::$app->request->baseUrl ?>/uploads/covers/<?= Html::encode($book->cover_image) ?>"
                     class="img-fluid rounded" alt="Cover">
            <?php else: ?>
                <div class="bg-secondary text-white d-flex align-items-center justify-content-center rounded"
                     style="height:250px;">No Cover</div>
            <?php endif; ?>
        </div>
        <div class="col-md-9">
            <h1><?= Html::encode($book->title) ?></h1>
            <p><strong>Year:</strong> <?= $book->year ?></p>
            <?php if ($book->isbn): ?>
                <p><strong>ISBN:</strong> <?= Html::encode($book->isbn) ?></p>
            <?php endif; ?>
            <?php if ($book->description): ?>
                <p><?= nl2br(Html::encode($book->description)) ?></p>
            <?php endif; ?>

            <h5>Authors</h5>
            <?php if ($book->authors): ?>
                <ul>
                    <?php foreach ($book->authors as $author): ?>
                        <li><?= Html::a(Html::encode($author->full_name), ['/author/view', 'id' => $author->id]) ?></li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p>No authors assigned.</p>
            <?php endif; ?>

            <?php if (!Yii::$app->user->isGuest): ?>
                <?= Html::a('Edit', ['update', 'id' => $book->id], ['class' => 'btn btn-warning']) ?>
                <?= Html::a('Delete', ['delete', 'id' => $book->id], [
                    'class' => 'btn btn-danger',
                    'data'  => ['confirm' => 'Delete this book?', 'method' => 'post'],
                ]) ?>
            <?php endif; ?>
            <?= Html::a('Back', ['index'], ['class' => 'btn btn-secondary']) ?>
        </div>
    </div>
</div>
