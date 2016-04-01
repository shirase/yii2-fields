<?php

namespace shirase\modules\fields\models;

use Yii;

/**
 * This is the model class for table "field".
 *
 * @property integer $id
 * @property string $cat
 * @property string $alias
 * @property integer $pos
 * @property integer $status
 * @property string $type
 * @property string $plugin
 * @property integer $multi
 * @property string $directory_class
 * @property string $name
 * @property string $unit
 * @property integer $counter
 */
class Field extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'field';
    }

    /**
    * @inheritdoc
    */
    public function behaviors()
    {
        return [
            [
                'class' => \shirase\tree\TreeBehavior::className(),
                'pid'=>false,
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['!cat', 'type', 'name'], 'required'],
            [['status', 'multi', '!counter'], 'integer'],
            [['!cat', 'alias', 'type'], 'string', 'max' => 20],
            [['plugin', 'directory_class'], 'string', 'max' => 100],
            [['name'], 'string', 'max' => 255],
            [['unit'], 'string', 'max' => 10],
            [['alias', 'name'], 'unique', 'targetAttribute' => ['alias', 'name'], 'message' => 'The combination of Alias and Name has already been taken.'],
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
            'alias' => Yii::t('fields', 'Alias'),
            'status' => Yii::t('fields', 'Status'),
            'type' => Yii::t('fields', 'Type'),
            'plugin' => Yii::t('fields', 'Plugin'),
            'multi' => Yii::t('fields', 'Multi'),
            'directory_class' => Yii::t('fields', 'Directory Class'),
            'name' => Yii::t('fields', 'Name'),
            'unit' => Yii::t('fields', 'Unit'),
            'counter' => Yii::t('fields', 'Counter'),
        ];
    }

    /**
     * @inheritdoc
     * @return \shirase\modules\fields\models\query\FieldQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new query\FieldQuery(get_called_class());
    }
}
