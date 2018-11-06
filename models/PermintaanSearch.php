<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Permintaan;

/**
 * PermintaanSearch represents the model behind the search form of `app\models\Permintaan`.
 */
class PermintaanSearch extends Permintaan
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id',  'status'], 'integer'],
            [['id_perangkat','id_user', 'tgl_pengajuan','tgl_tanggapan','user'], 'safe'],
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
        if(Yii::$app->user->identity->role=='admin'){
          $query = Permintaan::find()->where(['permintaan.status' => 0])->orderBy(['permintaan.status' => SORT_ASC]);
        }else{
          $query = Permintaan::find()->where(['id_user' => Yii::$app->user->identity->id])->orderBy(['permintaan.status' => SORT_ASC]);
        }
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
            'permintaan.status' => $this->status,
        ]);


        $query->andFilterWhere(['like', 'id_perangkat', $this->id_perangkat])
        ->andFilterWhere(['like', 'user.name', $this->id_user]);

        if(!empty($this->tgl_pengajuan)){
          $timestamps = strtotime($this->tgl_pengajuan);
          $new_date = date('Y-m-d', $timestamps);
          $query->andFilterWhere(['like', 'permintaan.tgl_pengajuan', $new_date]);
        }else{
          $query->andFilterWhere(['like', 'permintaan.tgl_pengajuan', $this->tgl_pengajuan]);
        }

        if(!empty($this->tgl_tanggapan)){
          $timestamps = strtotime($this->tgl_tanggapan);
          $new_date = date('Y-m-d', $timestamps);
          $query->andFilterWhere(['like', 'permintaan.tgl_tanggapan', $new_date]);
        }else{
          $query->andFilterWhere(['like', 'permintaan.tgl_tanggapan', $this->tgl_tanggapan]);
        }
        return $dataProvider;
    }
}
