<?php

namespace app\controllers;
use app\models\Productos;
use yii\data\ActiveDataProvider;
use Yii;
use yii\web\UploadedFile;

class ProductosController extends \yii\web\Controller
{
    public function actionCompra($id = false)
    {
        $lista = $this->listaCompra();
        
        if ($id) {
            $modelo = Productos::findOne($id);
        }
        else {
            $modelo = false;
        }
        
        
        return $this->render('compra',[
            'lista' => $lista,
            'modelo' => $modelo
        ]);
    }

    public function actionVenta($id = false)
    {
        $lista = $this->listaVenta();
        
        if ($id) {
            $modelo = Productos::findOne($id);
        }
        else {
            $modelo = false;
        }
        
        return $this->render('venta',[
            'lista' => $lista,
            'modelo' => $modelo
        ]);
    }
    
    public function actionVendido($id = false) {
        $lista = $this->listaVendido();
        
        if ($id) {
            $modelo = Productos::find()->where(["id" => $id])->with("vendedor")->one();
        }
        else {
            $modelo = false;
        }
        
        return $this->render('vendido',[
            'lista' => $lista,
            'modelo' => $modelo
        ]);
    }
    
    public function actionMarcarvendido($id = false) {
        $id_usuario = Yii::$app->user->identity->id;
        $model = Productos::findOne($id);
        $usuarios = \app\models\Mensajes::find()
                ->select(['id_destinatario'])
                ->orWhere(["id_origen" => $id_usuario])
                ->with('destinatario')->distinct("id_destinatario")->all();
        
        if ($model->fecha_compra != null) {
            return $this->actionIndex($id);
        }
        
        if (isset(Yii::$app->request->post()['Productos']['id_comprador'])) {
            $model->load(Yii::$app->request->post());
            $model->fecha_compra = date();
            $model->save(false);
            return $this->actionIndex($id);
        }
        
        return $this->render('marcarvendido',[
            'model' => $model,
            'usuarios' => $usuarios
        ]);
    }
    
    public function actionIndex($id = false) {
        $lista = $this->listaTodoVenta();
        
        if ($id) {
            $modelo = Productos::findOne($id);
        }
        else {
            $modelo = false;
        }
        
        return $this->render('index',[
            'lista' => $lista,
            'modelo' => $modelo
        ]);
    }
    
    public function actionNuevo() {
        
        $model = new Productos();
        
        if ($model->load(Yii::$app->request->post())) {
            $model->foto = UploadedFile::getInstance($model,'foto');
            if ($model->save() && $model->upload()) {
                return $this->actionVenta($model->id);
            }
        }
        
        return $this->render('nuevo',[
            'modelo' => $model,
            'categorias' => \app\models\Categorias::find()->all()
        ]);
    }
    
    public function actionListarvendido() {
        $lista = $this->listaVendido();
        
        return $this->render('listar',[
            'lista' => $lista
        ]);
    }
    
    public function actionListarventa() {
        $lista = $this->listaVenta();
        
        return $this->render('listar',[
            'lista' => $lista
        ]);
    }
    
    public function actionListarcompra() {
        $lista = $this->listaCompra();
        
        return $this->render('listar',[
            'lista' => $lista
        ]);
    }
    
    private function listaTodoVenta() {
        return new ActiveDataProvider([
            'query' => Productos::find()->where('fecha_compra IS NULL')
                     ->select(['fecha_oferta','producto','foto','id'])
        ]);
    }
    
    private function listaCompra() {
        return new ActiveDataProvider([
            'query' => Productos::find()
                    ->where("id_comprador = '" 
                        . Yii::$app->user->identity->id 
                        . "'")
                    ->select(['fecha_compra','producto','foto','id'])
        ]);
    }
    
    private function listaVenta() {
        return new ActiveDataProvider([
            'query' => Productos::find()
                    ->where("id_vendedor = '" 
                        . Yii::$app->user->identity->id 
                        . "'")
                    ->andWhere('fecha_compra IS NULL')
                    ->select(['fecha_oferta','producto','foto','id'])
        ]);
    }
    
    private function listaVendido() {
        return new ActiveDataProvider([
            'query' => Productos::find()
                    ->where("id_vendedor = '" 
                        . Yii::$app->user->identity->id 
                        . "'")
                    ->andWhere("fecha_compra IS NOT NULL")
                    ->select(['fecha_compra','producto','foto','id'])
        ]);
    }
}
