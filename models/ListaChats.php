<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\models;

/**
 * Description of ListaChats
 *
 * @author Francisco
 */
class ListaChats extends Mensajes{
    public $nombre;
    public $i;
    
    public function getImagen() {
        return Usuarios::findOne($this->i)->getImagen();
    }
}