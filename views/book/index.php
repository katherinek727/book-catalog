<?php

use yii\helpers\Html;
use yii\widgets\LinkPager;

$this->title = 'Book Catalog';
?>
<div class="page-header">
    <div>
        <h1>Book Catalog</h1>
        <p style="color:var(--ink-4);font-size:.9rem;margin-top:4px;"><?= $pagination->totalCount ?> title<?= $pagination->totalCount !== 1 ? 's' : '' ?></p>
    </div>
    <?php if (!Yii::$app->user->isGuest): ?>
        <?= Html::a('+ Add Book', ['create'], ['class' => 'btn btn-primary']) ?>
    <?php endif; ?>
</div>

<?php if (empty($books)): ?>
    <div class="empty-state">
        <div class="empty-state-icon">📖</div>
        <h3>No books yet</h3>
        <p>The catalog is empty. Add the first book to get started.</p>
        <?php if (!Yii::$app->user->isGuest): ?>
            <?= Html::a('Add Book', ['create'], ['class' => 'btn btn-primary']) ?>
        <?php endif; ?>
    </div>
<?php else: ?>
    <div class="row">
        <?php foreach ($books as $book): ?>
        <div class="col-md-3 mb-4">
            <div class="card h-100">
                <?php if ($book->cover_image): ?>
                    <img src="<?= Yii::$app->request->baseUrl ?>/uploads/covers/<?= Html::encode($book->cover_image) ?>"
                         class="card-img-top" alt="<?= Html::encode($book->title) ?>">
                <?php else: ?>
                    <div class="card-no-cover">No Cover</div>
                <?php endif; ?>
                <div class="card-body">
                    <div class="card-title"><?= Html::encode($book->title) ?></div>
                    <div class="card-text"><?= $book->year ?></div>
                    <?= Html::a('View →', ['view', 'id' => $book->id], ['class' => 'btn btn-ghost btn-sm']) ?>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <?= LinkPager::widget(['pagination' => $pagination]) ?>
<?php endif; ?>
