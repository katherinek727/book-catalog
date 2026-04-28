<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Sign In';
?>
<div class="auth-wrap">
    <div class="auth-card">
        <div class="hero-eyebrow" style="margin-bottom:16px;">Book Catalog</div>
        <h1>Welcome back</h1>
        <p class="auth-sub">Sign in to manage the catalog.</p>

        <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

            <?= $form->field($model, 'username')->textInput([
                'autofocus'   => true,
                'placeholder' => 'Username',
            ])->label('Username') ?>

            <?= $form->field($model, 'password')->passwordInput([
                'placeholder' => '••••••••',
            ])->label('Password') ?>

            <?= $form->field($model, 'rememberMe')->checkbox()->label('Keep me signed in') ?>

            <div style="margin-top:28px;">
                <?= Html::submitButton('Sign In', ['class' => 'btn btn-primary', 'style' => 'width:100%;justify-content:center;']) ?>
            </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>
