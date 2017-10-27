<?php

namespace shirase\modules\fields\models;

use Yii;

/**
 * This is the model class for table "field_group".
 *
 * @property integer $id
 * @property string $cat
 * @property integer $pos
 * @property string $name
 * @property string $fields
 */
class FieldGroup extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'field_group';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            [
                'class' => \shirase\tree\TreeBehavior::className(),
                'pid' => false,
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cat', 'name'], 'required'],
            [['fields'], 'string'],
            [['cat'], 'string', 'max' => 20],
            [['name'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('fields', 'ID'),
            'cat' => Yii::t('fields', 'Cat'),
            'name' => Yii::t('fields', 'Name'),
            'fields' => Yii::t('fields', 'Fields'),
        ];
    }

    /**
     * @inheritdoc
     * @return \shirase\modules\fields\models\query\FieldGroupQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new query\FieldGroupQuery(get_called_class());
    }
}
