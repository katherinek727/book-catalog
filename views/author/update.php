<?php

use yii\helpers\Html;

$this->title = 'Edit Author';
?>
<div class="page-header">
    <h1>Edit Author</h1>
    <?= Html::a('← Back', ['view', 'id' => $model->id], ['class' => 'btn btn-ghost btn-sm']) ?>
</div>
<?= $this->render('_form', ['model' => $model]) ?>
