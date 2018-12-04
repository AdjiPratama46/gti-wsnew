<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\data\SqlDataProvider;
use app\models\Data;
use app\models\Perangkat;

/**
 * DownloadSearch represents the model behind the search form of `app\models\Data`.
 */
class ResumeSearch extends Data
{
    /**
     * {@inheritdoc}
     */
     public $id;
     public $tahun;
    public function rules()
    {
        return [
            [['id', 'tahun'], 'safe'],
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

      $this->load($params);
      $id_owner = Yii::$app->user->id;
      if (Yii::$app->user->identity->role=="admin"){
        $model = Perangkat::find()
        ->one();
      }elseif (Yii::$app->user->identity->role=="user"){
        $model = Perangkat::find()
        ->Where(['id_owner' => $id_owner])
        ->one();
      }


      if(empty($this->id)){
        $this->id=$model->id;
      }if(empty($this->tahun)){
        $sql = 'SELECT YEAR(tgl) as tgl FROM data,perangkat,user WHERE perangkat.id_owner = user.id AND perangkat.id = data.id_perangkat    AND user.id = "'.$id_owner.'" GROUP BY YEAR(tgl) ORDER BY YEAR(tgl) DESC';
        $years = Data::findBySql($sql)->one();
        $this->tahun=$years->tgl;
      }
          $dataProvider = new SqlDataProvider([
              'sql' => 'SELECT MONTHNAME(tgl) AS bulan, id_perangkat, year(tgl) as tahun, AVG(kelembaban) AS kelembaban,
              AVG(kecepatan_angin) AS kecepatan_angin,
              (SELECT arah_angin FROM data WHERE id_perangkat="'.$this->id.'"
              AND MONTHNAME(tgl)=bulan GROUP BY arah_angin
              ORDER BY count(arah_angin) DESC LIMIT 1) AS arah_angin,
              SUM(curah_hujan) AS curah_hujan,
              AVG(temperature) AS temperature,
              AVG(tekanan_udara) AS tekanan_udara
              FROM data WHERE id_perangkat="'.$this->id.'" AND year(tgl)="'.$this->tahun.'" GROUP BY bulan ORDER BY MONTH(tgl) ASC',

              'sort' =>false,
              'pagination' => [
                  'pageSize' => 10,
              ],
          ]);

      if (!$this->validate()) {
          // uncomment the following line if you do not want to return any records when validation fails
          // $query->where('0=1');
          return $dataProvider;
      }





        // grid filtering conditions

        return $dataProvider;
    }
}
