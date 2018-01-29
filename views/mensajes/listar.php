<?php
    $this->registerCssFile("@web/css/mensajesIndex.css");
?>

<div class="row">
    <div class="col-xs-12">
        <?=
            \yii\grid\GridView::widget([
                'dataProvider' => $lista,
                'summary' => '',
                'showHeader' => false,
                'columns' => [
                    [
                        'attribute' => 'destinatario.origen',
                        'value' => function ($data) {
                            return "<a href='" 
                                    . yii\helpers\Url::to(['mensajes/chat']) 
                                    . "?chat="
                                    . $data->id_destinatario
                                    . "'>"
                                    . "<img src='"
                                    . $data->getImagen()
                                    . "'> "
                                    . $data->destinatario->nombre
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
</div>