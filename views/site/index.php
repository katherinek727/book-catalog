<?php

use yii\helpers\Html;
use app\models\Book;
use app\models\Author;

$this->title = 'Home';

$bookCount   = Book::find()->count();
$authorCount = Author::find()->count();
$recent      = Book::find()->orderBy(['created_at' => SORT_DESC])->limit(4)->all();
?>

<div class="hero">
    <div class="hero-eyebrow">Book Catalog</div>
    <h1>Discover <em>Books</em> &amp;<br>Their Authors</h1>
    <p>Browse our curated collection, explore authors, and subscribe to receive notifications when new titles are published.</p>
    <div class="hero-actions">
        <?= Html::a('Browse Catalog', ['/book/index'], ['class' => 'btn btn-primary btn-lg']) ?>
        <?= Html::a('View Authors', ['/author/index'], ['class' => 'btn btn-ghost btn-lg']) ?>
    </div>
</div>

<div class="stats-bar">
    <div class="stat-item">
        <div class="stat-item-value"><?= $bookCount ?></div>
        <div class="stat-item-label">Books</div>
    </div>
    <div class="stat-item">
        <div class="stat-item-value"><?= $authorCount ?></div>
        <div class="stat-item-label">Authors</div>
    </div>
    <div class="stat-item">
        <div class="stat-item-value"><?= date('Y') ?></div>
        <div class="stat-item-label">Current Year</div>
    </div>
</div>

<?php if ($recent): ?>
<div class="section-header">
    <h2>Recently Added</h2>
    <?= Html::a('View all →', ['/book/index'], ['class' => 'btn btn-ghost btn-sm']) ?>
</div>

<div class="row">
    <?php foreach ($recent as $book): ?>
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
<?php endif; ?>
