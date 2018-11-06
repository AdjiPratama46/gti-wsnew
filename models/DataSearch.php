<?php
namespace app\models;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Data;
use app\models\Perangkat;
/**
 * DataSearch represents the model behind the search form of `app\models\Data`.
 */
class DataSearch extends Data
{
    /**
     * {@inheritdoc}
     */
     public $perangkat;
     public $pukul;
    public function rules()
    {
        return [
            [['id_data'], 'integer'],
            [['id_perangkat', 'tgl', 'arah_angin', 'perangkat','pukul'], 'safe'],
            [['kelembaban', 'kecepatan_angin', 'curah_hujan', 'temperature','tekanan_udara'], 'number'],
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
        //Menentukan QUERY
        $query=$this->querynya($params);
        // add conditions that should always apply here
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [ 'pageSize' => 10 ],
        ]);
        $dataProvider->sort->attributes['perangkat'] = [
            'asc' => ['perangkat.alias' => SORT_ASC],
            'desc' => ['perangkat.alias' => SORT_DESC],
        ];
        $dataProvider->sort->attributes['pukul'] = [
            'asc' => ['tgl' => SORT_ASC],
            'desc' => ['tgl' => SORT_DESC],
        ];
        $this->load($params);
        if (!$this->validate()) {
            return $dataProvider;
        }
        // grid filtering conditions
        $query->andFilterWhere([
            'id_data' => $this->id_data,
            'kelembaban' => $this->kelembaban,
            'kecepatan_angin' => $this->kecepatan_angin,
            'curah_hujan' => $this->curah_hujan,
            'temperature' => $this->temperature,
            'tekanan_udara' => $this->tekanan_udara,
        ]);
        $query->andFilterWhere(['like', 'id_perangkat', $this->id_perangkat])
            ->andFilterWhere(['like', 'arah_angin', $this->arah_angin])
            ->andFilterWhere(['like', 'time(tgl)', $this->pukul])
            ->andFilterWhere(['like', 'perangkat.alias', $this->perangkat]);

            if(!empty($this->tgl)){
              $timestamps = strtotime($this->tgl);
              $new_date = date('Y-m-d', $timestamps);
              $query->andFilterWhere(['like', 'tgl', $new_date]);
            }else{
              $query->andFilterWhere(['like', 'tgl', $this->tgl]);
            }
        return $dataProvider;
    }


    private function querynya($params){
        if (Yii::$app->user->identity->role =='admin') {
            $this->load($params);
            if(empty($this->tgl) && empty($this->id_perangkat)){
                $query = Data::find()
                ->where(
                    [
                        'between',
                        'tgl',
                        date('Y-m-d H:i:s', mktime(0, 0, 0, date('m'), date('d')-1, date('Y'))),
                        date('Y-m-d H:i:s', mktime(23, 59, 59, date('m'), date('d')-1, date('Y')))
                        ])->orderBy(['tgl' => SORT_ASC]);
            }
            elseif(!empty($this->tgl) && empty($this->id_perangkat)){
                $query = Data::find()
                ->joinWith('perangkat')->orderBy(['tgl' => SORT_ASC]);
            }
            elseif(!empty($this->id_perangkat) && empty($this->tgl)){
                $query = Data::find()
                ->joinWith('perangkat')->where(
                        [
                            'between',
                            'tgl',
                            date('Y-m-d H:i:s', mktime(0, 0, 0, date('m'), date('d')-1, date('Y'))),
                            date('Y-m-d H:i:s', mktime(23, 59, 59, date('m'), date('d')-1, date('Y')))
                            ])->orderBy(['tgl' => SORT_ASC]);
            }
            else{
                $query = Data::find()
                ->joinWith('perangkat')->orderBy(['tgl' => SORT_ASC]);;
            }
        }
        elseif (Yii::$app->user->identity->role =='user') {
            $this->load($params);
            $perangk = Perangkat::find()->where(['id_owner'=>Yii::$app->user->identity->id])->one();

            if(empty($this->tgl) && empty($this->id_perangkat) && !empty($perangk->id)){

                $query = Data::find()
                ->joinWith('perangkat')
                ->where(['perangkat.id_owner' =>Yii::$app->user->identity->id])
                ->andWhere(
                    [
                    'between',
                    'tgl',
                    date('Y-m-d H:i:s', mktime(0, 0, 0, date('m'), date('d')-1, date('Y'))),
                    date('Y-m-d H:i:s', mktime(23, 59, 59, date('m'), date('d')-1, date('Y')))
                    ])
                ->andWhere(['id_perangkat' => $perangk->id])->orderBy(['tgl' => SORT_ASC]);
            }
            elseif(!empty($this->tgl) && empty($this->id_perangkat) && !empty($perangk->id)){
            $query = Data::find()
            ->joinWith('perangkat')->where(['perangkat.id_owner' =>Yii::$app->user->identity->id])->andWhere(
                ['id_perangkat' => $perangk->id])->orderBy(['tgl' => SORT_ASC]);
            }
            elseif(!empty($this->id_perangkat) && empty($this->tgl)   && !empty($perangk->id)){
            $query = Data::find()
            ->joinWith('perangkat')->where(['perangkat.id_owner' =>Yii::$app->user->identity->id])->andWhere(
                ['id_perangkat' => $this->id_perangkat])->andWhere(
                    [
                        'between',
                        'tgl',
                        date('Y-m-d H:i:s', mktime(0, 0, 0, date('m'), date('d')-1, date('Y'))),
                        date('Y-m-d H:i:s', mktime(23, 59, 59, date('m'), date('d')-1, date('Y')))
                        ])->orderBy(['tgl' => SORT_ASC]);
            }
            else{
            $query = Data::find()
            ->joinWith('perangkat')->where(['perangkat.id_owner' =>Yii::$app->user->identity->id])->orderBy(['tgl' => SORT_ASC]);;
            }
        }

        return $query;
    }
}
