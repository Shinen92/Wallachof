<?php
use yii\bootstrap\ActiveForm;

$items = [];

foreach ($usuarios as $u) {
    $items[$u->destinatario->id] = $u->destinatario->nombre;
}
?>

<div class="row">
    <div class="col-xs-12">
        <?php $form = ActiveForm::begin()?>
        <?= $form->field($model,'id_comprador')->dropDownList($items)?>
        <?= $form->field($model,'precio_compra')->textInput()?>
        <?= $form->field($model,'id')->hiddenInput(["value" => $model->id])?>   
        <?= \yii\helpers\Html::submitButton("Vender")?>
        <?php ActiveForm::end()?>
    </div>
</div>
