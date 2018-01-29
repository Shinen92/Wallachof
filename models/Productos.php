<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "productos".
 *
 * @property int $id
 * @property int $id_vendedor
 * @property int $id_comprador
 * @property double $precio_compra
 * @property string $fecha_compra
 * @property string $localizacion
 * @property string $descripcion
 * @property string $categoria
 * @property double $precio_oferta
 * @property string $foto
 * @property string $fecha_oferta
 * @property string $producto
 *
 * @property Usuarios $vendedor
 * @property Usuarios $comprador
 * @property Categorias $categoria0
 */
class Productos extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'productos';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_vendedor', 'id_comprador'], 'integer'],
            [['foto'],'file','skipOnEmpty' => false],
            [['precio_compra', 'precio_oferta'], 'number'],
            [['fecha_compra', 'fecha_oferta'], 'safe'],
            [['descripcion'], 'string'],
            [['precio_oferta','producto','foto','localizacion','categoria','descripcion','id_vendedor'],'required'],
            [['localizacion', 'categoria', 'producto'], 'string', 'max' => 100],
            [['id_vendedor'], 'exist', 'skipOnError' => true, 'targetClass' => Usuarios::className(), 'targetAttribute' => ['id_vendedor' => 'id']],
            [['id_comprador'], 'exist', 'skipOnError' => true, 'targetClass' => Usuarios::className(), 'targetAttribute' => ['id_comprador' => 'id']],
            [['categoria'], 'exist', 'skipOnError' => true, 'targetClass' => Categorias::className(), 'targetAttribute' => ['categoria' => 'categoria']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_vendedor' => 'Id Vendedor',
            'id_comprador' => 'Id Comprador',
            'precio_compra' => 'Precio Compra',
            'fecha_compra' => 'Fecha Compra',
            'localizacion' => 'Localizacion',
            'descripcion' => 'Descripcion',
            'categoria' => 'Categoria',
            'precio_oferta' => 'Precio Oferta',
            'foto' => 'Foto',
            'fecha_oferta' => 'Fecha Oferta',
            'producto' => 'Producto',
        ];
    }
    
    public function getImagen() {
        return Yii::$app->request->getBaseUrl() . '/imgs/productos/' . $this->id . "/" . $this->foto;
    }
    
    public function upload() {
        if ($this->validate()) {
            \yii\helpers\BaseFileHelper::createDirectory('imgs/productos/' . $this->id);
            $this->foto->saveAs('imgs/productos/' . $this->id . "/" . $this->foto->name,false);
            return true;
        }
        else {
            return false;
        }
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVendedor()
    {
        return $this->hasOne(Usuarios::className(), ['id' => 'id_vendedor']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComprador()
    {
        return $this->hasOne(Usuarios::className(), ['id' => 'id_comprador']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategoria0()
    {
        return $this->hasOne(Categorias::className(), ['categoria' => 'categoria']);
    }

    /**
     * @inheritdoc
     * @return ProductosQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ProductosQuery(get_called_class());
    }
}
