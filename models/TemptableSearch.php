<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Temptable;

/**
 * TemptableSearch represents the model behind the search form of `app\models\Temptable`.
 */
class TemptableSearch extends Temptable
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'status'], 'integer'],
            [['id_perangkat', 'latitude', 'longitude', 'altimeter', 'arah_angin', 'timestamp'], 'safe'],
            [['temperature', 'kelembapan', 'tekanan_udara', 'kecepatan_angin', 'curah_hujan'], 'number'],
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
        $query = Temptable::find()->groupBy(['id_perangkat'])->orderBy(['timestamp' => SORT_DESC]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
           'pagination' => [ 'pageSize' => 5 ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions


        $query->andFilterWhere(['like', 'id_perangkat', $this->id_perangkat])
            ->andFilterWhere(['like', 'latitude', $this->latitude])
            ->andFilterWhere(['like', 'longitude', $this->longitude])
            ->andFilterWhere(['like', 'altimeter', $this->altimeter]);

        return $dataProvider;
    }
}
