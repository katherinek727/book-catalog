<?php

use yii\helpers\Html;

$this->title = 'Authors';
?>
<div class="page-header">
    <div>
        <h1>Authors</h1>
        <p style="color:var(--ink-4);font-size:.9rem;margin-top:4px;"><?= count($authors) ?> author<?= count($authors) !== 1 ? 's' : '' ?> in the catalog</p>
    </div>
    <?php if (!Yii::$app->user->isGuest): ?>
        <?= Html::a('+ New Author', ['create'], ['class' => 'btn btn-primary']) ?>
    <?php endif; ?>
</div>

<?php if (empty($authors)): ?>
    <div class="empty-state">
        <div class="empty-state-icon">✍️</div>
        <h3>No authors yet</h3>
        <p>Add the first author to get started.</p>
        <?php if (!Yii::$app->user->isGuest): ?>
            <?= Html::a('Add Author', ['create'], ['class' => 'btn btn-primary']) ?>
        <?php endif; ?>
    </div>
<?php else: ?>
    <div class="row">
        <?php foreach ($authors as $author): ?>
        <div class="col-md-4 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center gap-3" style="margin-bottom:16px;">
                        <div class="author-avatar">
                            <?= mb_strtoupper(mb_substr($author->full_name, 0, 1)) ?>
                        </div>
                        <div>
                            <div class="card-title" style="margin:0 0 4px;"><?= Html::encode($author->full_name) ?></div>
                            <span class="stat-chip"><?= count($author->books) ?> book<?= count($author->books) !== 1 ? 's' : '' ?></span>
                        </div>
                    </div>
                    <div class="d-flex gap-2 flex-wrap">
                        <?= Html::a('View', ['view', 'id' => $author->id], ['class' => 'btn btn-ghost btn-sm']) ?>
                        <?php if (!Yii::$app->user->isGuest): ?>
                            <?= Html::a('Edit', ['update', 'id' => $author->id], ['class' => 'btn btn-secondary btn-sm']) ?>
                            <?= Html::a('Delete', ['delete', 'id' => $author->id], [
                                'class' => 'btn btn-danger btn-sm',
                                'data'  => ['confirm' => 'Delete "' . Html::encode($author->full_name) . '"?', 'method' => 'post'],
                            ]) ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
