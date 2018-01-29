
<?php 
    use yii\helpers\Html;
    
    
    
    
    
?>

<div class="col-xs-12 col-md-6 col-md-offset-3">
    <div class="buscar">
        <input type="text" name="buscar" class="valor">
        <button type="button" class="btn btn-default">Buscar</button>
    </div>
    <div class="resultados">
        
    </div>

    <?php
        $this->registerJs(
                "$('button[type=button]').on('click', ()=>{"
                    . "let xhttp = new XMLHttpRequest();"
                    . "xhttp.onreadystatechange = function() {"
                        . "if (this.readyState == 4 && this.status == 200) {"
                            . "$('.resultados').html(this.responseText)"
                        . "}"
                    . "};"
                    . "xhttp.open('get', '" 
                        . \yii\helpers\Url::to(['mensajes/buscarajax']) 
                    . "?buscar=' + $('.valor')[0].value, true);"
                    . "xhttp.send();"
                . "})"
                );
    ?>
</div>