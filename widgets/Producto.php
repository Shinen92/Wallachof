<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\widgets;
use Yii;
use yii\helpers\Url;

/**
 * Description of Producto
 *
 * @author Francisco
 */
class Producto extends \yii\base\Widget{
    
    public $modelo;
    private $salida;
    
    function init() {
        
        $this->salida = "<div class='producto'>"
                . (($this->modelo->vendedor->id == Yii::$app->user->identity->id) ? 
                        ("<a href='" . Url::to(['productos/marcarvendido?id=' 
                            . $this->modelo->id]) 
                        . "' class='btn btn-default'>Marcar como vendido</a>")
                        : ("")) 
                . "<h1>"
                . $this->modelo->producto
                . "</h1>"
                . "<img src='"
                . $this->modelo->getImagen()
                . "'>"
                . "<p>Vendedor: "
                . "<a href='"
                . Url::to(["mensajes/chat?chat=" . $this->modelo->vendedor->id])
                . "'>"
                . $this->modelo->vendedor->nombre
                . "</a>"
                . "</p>"
                . "<p>Ubicacion: "
                . $this->modelo->localizacion
                . "<p>Precio: "
                . $this->modelo->precio_oferta
                . " €</p>"
                . "<p>Descripcion: "
                . $this->modelo->descripcion;
    }
    
    function run() {
        return $this->salida;
    }
}
