<?php
    use yii\helpers\Url;
    use yii\grid\GridView;
    
    $this->registerCssFile("@web/css/mensajesIndex.css");
?>
<div class="row hidden-md hidden-lg cambiar-usuario">
    <div class="col-xs-12">
        <a href="<?= Url::to(['mensajes/listar'])?>" class="pull-right btn btn-sm btn-default">
            <span class="glyphicon glyphicon-bookmark"></span>
        </a>
    </div>
</div>
<div class="row">
    <div class="col-md-3 hidden-xs hidden-sm">
        <div class="cambiar-usuario">
            <a href="<?= Url::to(['mensajes/buscar'])?>" class="btn btn-sm btn-default">
                <span class="glyphicon glyphicon-new-window"></span>
            </a>
        </div>
        <?=
            GridView::widget([
                'dataProvider' => $lista,
                'summary' => '',
                'showHeader' => false,
                'columns' => [
                    [
                        'attribute' => 'destinatario.origen',
                        'value' => function ($data) {
                            return "<a href='" 
                                    . Url::to(['mensajes/chat']) 
                                    . "?chat="
                                    . $data->i
                                    . "'>"
                                    . $data->getImagen()
                                    . $data->nombre
                                    . "<div class='pull-right fecha'>"
                                    . $data->fecha
                                    . "</div>"
                                    . "</a>";
                        },
                        'format' => 'raw'
                    ]
                ]
            ]);
        ?>
    </div>
    <div class="col-md-9 col-xs-12">
        <?= $chat?>
    </div>
</div>
