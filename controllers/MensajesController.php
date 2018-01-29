<?php

namespace app\controllers;
use app\models\Mensajes;
use yii\data\ActiveDataProvider;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;

class MensajesController extends \yii\web\Controller
{
    
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => [''],
                'rules' => [
                    [
                        'actions' => ['*'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['*'],
                        'allow' => true,
                        'roles' => ['?']
                    ]
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'enviar' => ['post'],
                ],
            ],
        ];
    }
    
    
    public function actionChat($chat=false)
    {
        
        if (!$chat) {
            return $this->actionIndex();
        }
        
        $lista = $this->listaChat();
        
        $consulta = Mensajes::find()
                            ->where(
                                    "id_destinatario = '" . Yii::$app->user->identity->id . "' AND "
                                    . "id_origen = '$chat'"
                                    )
                            ->orWhere(
                                    "id_destinatario = '$chat' AND "
                                    . "id_origen = '" . Yii::$app->user->identity->id . "'"
                                    )
                            ->select(['contenido','fecha','id_destinatario'])
                            ->with('destinatario')
                            ->orderBy("fecha")->all();
        
        return $this->render('chat',[
            'lista' => $lista,
            'chat' => $consulta,
            'destino' => \app\models\Usuarios::findOne($chat)
        ]);
    }

    public function actionEnviar()
    {

        $modelo = new Mensajes();
        $modelo->attributes = Yii::$app->request->post();
        if ($modelo->save()) {
            return $this->actionChat(Yii::$app->request->post()['id_destinatario']);
        }
        else {
            echo 'algo salio mal';
        } 
    }

    public function actionIndex()
    {
        $lista = $this->listaChat();
        
        return $this->render('index',[
            'lista' => $lista,
            'chat' => '',
        ]);
    }
    
    public function actionListar(){
        $lista = $this->listaChat();
        
        return $this->render('listar',[
            'lista' => $lista
        ]);
        
    }
    
    public function actionBuscar($nombre = false) {

        $modelo = new \app\models\Usuarios();
        return $this->render('buscar',[
            'modelo' => $modelo
        ]);
    }
    
    public function actionBuscarajax($buscar) {
        $modelos = \app\models\Usuarios::find()
                ->where("nombre LIKE '%$buscar%'")
                ->orWhere("login LIKE '%$buscar%'")
                ->select(['nombre','id','login'])->all();
        
        $salida = "<ul>";
        
        foreach ($modelos as $m) {
            $salida .= "<li><a href='" 
                    . \yii\helpers\Url::to(['/mensajes/chat']) 
                    . "?chat=$m->id'>" . $m->nombre . " - (" . $m->login . ")</a></li>"; 
        }
        
        $salida .= "</ul>";
        
        echo $salida;
    }
    
    private function listaChat() {
        $id = Yii::$app->user->identity->id;
        return new ActiveDataProvider([
            'query' => \app\models\ListaChats::findBySql(
                    "SELECT i , c3.fecha fecha, c3.contenido contenido, u.nombre nombre, u.avatar avatar FROM (
    SELECT i, c2.fecha, contenido FROM (SELECT c1.i,MAX(fecha) fecha FROM (
        SELECT id_origen i, fecha FROM mensajes WHERE id_destinatario = $id 
        UNION 
        SELECT id_destinatario i,fecha FROM mensajes WHERE id_origen = $id
    ) c1 GROUP BY c1.i
    )c2 JOIN mensajes ON (c2.i = id_origen OR c2.i = id_destinatario) AND (c2.fecha = mensajes.fecha)
  ) c3 JOIN usuarios u ON (c3.i = u.id)")
        ]);
    }


}
