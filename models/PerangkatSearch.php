<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Perangkat;

/**
 * PerangkatSearch represents the model behind the search form of `app\models\Perangkat`.
 */
class PerangkatSearch extends Perangkat
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'alias', 'tgl_instalasi', 'longitude', 'latitude','altitude'], 'safe'],
            [['id_owner', 'user'], 'safe'],
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
        if (Yii::$app->user->identity->role =='admin') {
            $query = Perangkat::find();
        }elseif (Yii::$app->user->identity->role =='user') {
            $query = Perangkat::find()->where(['id_owner' => Yii::$app->user->identity->id]);
        }
        $query->joinWith(['user']);
        // $query = Perangkat::find()->where(['id_owner' => Yii::$app->user->identity->id]);
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
           'pagination' => [ 'pageSize' => 5 ],
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
            'tgl_instalasi' => $this->tgl_instalasi,
        ]);

        $query->andFilterWhere(['like', 'id', $this->id])
            ->andFilterWhere(['like', 'alias', $this->alias])
            ->andFilterWhere(['like', 'longitude', $this->longitude])
            ->andFilterWhere(['like', 'latitude', $this->latitude])
            ->andFilterWhere(['like', 'altitude', $this->altitude])
            ->andFilterWhere(['like', 'user.name', $this->id_owner]);

        return $dataProvider;
    }
}
