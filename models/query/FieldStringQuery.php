<?php

namespace shirase\modules\fields\models\query;

/**
 * This is the ActiveQuery class for [[\shirase\modules\fields\models\FieldString]].
 *
 * @see \shirase\modules\fields\models\FieldString
 */
class FieldStringQuery extends \common\components\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return \shirase\modules\fields\models\FieldString[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \shirase\modules\fields\models\FieldString|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
