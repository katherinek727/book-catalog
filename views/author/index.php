<?php

use yii\helpers\Html;

/** @var app\models\Author[] $authors */

$this->title = 'Authors';
?>
<div class="author-index">
    <h1><?= Html::encode($this->title) ?></h1>

    <?= Html::a('Add Author', ['create'], ['class' => 'btn btn-success mb-3']) ?>

    <div class="row">
        <?php foreach ($authors as $author): ?>
        <div class="col-md-4 mb-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title"><?= Html::encode($author->full_name) ?></h5>
                    <p class="card-text"><?= count($author->books) ?> book(s)</p>
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
        <?php endforeach; ?>
    </div>
</div>
