<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Iniciar Sesion';
?>
<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin([
        'id' => 'producto-form',
        'layout' => 'horizontal',
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-6\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-2 control-label'],
        ],
    ]); 
    
    $items = [];
    
    foreach ($categorias as $c) {
        $items[$c->categoria] = ucfirst($c->categoria);
    }
    
    ?>

        <?= $form->field($modelo, 'producto')->textInput(['autofocus' => true]) ?>

        <?= $form->field($modelo, 'foto')->fileInput(['accept' => 'image/*']) ?>
    
        <?= $form->field($modelo, 'precio_oferta')->textInput() ?>
    
        <?= $form->field($modelo, 'localizacion')->textInput() ?>
        
        <?= $form->field($modelo, 'categoria')->dropDownList($items) ?>
    
        <?= $form->field($modelo, 'descripcion')->textarea() ?>
    
        <?= $form->field($modelo, 'id_vendedor')
            ->hiddenInput(['value' => Yii::$app->user->identity->id]) ?>

        <div class="form-group">
            <div class="col-lg-offset-1 col-lg-11">
                <?= Html::submitButton('Publicar', ['class' => 'btn btn-primary', 'name' => 'publicar']) ?>
            </div>
        </div>

    <?php ActiveForm::end(); ?>

</div>
