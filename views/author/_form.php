<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var app\models\Author $model */
?>
<div class="author-form card" style="max-width:520px;">
    <div class="card-body">
        <?php $form = ActiveForm::begin(); ?>

            <?= $form->field($model, 'full_name')->textInput([
                'maxlength'   => true,
                'placeholder' => 'e.g. Leo Tolstoy',
                'autofocus'   => true,
            ]) ?>

            <div style="display:flex;gap:8px;margin-top:16px;">
                <?= Html::submitButton($model->isNewRecord ? 'Create Author' : 'Save Changes', ['class' => 'btn btn-primary']) ?>
                <?= Html::a('Cancel', ['index'], ['class' => 'btn btn-secondary']) ?>
            </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>
