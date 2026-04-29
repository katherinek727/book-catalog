<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Authors';

// Collect any edit model passed from controller (for validation errors)
$editModel  = $editModel  ?? null;
$createModel = $createModel ?? new \app\models\Author();
?>

<!-- ===== Modal Overlay ===== -->
<div class="modal-overlay" id="authorModal" onclick="closeAuthorModal(event)">
    <div class="modal-box" role="dialog" aria-modal="true">
        <div class="modal-header">
            <div>
                <h2 class="modal-title" id="modalTitle">New Author</h2>
                <p class="modal-subtitle" id="modalSubtitle">Add a new author to the catalog</p>
            </div>
            <button class="modal-close" onclick="closeModal()" aria-label="Close">
                <svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="2" width="14" height="14">
                    <path d="M2 2l12 12M14 2L2 14"/>
                </svg>
            </button>
        </div>
        <div class="modal-body" id="modalBody"></div>
        <div class="modal-footer" id="modalFooter"></div>
    </div>
</div>

<!-- ===== Page Header ===== -->
<div class="page-header">
    <div>
        <h1 class="page-title">Authors</h1>
        <p style="color:var(--ink-4);font-size:.9rem;margin-top:4px;"><?= count($authors) ?> author<?= count($authors) !== 1 ? 's' : '' ?> in the catalog</p>
    </div>
    <div style="display:flex;flex-direction:column;align-items:flex-end;gap:10px;">
        <?php if (!Yii::$app->user->isGuest): ?>
            <button class="btn btn-primary" onclick="openCreateModal()">+ New Author</button>
        <?php endif; ?>
        <div class="view-toggle" id="authorViewToggle">
            <button class="view-toggle-btn active" data-view="grid" title="Grid view">
                <svg viewBox="0 0 16 16" fill="currentColor"><path d="M1 1h6v6H1V1zm8 0h6v6H9V1zM1 9h6v6H1V9zm8 0h6v6H9V9z"/></svg>
            </button>
            <button class="view-toggle-btn" data-view="list" title="List view">
                <svg viewBox="0 0 16 16" fill="currentColor"><path d="M1 2h14v2H1V2zm0 5h14v2H1V7zm0 5h14v2H1v-2z"/></svg>
            </button>
        </div>
    </div>
</div>

<!-- ===== Author List ===== -->
<?php if (empty($authors)): ?>
    <div class="empty-state">
        <div class="empty-state-icon">✍️</div>
        <h3>No authors yet</h3>
        <p>Add the first author to get started.</p>
        <?php if (!Yii::$app->user->isGuest): ?>
            <button class="btn btn-primary" onclick="openCreateModal()">Add Author</button>
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
                            <div class="d-flex gap-2 flex-wrap card-actions">
                                <?= Html::a('View', ['view', 'id' => $author->id], ['class' => 'btn btn-ghost btn-sm']) ?>
                                <?php if (!Yii::$app->user->isGuest): ?>
                                    <button class="btn btn-secondary btn-sm"
                                        onclick="openEditModal(<?= $author->id ?>, <?= Html::encode(json_encode($author->full_name)) ?>)">
                                        Edit
                                    </button>
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
var modal       = document.getElementById('authorModal');
var modalTitle  = document.getElementById('modalTitle');
var modalSub    = document.getElementById('modalSubtitle');
var modalBody   = document.getElementById('modalBody');
var modalFooter = document.getElementById('modalFooter');

function buildForm(action, nameValue, submitLabel) {
    var csrfName  = <?= json_encode(Yii::$app->request->csrfParam) ?>;
    var csrfToken = <?= json_encode(Yii::$app->request->csrfToken) ?>;

    modalBody.innerHTML =
        '<form id="authorForm" method="post" action="' + action + '">' +
        '<input type="hidden" name="' + csrfName + '" value="' + csrfToken + '">' +
        '<div class="form-group">' +
        '<label class="control-label">Full Name</label>' +
        '<input type="text" name="Author[full_name]" placeholder="e.g. Fyodor Dostoevsky"' +
        ' value="' + escHtml(nameValue) + '" required autofocus>' +
        '</div></form>';

    modalFooter.innerHTML =
        '<button type="button" class="btn btn-ghost" onclick="closeModal()">Cancel</button>' +
        '<button type="submit" form="authorForm" class="btn btn-primary">' + submitLabel + '</button>';

    setTimeout(function () {
        var inp = modalBody.querySelector('input[type=text]');
        if (inp) inp.focus();
    }, 60);
}

function openCreateModal() {
    modalTitle.textContent = 'New Author';
    modalSub.textContent   = 'Add a new author to the catalog';
    buildForm('/author/create', '', 'Create Author');
    openModal();
}

function openEditModal(id, name) {
    modalTitle.textContent = 'Edit Author';
    modalSub.textContent   = 'Update the author\'s details';
    buildForm('/author/update?id=' + id, name, 'Save Changes');
    openModal();
}

function openModal() {
    modal.classList.add('open');
    document.body.style.overflow = 'hidden';
}

function closeModal() {
    modal.classList.remove('open');
    document.body.style.overflow = '';
}

function closeAuthorModal(e) {
    if (e.target === modal) closeModal();
}

document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape') closeModal();
});

function escHtml(str) {
    return String(str)
        .replace(/&/g,'&amp;').replace(/"/g,'&quot;')
        .replace(/</g,'&lt;').replace(/>/g,'&gt;');
}

// View toggle
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
        container.classList.toggle('items-list', view === 'list');
        toggle.querySelectorAll('.view-toggle-btn').forEach(function (b) {
            b.classList.toggle('active', b.dataset.view === view);
        });
    }
}());
</script>
