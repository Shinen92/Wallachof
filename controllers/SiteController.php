<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use yii\helpers\Html;
use yii\web\UploadedFile;

class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index','logout'],
                'rules' => [
                    [
                        'actions' => ['index','logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['login','nuevo','index'],
                        'allow' => true,
                        'roles' => ['?']
                    ]
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $contenido = Html::img(Yii::getAlias('@web')."/imgs/main.png",[
            'class' => 'main'
        ]);
        return $this->render('index',[
            'contenido' => $contenido
        ]);
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $model = new LoginForm();  
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            if (Yii::$app->user->identity->confirmado) {
                return $this->goBack();
            }
            
            Yii::$app->user->logout();
            
            $model->addError('contrasena', 'Confirme el email');
            
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }
    
    public function actionNuevo() {
        $model = new \app\models\Usuarios(['scenario' => 'create']);
        
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            
            return \yii\widgets\ActiveForm::validate($model);
        }
        
        if ($model->load(Yii::$app->request->post())) {
            $model->avatar = UploadedFile::getInstance($model,'avatar');
            if ($model->save() && $model->upload()) {
                return $this->render('index',[
                    'contenido' => 'Por favor, confirma el email'
                ]);
            }
            $model->clearPasswords();
        }
        
        return $this->render('nuevo',[
            'model' => $model
        ]);
    }
    
    public function actionConfirmar($u) {
        $models = \app\models\Usuarios::find()
                ->where(["confirmado" => "0"])
                ->select(['login','confirmado','id'])->all();

        foreach($models as $m) {
            if ($m->getEncLogin() == $u) {
                $m->confirmado = 1;
                $m->scenario = "update";

                if ($m->save()){
                    return $this->render('index',[
                        'contenido' => 'Bienvenido a Wallachof ' . $m->login
                    ]);
                }
            }
        }
        
        return $this->render('index',[
                    'contenido' => 'Error de confirmacion'
                ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

}
