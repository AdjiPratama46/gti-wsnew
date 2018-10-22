<?php

namespace app\models;

use Yii;
use yii\base\Model;

class Tperangkat extends Model
{
    public $idp;

    public function rules()
    {
        return [
            [['idp'], 'required'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'idp' => 'Id Perangkat',
        ];
    }

}
