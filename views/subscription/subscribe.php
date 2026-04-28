<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;

/** @var app\models\Subscription $model */
/** @var app\models\Author[] $authors */

$this->title = 'Subscribe to Author';
?>
<div class="subscription-subscribe" style="max-width:520px;">
    <h1><?= Html::encode($this->title) ?></h1>
    <p class="text-muted" style="margin-bottom:24px;">
        Enter your phone number and choose an author — we'll SMS you when a new book is published.
    </p>

    <?php if (Yii::$app->session->hasFlash('success')): ?>
        <div class="alert alert-success"><?= Html::encode(Yii::$app->session->getFlash('success')) ?></div>
    <?php endif; ?>

    <div class="card">
        <div class="card-body">
            <?php $form = ActiveForm::begin(); ?>

                <?= $form->field($model, 'author_id')->dropDownList(
                    ArrayHelper::map($authors, 'id', 'full_name'),
                    ['prompt' => '— Select Author —']
                )->label('Author') ?>

                <?= $form->field($model, 'phone')->textInput([
                    'placeholder' => '+79001234567',
                    'maxlength'   => true,
                    'type'        => 'tel',
                ])->label('Phone Number') ?>

                <div style="margin-top:16px;">
                    <?= Html::submitButton('Subscribe', ['class' => 'btn btn-primary']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
