<?php

namespace wmsamolet\fcs\core\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use wmsamolet\fcs\core\models\Entity;

/**
 * EntitySearch represents the model behind the search form of `wmsamolet\fcs\core\models\Entity`.
 */
class EntitySearch extends Entity
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'group_id', 'sort_order'], 'integer'],
            [['title', 'class', 'table', 'categories_table', 'slug_attribute', 'created_at', 'updated_at'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
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
        $query = Entity::find();

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
            'group_id' => $this->group_id,
            'sort_order' => $this->sort_order,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'class', $this->class])
            ->andFilterWhere(['like', 'table', $this->table])
            ->andFilterWhere(['like', 'categories_table', $this->categories_table])
            ->andFilterWhere(['like', 'slug_attribute', $this->slug_attribute]);

        return $dataProvider;
    }
}
