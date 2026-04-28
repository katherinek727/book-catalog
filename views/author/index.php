<?php

use yii\helpers\Html;

$this->title = 'Authors';
?>
<div class="page-header">
    <div>
        <h1>Authors</h1>
        <p style="color:var(--ink-4);font-size:.9rem;margin-top:4px;"><?= count($authors) ?> author<?= count($authors) !== 1 ? 's' : '' ?> in the catalog</p>
    </div>
    <div class="d-flex align-items-center gap-2">
        <div class="view-toggle" id="authorViewToggle">
            <button class="view-toggle-btn active" data-view="grid" title="Grid view">
                <svg viewBox="0 0 16 16" fill="currentColor"><path d="M1 1h6v6H1V1zm8 0h6v6H9V1zM1 9h6v6H1V9zm8 0h6v6H9V9z"/></svg>
            </button>
            <button class="view-toggle-btn" data-view="list" title="List view">
                <svg viewBox="0 0 16 16" fill="currentColor"><path d="M1 2h14v2H1V2zm0 5h14v2H1V7zm0 5h14v2H1v-2z"/></svg>
            </button>
        </div>
        <?php if (!Yii::$app->user->isGuest): ?>
            <?= Html::a('+ New Author', ['create'], ['class' => 'btn btn-primary']) ?>
        <?php endif; ?>
    </div>
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
    <div id="authorItems">
        <div class="row">
            <?php foreach ($authors as $author): ?>
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="author-card-inner">
                            <div class="d-flex align-items-center gap-3" style="flex:1;min-width:0;">
                                <div class="author-avatar">
                                    <?= mb_strtoupper(mb_substr($author->full_name, 0, 1)) ?>
                                </div>
                                <div style="min-width:0;">
                                    <div class="card-title" style="margin:0 0 4px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                                        <?= Html::encode($author->full_name) ?>
                                    </div>
                                    <span class="stat-chip"><?= count($author->books) ?> book<?= count($author->books) !== 1 ? 's' : '' ?></span>
                                </div>
                            </div>
                            <div class="d-flex gap-2 flex-wrap card-actions" style="flex-shrink:0;">
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
            </div>
            <?php endforeach; ?>
        </div>
    </div>
<?php endif; ?>

<script>
(function () {
    var container = document.getElementById('authorItems');
    var toggle    = document.getElementById('authorViewToggle');
    if (!container || !toggle) return;

    var saved = localStorage.getItem('authorView') || 'grid';
    applyView(saved);

    toggle.addEventListener('click', function (e) {
        var btn = e.target.closest('.view-toggle-btn');
        if (!btn) return;
        var view = btn.dataset.view;
        localStorage.setItem('authorView', view);
        applyView(view);
    });

    function applyView(view) {
        if (view === 'list') {
            container.classList.add('items-list');
        } else {
            container.classList.remove('items-list');
        }
        toggle.querySelectorAll('.view-toggle-btn').forEach(function (b) {
            b.classList.toggle('active', b.dataset.view === view);
        });
    }
}());
</script>
