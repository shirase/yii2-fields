<?php

namespace shirase\modules\fields\models;

use common\db\ActiveQuery;
use shirase\tree\TreeBehavior;
use Yii;
use yii\caching\DbQueryDependency;
use yii\db\ActiveRecord;
use yii\db\Exception;
use yii\db\Query;

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
                'class' => TreeBehavior::className(),
                'pidAttribute' => false,
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

    public function getValue($item_id, $time = null)
    {
        /** @var ActiveRecord $fieldClass */
        $fieldClass = 'Field' . ucfirst($this->type);
        /** @var FieldString|FieldDirectory $fieldType */
        $fieldType = $fieldClass::findOne(['time' => $time, 'field_id' => $this->id, 'item_id' => $item_id]);
        if (!$fieldType) {
            return false;
        }

        /** @var ActiveRecord $directoryClass */
        if ($directoryClass = $this->directory_class) {
            return $directoryClass::findOne($fieldType->value);
        } else {
            return $fieldType->value;
        }
    }

    public function setValue($value, $item_id, $time = null)
    {
        /** @var FieldString|FieldDirectory|null $fieldType */
        $fieldType = null;
        /** @var ActiveRecord $fieldClass */
        $fieldClass = 'Field' . ucfirst($this->type);
        if ($this->multi) {
            $fieldClass::deleteAll(['cat' => $this->cat, 'field_id' => $this->id, 'item_id' => $item_id, 'time' => $time]);
        } else {
            $fieldType = $fieldClass::findOne(['time' => $time, 'field_id' => $this->id, 'item_id' => $item_id]);
        }

        if (!$fieldType) {
            $fieldType = new $fieldClass();
            $fieldType->cat = $this->cat;
            $fieldType->field_id = $this->id;
            $fieldType->item_id = $item_id;
            $fieldType->time = $time;
        }

        if ($this->multi) {
            foreach ((array)$value as $v) {
                $t = clone $fieldType;
                $t->value = $v;
                if (!$t->save())
                    throw new Exception('Field type save error', $t->errors);
            }
        } else {
            $fieldType->value = $value;

            if (!$fieldType->save())
                throw new Exception('Field type save error', $fieldType->errors);
        }

        return $fieldType;
    }

    /**
     * Возвращает список значений полей сущности
     * Справочники возвращаются в виде модели справочника, которые могут приводится к строке
     * @param $item_id
     * @param bool $activeOnly
     * @param null $time
     * @return array
     */
    public static function values($item_id, $activeOnly = false, $time = null)
    {
        $values = [];

        $query = self::find()->groupBy('type')->select('type');
        if ($activeOnly) {
            $query->andWhere(['status' => 1]);
        }
        $types = $query->column();
        foreach ($types as $type) {
            /** @var ActiveRecord $fieldClass */
            $fieldClass = 'Field' . ucfirst($type);
            $rows = $fieldClass::find()->andWhere(['time' => $time])->andWhere(['item_id' => $item_id])->select('field_id, value')->asArray()->all();
            foreach ($rows as $row) {
                $field = self::findOne($row['field_id']);
                /** @var ActiveRecord $directoryClass */
                if ($directoryClass = $field->directory_class) {
                    $directoryItem = $directoryClass::findOne($row['value']);
                    $values[$row['field_id']] = $directoryItem;
                } else {
                    $values[$row['field_id']] = $row['value'];
                }
            }
        }

        return $values;
    }

    /**
     * Возвращает историю поля сущьности во времени
     * @param $item_id
     * @return array
     */
    public function getTimes($item_id)
    {
        /** @var ActiveRecord $fieldClass */
        $fieldClass = 'Field' . ucfirst($this->type);
        return $fieldClass::find()
            ->andWhere('`time` IS NOT NULL')
            ->orderBy('time')
            ->andWhere([
                'field_id' => $this->id,
                'item_id' => $item_id,
            ])
            ->all();
    }

    /**
     * Возвращает массив вариантов значений текущего поля для сущностей, подходящих под критерии
     * @param Query $itemQuery
     * @param null $time
     * @return array|mixed
     */
    public function variants($itemQuery, $time = null)
    {
        if ($itemQuery) {
            $itemQuery = clone($itemQuery);
            $itemQuery->select('id');
            $queryHash = md5($itemQuery->createCommand()->rawSql);
        } else {
            $queryHash = '';
        }

        if (isset(Yii::$app->cache)) {
            $cc = Yii::$app->cache->get('Field_variants_' . $this->id . '_' . $queryHash);
            if ($cc !== false) {
                return $cc;
            }
        }

        /** @var ActiveRecord $fieldClass */
        $fieldClass = 'Field' . ucfirst($this->type);

        $query = $fieldClass::find()->andWhere(['time' => $time])->andWhere(['>', 'value', 0])->andWhere('field_id', $this->id)->select('value')->groupBy('value');
        if ($itemQuery) {
            $query->andWhere(['IN', 'item_id', $itemQuery]);
        }
        $values = $query->column();

        if (isset(Yii::$app->cache)) {
            Yii::$app->cache->set('Field_variants_' . $this->id . '_' . $queryHash, $values, 0, new DbQueryDependency(['query' => $fieldClass::find()->select('COUNT(*), MAX(`id`)')->andWhere(['field_id' => $this->id])->asArray()]));
        }

        return $values;
    }

    /**
     * Возвращает id заполненных харектеристик сущностей, соответствующих критериям
     * @param $itemQuery Query
     * @param null $time
     * @return array|mixed|null
     */
    public static function activeFieldsId($itemQuery, $time = null)
    {
        if ($itemQuery) {
            $itemQuery = clone($itemQuery);
            $itemQuery->select('id');
            $queryHash = md5($itemQuery->createCommand()->rawSql);
        } else {
            $queryHash = '';
        }

        if (isset(Yii::$app->cache)) {
            $cc = Yii::$app->cache->get('Field_active_' . $queryHash);
            if ($cc !== false) {
                return $cc;
            }
        }

        $fields = [];

        $types = self::find()->groupBy('type')->select('type')->column();
        foreach ($types as $type) {
            /** @var ActiveRecord $fieldClass */
            $fieldClass = 'Field' . ucfirst($type);
            $fields = array_merge($fields, $fieldClass::find()->andWhere(['time' => $time])->select('field_id')->groupBy('field_id')->andWhere(['IN', 'item_id', $itemQuery])->andWhere('value>0')->column());
        }

        return $fields;
    }
}
