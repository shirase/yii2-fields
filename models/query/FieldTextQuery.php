<?php

namespace shirase\modules\fields\models\query;

/**
 * This is the ActiveQuery class for [[\shirase\modules\fields\models\FieldText]].
 *
 * @see \shirase\modules\fields\models\FieldText
 */
class FieldTextQuery extends \common\components\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return \shirase\modules\fields\models\FieldText[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \shirase\modules\fields\models\FieldText|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
