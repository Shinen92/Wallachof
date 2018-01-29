<?php
    $this->registerCssFile("@web/css/productos.css");
?>

<div class="row">
    <div class="col-xs-12 panel-productos">
        <?=
            \yii\grid\GridView::widget([
                'dataProvider' => $lista,
                'summary' => '',
                'showHeader' => false,
                'columns' => [
                    [
                        'attribute' => 'producto',
                        'value' => function ($data) {
                            return "<a href='" 
                                    . yii\helpers\Url::to(['productos/vendido']) 
                                    . "?id="
                                    . $data->id
                                    . "'>"
                                    . "<img src='"
                                    . $data->getImagen()
                                    . "'> "
                                    . $data->producto
                                    . "<div class='pull-right fecha'>"
                                    . $data->fecha_compra
                                    . "</div>"
                                    . "</a>";
                        },
                        'format' => 'raw'
                    ]
                ]
            ]);
        ?>
    </div>