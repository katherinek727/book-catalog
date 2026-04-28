<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;

$selectedAuthorIds = $selectedAuthorIds ?? [];
?>
<div class="form-card">
    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

        <?= $form->field($model, 'title')->textInput([
            'maxlength'   => true,
            'placeholder' => 'Book title',
            'autofocus'   => true,
        ])->label('Title') ?>

        <div class="form-row">
            <div class="form-group">
                <?= $form->field($model, 'year')->textInput([
                    'type' => 'number', 'min' => 1000, 'max' => date('Y'),
                    'placeholder' => date('Y'),
                ])->label('Year') ?>
            </div>
            <div class="form-group">
                <?= $form->field($model, 'isbn')->textInput([
                    'maxlength' => true, 'placeholder' => '978-x-xxx-xxxxx-x',
                ])->label('ISBN') ?>
            </div>
        </div>

        <?= $form->field($model, 'description')->textarea([
            'rows' => 4, 'placeholder' => 'A brief description...',
        ])->label('Description') ?>

        <div class="form-group">
            <?= $form->field($model, 'coverFile')->fileInput()->label('Cover Image') ?>
            <?php if ($model->cover_image): ?>
                <div style="margin-top:10px;display:flex;align-items:center;gap:12px;">
                    <img src="<?= Yii::$app->request->baseUrl ?>/uploads/covers/<?= Html::encode($model->cover_image) ?>"
                         style="height:60px;border-radius:6px;border:1px solid var(--border);" alt="Current cover">
                    <span class="form-text">Upload a new file to replace the current cover.</span>
                </div>
            <?php endif; ?>
        </div>

        <div class="form-group">
            <?= Html::label('Authors', 'author_ids', ['class' => 'control-label']) ?>
            <?= Html::listBox('author_ids[]', $selectedAuthorIds,
                ArrayHelper::map($authors, 'id', 'full_name'),
                ['multiple' => true, 'id' => 'author_ids', 'size' => min(6, max(3, count($authors)))]
            ) ?>
            <span class="form-text">Hold Ctrl / ⌘ to select multiple authors.</span>
        </div>

        <div class="d-flex gap-2" style="margin-top:28px;">
            <?= Html::submitButton(
                $model->isNewRecord ? 'Create Book' : 'Save Changes',
                ['class' => 'btn btn-primary']
            ) ?>
            <?= Html::a('Cancel', ['index'], ['class' => 'btn btn-ghost']) ?>
        </div>

    <?php ActiveForm::end(); ?>
</div>
