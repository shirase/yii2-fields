<?php

namespace shirase\modules\fields\models\query;

/**
 * This is the ActiveQuery class for [[\shirase\modules\fields\models\FieldDirectory]].
 *
 * @see \shirase\modules\fields\models\FieldDirectory
 */
class FieldDirectoryQuery extends \common\components\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return \shirase\modules\fields\models\FieldDirectory[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \shirase\modules\fields\models\FieldDirectory|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
