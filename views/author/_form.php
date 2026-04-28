<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>
<div class="form-card">
    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'full_name')->textInput([
            'maxlength'   => true,
            'placeholder' => 'e.g. Fyodor Dostoevsky',
            'autofocus'   => true,
        ])->label('Full Name') ?>

        <div class="d-flex gap-2" style="margin-top:28px;">
            <?= Html::submitButton(
                $model->isNewRecord ? 'Create Author' : 'Save Changes',
                ['class' => 'btn btn-primary']
            ) ?>
            <?= Html::a('Cancel', ['index'], ['class' => 'btn btn-ghost']) ?>
        </div>

    <?php ActiveForm::end(); ?>
</div>
