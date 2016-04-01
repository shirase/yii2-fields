<?php

namespace shirase\modules\fields\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use shirase\modules\fields\models\Field;

/**
 * FieldSearch represents the model behind the search form about `shirase\modules\fields\models\Field`.
 */
class FieldSearch extends Field
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'pos', 'status', 'multi', 'counter'], 'integer'],
            [['cat', 'alias', 'type', 'plugin', 'directory_class', 'name', 'unit'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Field::find()->indexBy($this::primaryKey()[0]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'status' => $this->status,
            'multi' => $this->multi,
            'counter' => $this->counter,
        ]);

        $query->andFilterWhere(['like', 'cat', $this->cat])
            ->andFilterWhere(['like', 'alias', $this->alias])
            ->andFilterWhere(['like', 'type', $this->type])
            ->andFilterWhere(['like', 'plugin', $this->plugin])
            ->andFilterWhere(['like', 'directory_class', $this->directory_class])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'unit', $this->unit]);

        return $dataProvider;
    }

    public static function typeOpt() {
        return [
            'string'=>Yii::t('fields', 'String'),
            'int'=>Yii::t('fields', 'Integer'),
            'directory'=>Yii::t('fields', 'Directory'),
        ];
    }
}
