<?php

namespace shirase\modules\fields\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "field_directory".
 *
 * @property integer $id
 * @property string $cat
 * @property string $time
 * @property integer $item_id
 * @property integer $field_id
 * @property integer $value
 * @property string $plugindata
 */
class FieldDirectory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'field_directory';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cat', 'item_id', 'field_id', 'value'], 'required'],
            [['time'], 'safe'],
            [['item_id', 'field_id', 'value'], 'integer'],
            [['plugindata'], 'string'],
            [['cat'], 'string', 'max' => 20],
            [['cat', 'item_id', 'time', 'field_id'], 'unique', 'targetAttribute' => ['cat', 'item_id', 'time', 'field_id'], 'message' => 'The combination of Cat, Time, Item ID and Field ID has already been taken.'],
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
            'time' => Yii::t('fields', 'Time'),
            'item_id' => Yii::t('fields', 'Item ID'),
            'field_id' => Yii::t('fields', 'Field ID'),
            'value' => Yii::t('fields', 'Value'),
            'plugindata' => Yii::t('fields', 'Plugindata'),
        ];
    }

    /**
     * @inheritdoc
     * @return \shirase\modules\fields\models\query\FieldDirectoryQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new query\FieldDirectoryQuery(get_called_class());
    }
}
