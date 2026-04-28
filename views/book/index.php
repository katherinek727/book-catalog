<?php

use yii\helpers\Html;
use yii\widgets\LinkPager;

$this->title = 'Book Catalog';
?>
<div class="page-header">
    <div>
        <h1 class="page-title">Book Catalog</h1>
        <p style="color:var(--ink-4);font-size:.9rem;margin-top:4px;"><?= $pagination->totalCount ?> title<?= $pagination->totalCount !== 1 ? 's' : '' ?></p>
    </div>
    <div style="display:flex;flex-direction:column;align-items:flex-end;gap:10px;">
        <?php if (!Yii::$app->user->isGuest): ?>
            <?= Html::a('+ Add Book', ['create'], ['class' => 'btn btn-primary']) ?>
        <?php endif; ?>
        <div class="view-toggle" id="bookViewToggle">
            <button class="view-toggle-btn active" data-view="grid" title="Grid view">
                <svg viewBox="0 0 16 16" fill="currentColor"><path d="M1 1h6v6H1V1zm8 0h6v6H9V1zM1 9h6v6H1V9zm8 0h6v6H9V9z"/></svg>
            </button>
            <button class="view-toggle-btn" data-view="list" title="List view">
                <svg viewBox="0 0 16 16" fill="currentColor"><path d="M1 2h14v2H1V2zm0 5h14v2H1V7zm0 5h14v2H1v-2z"/></svg>
            </button>
        </div>
    </div>
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
    <div id="bookItems">
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
                        <div class="card-meta">
                            <div class="card-title"><?= Html::encode($book->title) ?></div>
                            <div class="card-text"><?= $book->year ?></div>
                        </div>
                        <div class="card-actions">
                            <?= Html::a('View →', ['view', 'id' => $book->id], ['class' => 'btn btn-ghost btn-sm']) ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>

    <?= LinkPager::widget(['pagination' => $pagination]) ?>
<?php endif; ?>

<script>
(function () {
    var container = document.getElementById('bookItems');
    var toggle    = document.getElementById('bookViewToggle');
    if (!container || !toggle) return;

    var saved = localStorage.getItem('bookView') || 'grid';
    applyView(saved);

    toggle.addEventListener('click', function (e) {
        var btn = e.target.closest('.view-toggle-btn');
        if (!btn) return;
        var view = btn.dataset.view;
        localStorage.setItem('bookView', view);
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
