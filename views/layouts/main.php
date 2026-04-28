<?php

use yii\helpers\Html;
use app\assets\AppAsset;

/** @var yii\web\View $this */
/** @var string $content */

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= Html::encode($this->title) ?> · <?= Html::encode(Yii::$app->name) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<nav class="navbar">
    <div class="navbar-brand">
        <?= Html::a(
            '<svg class="brand-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>'
            . Html::encode(Yii::$app->name),
            ['/site/index']
        ) ?>
    </div>

    <ul class="navbar-nav">
        <li><?= Html::a('Catalog', ['/book/index']) ?></li>
        <li><?= Html::a('Authors', ['/author/index']) ?></li>
        <li><?= Html::a('Subscribe', ['/subscription/subscribe']) ?></li>
        <li><?= Html::a('Report', ['/report/index']) ?></li>
    </ul>

    <div class="navbar-auth">
        <?php if (Yii::$app->user->isGuest): ?>
            <?= Html::a('Sign In', ['/site/login'], ['class' => 'btn-login']) ?>
        <?php else: ?>
            <span class="navbar-user"><?= Html::encode(Yii::$app->user->identity->username) ?></span>
            <?= Html::beginForm(['/site/logout'], 'post', ['class' => 'logout-form']) ?>
                <?= Html::submitButton('Sign Out', ['class' => 'btn-logout']) ?>
            <?= Html::endForm() ?>
        <?php endif; ?>
    </div>
</nav>

<main class="main-content">
    <div class="container">

        <?php foreach (['success', 'error', 'warning', 'info'] as $type): ?>
            <?php if (Yii::$app->session->hasFlash($type)): ?>
                <div class="alert alert-<?= $type ?>">
                    <?= Html::encode(Yii::$app->session->getFlash($type)) ?>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>

        <?= $content ?>

    </div>
</main>

<footer class="site-footer">
    <div class="container">
        <?= Html::encode(Yii::$app->name) ?> &nbsp;·&nbsp; <?= date('Y') ?>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
