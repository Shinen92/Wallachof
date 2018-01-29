<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use app\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => Yii::$app->name,
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-default navbar-fixed-top',
        ],
    ]);
    
    echo Nav::widget([
            'options' => ['class' => 'navbar-nav navbar-left'],
            'items' => [
                ['label' => 'Productos en venta', 'url' => ['/productos/index']]
            ],
    ]); 
    
    if (Yii::$app->user->isGuest) {
        
        echo Nav::widget([
            'options' => ['class' => 'navbar-nav navbar-right'],
            'items' => [
                ['label' => 'Iniciar Sesion '
                    . '<span class="glyphicon glyphicon-log-in"></span>'
                    , 'url' => ['/site/login']
                    , 'encode' => false],
                ['label' => 'Nuevo Usuario '
                    . '<span class="glyphicon glyphicon-user"></span>'
                    , 'url' => ['/site/nuevo']
                    , 'encode' => false]
            ],
        ]); 
    }
    else {
        echo Nav::widget([
            'options' => ['class' => 'navbar-nav navbar-left'],
            'items' => [
                ['label' => 'Mensajes', 'url' => ['/mensajes/index']],
                ['label' => 'En venta', 'url' => ['/productos/venta']],
                ['label' => 'Vendido', 'url' => ['/productos/vendido']],
                ['label' => 'Comprado', 'url' => ['/productos/compra']],
            ],
        ]);
        echo Nav::widget([
            'options' => ['class' => 'navbar-nav navbar-right'],
            'items' => [
                '<li>'
                . Html::beginForm(['/site/logout'], 'post')
                . Html::submitButton(
                    'Cerrar Sesion <span '
                        . 'class="glyphicon glyphicon-log-out"></span> (' 
                        . Yii::$app->user->identity->login . ')',
                    ['class' => 'btn btn-link logout']
                )
                . Html::endForm()
                . '</li>'
            ]
        ]);
    }
    NavBar::end();
    ?>

    <div class="container">
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer hidden-xs hidden-sm">
    <div class="container">
        <p class="pull-left">&copy; Wallachof <?= date('Y') ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
