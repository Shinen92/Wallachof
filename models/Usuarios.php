<?php

namespace app\models;

use Yii;

use yii\captcha\CaptchaAction;

/**
 * This is the model class for table "usuarios".
 *
 * @property int $id
 * @property string $login
 * @property string $email
 * @property string $nombre
 * @property string $avatar
 * @property string $rol
 * @property string $contrasena
 *
 * @property Mensajes[] $mensajes
 * @property Mensajes[] $mensajes0
 * @property Productos[] $productos
 * @property Productos[] $productos0
 * @property Roles $rol0
 */ 
class Usuarios extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{
    
    public $contrasena_repeat;
    public $codigo;
    public $fecha_registro;
    //public $confirmado;
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'usuarios';
    }
    
    public function scenarios() {
        return [
            'create' => ['login','email','contrasena','contrasena_repeat','avatar','codigo','nombre'],
            'update' => ['confirmado']
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
//            [['confirmado'],'safe','on' => 'update'],
            [['contrasena'], 'string','on' => 'create'],
            [['avatar'],'file','skipOnEmpty' => false,'on' => 'create'],
            [['login'], 'string', 'max' => 30,'on' => 'create'],
            [['email', 'nombre', 'rol'], 'string', 'max' => 100,'on' => 'create'],
            [['login'], 'unique','on' => 'create'],
            ['codigo', 'codeVerify','on' => 'create'],
            ['codigo','required','message'=>'Debes escribir algo en los codigos',
                'on' => 'create'],
            ['contrasena_repeat', 'compare',
                'compareAttribute' => 'contrasena', 
                'operator' => '==', 'message' => 'Las contraseñas deben coincidir',
                'on' => 'create'],
            [['login','email','nombre','contrasena','contrasena_repeat'],
                'required','on' => 'create'],
            [['rol'], 'exist', 'skipOnError' => true,
                'targetClass' => Roles::className(),
                'targetAttribute' => ['rol' => 'rol'],'on' => 'create'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'login' => 'Login',
            'email' => 'Email',
            'nombre' => 'Nombre',
            'avatar' => 'Avatar',
            'rol' => 'Rol',
            'contrasena' => 'Contraseña',
            'contrasena_repeat' => 'Repite la contraseña',
            'fecha_registro' => 'Fecha de ingreso',
            'confirmado' => 'Confirmado'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    
    public function codeVerify($attribute) {
        /* nombre de la accion del controlador */
        $captcha_validate = new  CaptchaAction('captcha', Yii::$app->controller);
        
        
        if ($this->$attribute) {
            $code = $captcha_validate->getVerifyCode();
            if ($this->$attribute != $code) {
                $this->addError($attribute, 'Ese codigo de verificacion no es correcto');
            }
        }
        
    }
    
    public function clearPasswords() {
        $this->contrasena = "";
        $this->contrasena_repeat = "";
    }
    
    public function beforeSave($insert) {
        
        if (parent::beforeSave($insert)) {
            
            if ($this->contrasena !== null){
               $this->contrasena = md5($this->contrasena);
                $this->contrasena_repeat = md5($this->contrasena_repeat); 
            } 
            
            return true;
        } else {
            return false;
        }

    }
    
    public function afterSave($insert) {
        if ($insert) {
            Yii::$app->mailer->compose()
                    ->setFrom('wallachof@gmail.com')
                    ->setTo($this->email)
                    ->setSubject('Bienvenido a Wallachof')
                    ->setHtmlBody("<a href='" 
                            . \yii\helpers\Url::to(["/site/confirmar?u=" 
                                . $this->getEncLogin()],true) 
                            . "' target='_blank'>Confirmar Email</a>")
                    ->send();
        }
    }
    
    public function getEncLogin() {
        return md5($this->login);
    }
    
    public function getImagen() {
        return \yii\helpers\Html::img(Yii::$app->request->getBaseUrl() . '/imgs/avatares/' . $this->id . "/" . $this->avatar);
    }
    
    public function upload() {
        if ($this->validate()) {
            \yii\helpers\BaseFileHelper::createDirectory('imgs/avatares/' . $this->id);
            $this->avatar->saveAs('imgs/avatares/' . $this->id . "/" . $this->avatar->name,false);
            return true;
        }
        else {
            return false;
        }
    }

    public function getMensajes()
    {
        return $this->hasMany(Mensajes::className(), ['id_origen' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMensajes0()
    {
        return $this->hasMany(Mensajes::className(), ['id_destinatario' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductos()
    {
        return $this->hasMany(Productos::className(), ['id_vendedor' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductos0()
    {
        return $this->hasMany(Productos::className(), ['id_comprador' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRol0()
    {
        return $this->hasOne(Roles::className(), ['rol' => 'rol']);
    }

    /**
     * @inheritdoc
     * @return UsuariosQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new UsuariosQuery(get_called_class());
    }

    public function getAuthKey() {
        return $this->login;
    }

    public function getId() {
        return $this->id;
    }

    public function validateAuthKey($authKey) {
        return $this->login === $authKey;
    }

    public static function findIdentity($id) {
        return self::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null) {
        return null;
    }

    public static function findByUsername($username) {
        return self::findOne(['login' => $username]);
    }
    
    public function validatePassword($password) {
        return ($this->contrasena === $password);
    }
}
