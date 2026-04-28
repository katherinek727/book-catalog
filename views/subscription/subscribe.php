<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;

$this->title = 'Subscribe';
?>
<div class="page-header">
    <div>
        <h1>Subscribe to an Author</h1>
        <p style="color:var(--ink-4);font-size:.9rem;margin-top:4px;">Receive an SMS when a new book is published.</p>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="form-card">
            <?php $form = ActiveForm::begin(); ?>

                <?= $form->field($model, 'author_id')->dropDownList(
                    ArrayHelper::map($authors, 'id', 'full_name'),
                    ['prompt' => '— Select an author —']
                )->label('Author') ?>

                <?= $form->field($model, 'phone')->textInput([
                    'type' => 'tel', 'placeholder' => '+7 900 123 4567', 'maxlength' => true,
                ])->label('Phone Number') ?>

                <div style="margin-top:28px;">
                    <?= Html::submitButton('Subscribe', ['class' => 'btn btn-primary']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card" style="margin-top:0;background:var(--gold-pale);border-color:var(--gold-border);">
            <div class="card-body">
                <div style="font-size:1.6rem;margin-bottom:12px;">📱</div>
                <div class="card-title" style="font-size:1rem;">How it works</div>
                <p style="font-size:.85rem;color:var(--ink-3);line-height:1.75;margin:0;">
                    When a new book is added by your chosen author, you'll receive an SMS notification. No account required.
                </p>
            </div>
        </div>
    </div>
</div>
