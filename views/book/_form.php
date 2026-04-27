<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var app\models\Book $model */
/** @var app\models\Author[] $authors */
/** @var int[] $selectedAuthorIds */

$selectedAuthorIds = $selectedAuthorIds ?? [];
?>
<div class="book-form">
    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

        <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'year')->textInput(['type' => 'number']) ?>
        <?= $form->field($model, 'isbn')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'description')->textarea(['rows' => 4]) ?>
        <?= $form->field($model, 'coverFile')->fileInput() ?>

        <div class="form-group">
            <?= Html::label('Authors', 'author_ids', ['class' => 'control-label']) ?>
            <?= Html::listBox('author_ids[]', $selectedAuthorIds,
                \yii\helpers\ArrayHelper::map($authors, 'id', 'full_name'),
                ['multiple' => true, 'class' => 'form-control', 'size' => 6]
            ) ?>
            <small class="form-text text-muted">Hold Ctrl / Cmd to select multiple authors.</small>
        </div>

        <div>
            <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => 'btn btn-primary']) ?>
            <?= Html::a('Cancel', ['index'], ['class' => 'btn btn-secondary']) ?>
        </div>

    <?php ActiveForm::end(); ?>
</div>
