<?php

use yii\helpers\Html;

$this->title = 'Edit Book';
?>
<div class="page-header">
    <h1>Edit Book</h1>
    <?= Html::a('← Back', ['view', 'id' => $model->id], ['class' => 'btn btn-ghost btn-sm']) ?>
</div>
<?= $this->render('_form', ['model' => $model, 'authors' => $authors, 'selectedAuthorIds' => $selectedAuthorIds]) ?>
