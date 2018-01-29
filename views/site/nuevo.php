<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;


$this->title = 'Nuevo Usuario';
?>
<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin([
        'id' => 'login-form',
        'layout' => 'horizontal',
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-5\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-1 control-label'],
        ],
        //'enableAjaxValidation'=>true,
    ]); ?>

        <?= $form->field($model, 'login')->textInput([
            'autofocus' => true,
            'enableAjaxValidation' => true,
            'validateOnBlur' => true,
            ]) ?>

        <?= $form->field($model, 'contrasena')->passwordInput() ?>

        <?= $form->field($model, 'contrasena_repeat')->passwordInput() ?>
    
        <?= $form->field($model, 'nombre')->textInput() ?>
    
        <?= $form->field($model, 'email')->textInput() ?>
    
        <?= $form->field($model, 'avatar')->fileInput() ?>
        
        <?= $form->field($model, 'codigo')->widget(Captcha::className(), [
            'template' => '<div class="row"><div class="col-lg-3">{image}</div><div class="col-lg-6">{input}</div></div>',
            'imageOptions' => [
                'id' => 'my-captcha-image'
            ],
            'options' => [
                'placeholder' => 'Escribe el codigo aqui'
            ]
        ]) ?>



        <div class="form-group">
            <div class="col-lg-offset-1 col-lg-11">
                <?= Html::submitButton('Crear usuario', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
            </div>
        </div>

    <?php ActiveForm::end(); ?>

</div>