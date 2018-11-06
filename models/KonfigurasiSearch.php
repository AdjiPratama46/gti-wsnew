<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Konfigurasi;

/**
 * KonfigurasiSearch represents the model behind the search form of `app\models\Konfigurasi`.
 */
class KonfigurasiSearch extends Konfigurasi
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'gsm_to', 'gps_to'], 'integer', 'message' => '{attribute} harus berupa integer'],
            [['interval', 'id_user', 'ip_server', 'no_hp', 'ussd_code', 'timestamp', 'user'], 'safe'],
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
        $query = Konfigurasi::find()->orderBy(['timestamp' => SORT_DESC]);
        $query->joinWith(['user']);
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
           'pagination' => [ 'pageSize' => 10 ],
        ]);
        $dataProvider->sort->attributes['user'] = [
        // The tables are the ones our relation are configured to
        // in my case they are prefixed with "tbl_"
        'asc' => ['user.name' => SORT_ASC],
        'desc' => ['user.name' => SORT_DESC],
        ];
        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
        ]);

        $query->andFilterWhere(['like', 'interval', $this->interval])
            ->andFilterWhere(['like', 'user.name', $this->id_user])
            ->andFilterWhere(['like', 'ip_server', $this->ip_server])
            ->andFilterWhere(['like', 'no_hp', $this->no_hp])
            ->andFilterWhere(['like', 'gsm_to', $this->gsm_to])
            ->andFilterWhere(['like', 'gps_to', $this->gps_to])
            ->andFilterWhere(['like', 'ussd_code', $this->ussd_code]);

            if(!empty($this->timestamp)){
              $timestamps = strtotime($this->timestamp);
              $new_date = date('Y-m-d', $timestamps);
              $query->andFilterWhere(['like', 'timestamp', $new_date]);
            }else{
              $query->andFilterWhere(['like', 'timestamp', $this->timestamp]);
            }

        return $dataProvider;
    }
}
