<?php

use yii\helpers\Html;

/** @var app\models\Author $author */

$this->title = $author->full_name;
?>
<div class="author-view">
    <div class="page-header">
        <h1><?= Html::encode($author->full_name) ?></h1>
        <div style="display:flex;gap:8px;">
            <?php if (!Yii::$app->user->isGuest): ?>
                <?= Html::a('Edit', ['update', 'id' => $author->id], ['class' => 'btn btn-warning']) ?>
                <?= Html::a('Delete', ['delete', 'id' => $author->id], [
                    'class' => 'btn btn-danger',
                    'data'  => ['confirm' => 'Delete this author?', 'method' => 'post'],
                ]) ?>
            <?php endif; ?>
            <?= Html::a('← Back', ['index'], ['class' => 'btn btn-secondary']) ?>
        </div>
    </div>

    <div class="card mt-4">
        <div class="card-body">
            <h3>Books by <?= Html::encode($author->full_name) ?></h3>
            <?php if ($author->books): ?>
                <ul style="list-style:none;padding:0;">
                    <?php foreach ($author->books as $book): ?>
                        <li style="padding:8px 0;border-bottom:1px solid #eee;">
                            <?= Html::a(Html::encode($book->title), ['/book/view', 'id' => $book->id]) ?>
                            <span class="text-muted">(<?= $book->year ?>)</span>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p class="text-muted">No books yet.</p>
            <?php endif; ?>
        </div>
    </div>
</div>
