<?php

use yii\helpers\Html;
use yii\widgets\LinkPager;

/** @var app\models\Book[] $books */
/** @var yii\data\Pagination $pagination */

$this->title = 'Book Catalog';
?>
<div class="book-index">
    <div class="page-header">
        <h1><?= Html::encode($this->title) ?></h1>
        <?php if (!Yii::$app->user->isGuest): ?>
            <?= Html::a('+ Add Book', ['create'], ['class' => 'btn btn-success']) ?>
        <?php endif; ?>
    </div>

    <?php if (empty($books)): ?>
        <p class="text-muted">No books yet.</p>
    <?php else: ?>
        <div class="row">
            <?php foreach ($books as $book): ?>
            <div class="col-md-3 mb-4">
                <div class="card h-100">
                    <?php if ($book->cover_image): ?>
                        <img src="<?= Yii::$app->request->baseUrl ?>/uploads/covers/<?= Html::encode($book->cover_image) ?>"
                             class="card-img-top" alt="<?= Html::encode($book->title) ?>">
                    <?php else: ?>
                        <div style="height:200px;background:#e9ecef;display:flex;align-items:center;justify-content:center;color:#aaa;font-size:.85rem;">
                            No Cover
                        </div>
                    <?php endif; ?>
                    <div class="card-body">
                        <h5 class="card-title"><?= Html::encode($book->title) ?></h5>
                        <p class="card-text"><?= $book->year ?></p>
                        <?= Html::a('View', ['view', 'id' => $book->id], ['class' => 'btn btn-primary btn-sm']) ?>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <?= LinkPager::widget(['pagination' => $pagination]) ?>
    <?php endif; ?>
</div>
