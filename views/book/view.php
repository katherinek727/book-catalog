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
                     class="img-fluid rounded" alt="<?= Html::encode($book->title) ?>"
                     style="width:100%;box-shadow:0 4px 12px rgba(0,0,0,.15);">
            <?php else: ?>
                <div style="height:280px;background:#e9ecef;border-radius:8px;display:flex;align-items:center;justify-content:center;color:#aaa;">
                    No Cover
                </div>
            <?php endif; ?>
        </div>

        <div class="col-md-9">
            <h1><?= Html::encode($book->title) ?></h1>

            <table style="margin-bottom:16px;border-collapse:collapse;">
                <tr>
                    <td style="padding:4px 16px 4px 0;color:#6c757d;font-weight:600;">Year</td>
                    <td><?= $book->year ?></td>
                </tr>
                <?php if ($book->isbn): ?>
                <tr>
                    <td style="padding:4px 16px 4px 0;color:#6c757d;font-weight:600;">ISBN</td>
                    <td><?= Html::encode($book->isbn) ?></td>
                </tr>
                <?php endif; ?>
                <?php if ($book->authors): ?>
                <tr>
                    <td style="padding:4px 16px 4px 0;color:#6c757d;font-weight:600;vertical-align:top;">Authors</td>
                    <td>
                        <?php foreach ($book->authors as $i => $author): ?>
                            <?= ($i > 0 ? ', ' : '') . Html::a(Html::encode($author->full_name), ['/author/view', 'id' => $author->id]) ?>
                        <?php endforeach; ?>
                    </td>
                </tr>
                <?php endif; ?>
            </table>

            <?php if ($book->description): ?>
                <p style="line-height:1.7;color:#444;"><?= nl2br(Html::encode($book->description)) ?></p>
            <?php endif; ?>

            <div style="display:flex;gap:8px;margin-top:20px;flex-wrap:wrap;">
                <?php if (!Yii::$app->user->isGuest): ?>
                    <?= Html::a('Edit', ['update', 'id' => $book->id], ['class' => 'btn btn-warning']) ?>
                    <?= Html::a('Delete', ['delete', 'id' => $book->id], [
                        'class' => 'btn btn-danger',
                        'data'  => ['confirm' => 'Delete this book?', 'method' => 'post'],
                    ]) ?>
                <?php endif; ?>
                <?= Html::a('← Back', ['index'], ['class' => 'btn btn-secondary']) ?>
            </div>
        </div>
    </div>
</div>
