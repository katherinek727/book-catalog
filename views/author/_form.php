<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var app\models\Author $model */
?>
<div class="author-form">
    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'full_name')->textInput(['maxlength' => true]) ?>

        <div>
            <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => 'btn btn-primary']) ?>
            <?= Html::a('Cancel', ['index'], ['class' => 'btn btn-secondary']) ?>
        </div>

    <?php ActiveForm::end(); ?>
</div>
