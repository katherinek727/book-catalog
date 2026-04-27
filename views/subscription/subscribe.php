<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;

/** @var app\models\Subscription $model */
/** @var app\models\Author[] $authors */

$this->title = 'Subscribe to Author';
?>
<div class="subscription-subscribe">
    <h1><?= Html::encode($this->title) ?></h1>
    <p>Get notified by SMS when a new book is published by your favourite author.</p>

    <?php if (Yii::$app->session->hasFlash('success')): ?>
        <div class="alert alert-success"><?= Yii::$app->session->getFlash('success') ?></div>
    <?php endif; ?>

    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'author_id')->dropDownList(
            ArrayHelper::map($authors, 'id', 'full_name'),
            ['prompt' => '-- Select Author --']
        ) ?>

        <?= $form->field($model, 'phone')->textInput([
            'placeholder' => '+79001234567',
            'maxlength'   => true,
        ]) ?>

        <div>
            <?= Html::submitButton('Subscribe', ['class' => 'btn btn-primary']) ?>
        </div>

    <?php ActiveForm::end(); ?>
</div>
