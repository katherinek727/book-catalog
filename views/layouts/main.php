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
    <title><?= Html::encode($this->title) ?> — <?= Html::encode(Yii::$app->name) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<nav class="navbar">
    <div class="navbar-brand">
        <?= Html::a(Html::encode(Yii::$app->name), ['/site/index']) ?>
    </div>
    <ul class="navbar-nav">
        <li><?= Html::a('Books', ['/book/index']) ?></li>
        <li><?= Html::a('Authors', ['/author/index']) ?></li>
        <li><?= Html::a('Subscribe', ['/subscription/subscribe']) ?></li>
        <li><?= Html::a('Report', ['/report/index']) ?></li>
    </ul>
    <div class="navbar-auth">
        <?php if (Yii::$app->user->isGuest): ?>
            <?= Html::a('Login', ['/site/login'], ['class' => 'btn-login']) ?>
        <?php else: ?>
            <span class="navbar-user"><?= Html::encode(Yii::$app->user->identity->username) ?></span>
            <?= Html::beginForm(['/site/logout'], 'post', ['class' => 'logout-form']) ?>
                <?= Html::submitButton('Logout', ['class' => 'btn-logout']) ?>
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
        <p>&copy; <?= date('Y') ?> <?= Html::encode(Yii::$app->name) ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
