<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Data;

/**
 * DataSearch represents the model behind the search form of `app\models\Data`.
 */
class DataSearch extends Data
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_data', 'kapasitas_baterai'], 'integer'],
            [['id_perangkat', 'tgl', 'arah_angin'], 'safe'],
            [['kelembaban', 'kecepatan_angin', 'curah_hujan', 'temperature'], 'number'],
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
        $query = Data::find()->where(
            [
              'between',
              'tgl',
              date('Y-m-d H:i:s', mktime(0, 0, 0, date('m'), date('d')-1, date('Y'))),
              date('Y-m-d H:i:s', mktime(23, 59, 59, date('m'), date('d')-1, date('Y')))
              ])->orderBy(['tgl' => SORT_ASC]);

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
            'id_data' => $this->id_data,
            'kelembaban' => $this->kelembaban,
            'kecepatan_angin' => $this->kecepatan_angin,
            'curah_hujan' => $this->curah_hujan,
            'temperature' => $this->temperature,
            'kapasitas_baterai' => $this->kapasitas_baterai,
        ]);

        $query->andFilterWhere(['like', 'id_perangkat', $this->id_perangkat])
            ->andFilterWhere(['like', 'arah_angin', $this->arah_angin])
            ->andFilterWhere(['like', 'FROM_UNIXTIME(tgl, "%Y-%m-%d")', $this->tgl]);

        return $dataProvider;
    }
}
