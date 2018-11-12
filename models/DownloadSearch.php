<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Data;

/**
 * DownloadSearch represents the model behind the search form of `app\models\Data`.
 */
class DownloadSearch extends Data
{
    /**
     * {@inheritdoc}
     */
     public $perangkat;
     public $bulan;
     public $tahun;
    public function rules()
    {
        return [
            [['id_data'], 'integer'],
            [['id_perangkat', 'tgl', 'arah_angin', 'perangkat','bulan','tahun'], 'safe'],
            [['kelembaban', 'kecepatan_angin', 'curah_hujan', 'temperature', 'tekanan_udara'], 'number'],
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


        $query = Data::find()
        ->joinWith('perangkat')
        ->OrderBy(['tgl' => SORT_ASC]);

        if (Yii::$app->user->identity->role =='user'){
            $sql = 'SELECT YEAR(tgl) as tgl FROM data,perangkat,user WHERE perangkat.id_owner = user.id AND perangkat.id = data.id_perangkat    AND user.id = "'.Yii::$app->user->identity->id.'" GROUP BY YEAR(tgl) ORDER BY YEAR(tgl) DESC';
            $years = Data::findBySql($sql)->one();

            $sql1 = 'SELECT MONTH(tgl) as tgl FROM data,perangkat,user WHERE perangkat.id_owner = user.id AND perangkat.id = data.id_perangkat    AND user.id = "'.Yii::$app->user->identity->id.'" GROUP BY YEAR(tgl) ORDER BY YEAR(tgl) DESC';
            $months = Data::findBySql($sql1)->one();
            
            $perangkatu= Perangkat::find()->where(['id_owner'=>Yii::$app->user->identity->id])->one();
            $query
            ->where(['perangkat.id_owner' =>Yii::$app->user->identity->id]);
            if(empty($this->id_perangkat)){
                $this->id_perangkat= $perangkatu['id'];
            }
            if(empty($this->tahun)){
                $this->tahun= $years['tgl'];
            }
            if(empty($this->bulan)){
                $this->bulan= $months['tgl'];
            }

        }

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
        $query->andFilterWhere([
            'id_data' => $this->id_data,
            'tgl' => $this->tgl,
            'kelembaban' => $this->kelembaban,
            'kecepatan_angin' => $this->kecepatan_angin,
            'curah_hujan' => $this->curah_hujan,
            'temperature' => $this->temperature,
            'tekanan_udara' => $this->tekanan_udara,
        ]);

        $query->andFilterWhere(['like', 'id_perangkat', $this->id_perangkat])
            ->andFilterWhere(['like', 'arah_angin', $this->arah_angin])
            ->andFilterWhere(['like', 'MONTH(tgl)', $this->bulan])
            ->andFilterWhere(['like', 'YEAR(tgl)', $this->tahun]);

        return $dataProvider;
    }
}
