<?php

use yii\helpers\Html;

$this->title = $book->title;
?>

<div style="margin-bottom:12px;">
    <?= Html::a('← Catalog', ['index'], ['class' => 'btn btn-ghost btn-sm']) ?>
</div>

<div class="row">
    <div class="col-md-3">
        <?php if ($book->cover_image): ?>
            <img src="<?= Yii::$app->request->baseUrl ?>/uploads/covers/<?= Html::encode($book->cover_image) ?>"
                 class="cover-img" alt="<?= Html::encode($book->title) ?>">
        <?php else: ?>
            <div class="cover-placeholder">
                <span style="font-size:2.5rem;opacity:.4;">📖</span>
                <span>No Cover</span>
            </div>
        <?php endif; ?>
    </div>

    <div class="col-md-9">
        <h1 style="margin-bottom:20px;"><?= Html::encode($book->title) ?></h1>

        <div class="detail-meta">
            <div class="detail-meta-row">
                <span class="detail-meta-label">Year</span>
                <span class="detail-meta-value">
                    <span class="badge badge-muted"><?= $book->year ?></span>
                </span>
            </div>
            <?php if ($book->isbn): ?>
            <div class="detail-meta-row">
                <span class="detail-meta-label">ISBN</span>
                <span class="detail-meta-value" style="font-family:var(--font-mono);font-size:.88rem;color:var(--ink-3);">
                    <?= Html::encode($book->isbn) ?>
                </span>
            </div>
            <?php endif; ?>
            <?php if ($book->authors): ?>
            <div class="detail-meta-row">
                <span class="detail-meta-label">Authors</span>
                <span class="detail-meta-value">
                    <?php foreach ($book->authors as $i => $author): ?>
                        <?= $i > 0 ? '<span style="color:var(--ink-4);margin:0 4px;">·</span>' : '' ?>
                        <?= Html::a(Html::encode($author->full_name), ['/author/view', 'id' => $author->id]) ?>
                    <?php endforeach; ?>
                </span>
            </div>
            <?php endif; ?>
        </div>

        <?php if ($book->description): ?>
            <hr class="divider">
            <p style="color:var(--ink-3);line-height:1.85;font-size:.95rem;">
                <?= nl2br(Html::encode($book->description)) ?>
            </p>
        <?php endif; ?>

        <?php if (!Yii::$app->user->isGuest): ?>
            <div class="d-flex gap-2 flex-wrap" style="margin-top:32px;">
                <?= Html::a('Edit', ['update', 'id' => $book->id], ['class' => 'btn btn-secondary btn-sm']) ?>
                <?= Html::a('Delete', ['delete', 'id' => $book->id], [
                    'class' => 'btn btn-danger btn-sm',
                    'data'  => ['confirm' => 'Delete "' . Html::encode($book->title) . '"?', 'method' => 'post'],
                ]) ?>
            </div>
        <?php endif; ?>
    </div>
</div>
