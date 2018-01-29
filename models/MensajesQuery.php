<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Mensajes]].
 *
 * @see Mensajes
 */
class MensajesQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return Mensajes[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Mensajes|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
