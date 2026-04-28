<?php

use yii\helpers\Html;

/** @var app\models\Author[] $authors */

$this->title = 'Authors';
?>
<div class="author-index">
    <div class="page-header">
        <h1><?= Html::encode($this->title) ?></h1>
        <?php if (!Yii::$app->user->isGuest): ?>
            <?= Html::a('+ Add Author', ['create'], ['class' => 'btn btn-success']) ?>
        <?php endif; ?>
    </div>

    <?php if (empty($authors)): ?>
        <p class="text-muted">No authors yet.</p>
    <?php else: ?>
        <div class="row">
            <?php foreach ($authors as $author): ?>
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><?= Html::encode($author->full_name) ?></h5>
                        <p class="card-text"><?= count($author->books) ?> book(s)</p>
                        <div style="display:flex;gap:6px;flex-wrap:wrap;">
                            <?= Html::a('View', ['view', 'id' => $author->id], ['class' => 'btn btn-primary btn-sm']) ?>
                            <?php if (!Yii::$app->user->isGuest): ?>
                                <?= Html::a('Edit', ['update', 'id' => $author->id], ['class' => 'btn btn-warning btn-sm']) ?>
                                <?= Html::a('Delete', ['delete', 'id' => $author->id], [
                                    'class' => 'btn btn-danger btn-sm',
                                    'data'  => ['confirm' => 'Delete this author?', 'method' => 'post'],
                                ]) ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>
