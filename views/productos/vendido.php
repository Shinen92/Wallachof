<?php
    use yii\helpers\Url;
    use yii\grid\GridView;
    use app\widgets\Producto;
    
    $this->registerCssFile("@web/css/productos.css");
?>
<div class="row hidden-md hidden-lg">
    <div class="col-xs-12">
        <a href="<?= Url::to(['productos/listarvendido'])?>" class="pull-right btn btn-sm btn-default">
            <span class="glyphicon glyphicon-bookmark"></span>
        </a>
    </div>
</div>
<div class="row">
    <div class="col-md-3 hidden-xs hidden-sm panel-productos">
        <?= yii\helpers\Html::a('Nuevo producto',Url::to(['/productos/nuevo'])
                ,['class' => 'btn btn-primary'])?>
        <?=
            GridView::widget([
                'dataProvider' => $lista,
                'summary' => '',
                'showHeader' => false,
                'columns' => [
                    [
                        'attribute' => 'producto',
                        'value' => function ($data) {
                            return "<a href='" 
                                    . Url::to(['productos/vendido']) 
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
    <div class="col-md-9 col-xs-12 panel-principal">
        <?php
            if ($modelo) {
                echo Producto::widget([
                    'modelo' => $modelo
                ]);
            }
        ?>
    </div>
</div>