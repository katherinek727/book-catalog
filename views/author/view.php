<?php

use yii\helpers\Html;

$this->title = $author->full_name;
$books = $author->books;
?>

<div style="margin-bottom:12px;">
    <?= Html::a('← Authors', ['index'], ['class' => 'btn btn-ghost btn-sm']) ?>
</div>

<div class="page-header">
    <div class="d-flex align-items-center gap-3">
        <div class="author-avatar" style="width:60px;height:60px;font-size:1.5rem;">
            <?= mb_strtoupper(mb_substr($author->full_name, 0, 1)) ?>
        </div>
        <div>
            <h1 style="margin:0 0 6px;"><?= Html::encode($author->full_name) ?></h1>
            <span class="stat-chip"><?= count($books) ?> book<?= count($books) !== 1 ? 's' : '' ?></span>
        </div>
    </div>
    <?php if (!Yii::$app->user->isGuest): ?>
        <div class="d-flex gap-2">
            <?= Html::a('Edit', ['update', 'id' => $author->id], ['class' => 'btn btn-secondary btn-sm']) ?>
            <?= Html::a('Delete', ['delete', 'id' => $author->id], [
                'class' => 'btn btn-danger btn-sm',
                'data'  => ['confirm' => 'Delete this author?', 'method' => 'post'],
            ]) ?>
        </div>
    <?php endif; ?>
</div>

<?php if ($books): ?>
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
                    <?= Html::a('View →', ['/book/view', 'id' => $book->id], ['class' => 'btn btn-ghost btn-sm']) ?>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
<?php else: ?>
    <div class="empty-state">
        <div class="empty-state-icon">📚</div>
        <h3>No books yet</h3>
        <p>This author has no books in the catalog.</p>
    </div>
<?php endif; ?>
