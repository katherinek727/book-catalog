<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;

/** @var app\models\Book $model */
/** @var app\models\Author[] $authors */
/** @var int[] $selectedAuthorIds */

$selectedAuthorIds = $selectedAuthorIds ?? [];
?>
<div class="book-form card" style="max-width:680px;">
    <div class="card-body">
        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

            <?= $form->field($model, 'title')->textInput(['maxlength' => true, 'placeholder' => 'Book title']) ?>

            <div class="row">
                <div class="col-md-4">
                    <?= $form->field($model, 'year')->textInput(['type' => 'number', 'min' => 1000, 'max' => date('Y')]) ?>
                </div>
                <div class="col-md-4" style="width:50%;">
                    <?= $form->field($model, 'isbn')->textInput(['maxlength' => true, 'placeholder' => 'e.g. 978-3-16-148410-0']) ?>
                </div>
            </div>

            <?= $form->field($model, 'description')->textarea(['rows' => 4, 'placeholder' => 'Short description...']) ?>

            <?= $form->field($model, 'coverFile')->fileInput()->label('Cover Image (jpg/png, max 2MB)') ?>

            <?php if ($model->cover_image): ?>
                <div style="margin-bottom:12px;">
                    <img src="<?= Yii::$app->request->baseUrl ?>/uploads/covers/<?= Html::encode($model->cover_image) ?>"
                         style="height:80px;border-radius:4px;" alt="Current cover">
                    <small class="form-text">Current cover — upload a new file to replace it.</small>
                </div>
            <?php endif; ?>

            <div class="form-group">
                <?= Html::label('Authors', 'author_ids', ['class' => 'control-label']) ?>
                <?= Html::listBox('author_ids[]', $selectedAuthorIds,
                    ArrayHelper::map($authors, 'id', 'full_name'),
                    ['multiple' => true, 'class' => 'form-control', 'size' => 6, 'id' => 'author_ids']
                ) ?>
                <span class="form-text">Hold Ctrl / Cmd to select multiple authors.</span>
            </div>

            <div style="display:flex;gap:8px;margin-top:16px;">
                <?= Html::submitButton($model->isNewRecord ? 'Create Book' : 'Save Changes', ['class' => 'btn btn-primary']) ?>
                <?= Html::a('Cancel', ['index'], ['class' => 'btn btn-secondary']) ?>
            </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>
