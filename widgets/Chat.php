<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\widgets;
use yii\helpers\Html;
use Yii;
use yii\helpers\Url;

/**
 * Description of Chat
 *
 * @author Francisco
 */
class Chat extends \yii\base\Widget{
    
    public $modelos;
    public $destino;
    private $salida;
    
    function init() {
        
        $this->salida .= Html::beginTag("div",["class" => "chat-widget"]);
        $this->salida .= Html::beginTag("div",["class" => "container-fluid"]);
        $this->salida .= Html::img($this->destino->getImagen());
        $this->salida .= $this->destino->nombre;
        $this->salida .= Html::endTag("div");
        $this->salida .= Html::beginTag("div");
        
        
        foreach ($this->modelos as $m) {
            $this->salida .= Html::beginTag("div",["class" => "row"]);
            $this->salida .= Html::beginTag("div",[
                "class" => 
                $m->id_destinatario !== Yii::$app->user->identity->id ?
                    "mensaje pull-right" : "mensaje pull-left"
                ]);
            $this->salida .= Html::beginTag("div");
            $this->salida .= $m->contenido;
            $this->salida .= Html::endTag("div");
            $this->salida .= Html::beginTag("div",["class" => "pull-right"]);
            $this->salida .= date($m->fecha, "H:i");
            $this->salida .= Html::endTag("div");
            $this->salida .= Html::endTag("div");
            $this->salida .= Html::endTag("div");
        }
        $this->salida .= Html::endTag("div");
        
        $this->salida .= Html::beginForm(Url::to(['mensajes/enviar']),"post");
        $this->salida .= Html::input("text","contenido","",["required" => true]);
        $this->salida .= Html::submitButton("Enviar",["class" => "btn btn-default"]);
        $this->salida .= Html::hiddenInput("id_destinatario", $this->destino->id);
        $this->salida .= Html::hiddenInput("id_origen", Yii::$app->user->identity->id);
        $this->salida .= Html::endForm();
                
        $this->salida .= Html::endTag("div");
    }
    
    function run() {
        return $this->salida;
    }
}
