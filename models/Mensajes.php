<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "mensajes".
 *
 * @property int $id
 * @property string $contenido
 * @property string $fecha
 * @property int $id_origen
 * @property int $id_destinatario
 *
 * @property Usuarios $origen
 * @property Usuarios $destinatario
 */
class Mensajes extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'mensajes';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['contenido'], 'string'],
            [['contenido','id_origen','id_destinatario'], 'safe'],
            [['id_origen', 'id_destinatario'], 'integer'],
            [['id_origen'], 'exist', 'skipOnError' => true, 'targetClass' => Usuarios::className(), 'targetAttribute' => ['id_origen' => 'id']],
            [['id_destinatario'], 'exist', 'skipOnError' => true, 'targetClass' => Usuarios::className(), 'targetAttribute' => ['id_destinatario' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'contenido' => 'Contenido',
            'fecha' => 'Fecha',
            'id_origen' => 'Id Origen',
            'id_destinatario' => 'Id Destinatario',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrigen()
    {
        return $this->hasOne(Usuarios::className(), ['id' => 'id_origen']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDestinatario()
    {
        return $this->hasOne(Usuarios::className(), ['id' => 'id_destinatario']);
    }

    /**
     * @inheritdoc
     * @return MensajesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new MensajesQuery(get_called_class());
    }
}
