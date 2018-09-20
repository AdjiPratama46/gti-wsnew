<?php

namespace app\models;

use Yii;
use yii\base\Model;
use dosamigos\google\maps\LatLng;
use dosamigos\google\maps\services\DirectionsWayPoint;
use dosamigos\google\maps\services\TravelMode;
use dosamigos\google\maps\overlays\PolylineOptions;
use dosamigos\google\maps\services\DirectionsRenderer;
use dosamigos\google\maps\services\DirectionsService;
use dosamigos\google\maps\overlays\InfoWindow;
use dosamigos\google\maps\overlays\Marker;
use dosamigos\google\maps\Map;
use dosamigos\google\maps\services\DirectionsRequest;
use dosamigos\google\maps\overlays\Polygon;
use dosamigos\google\maps\layers\BicyclingLayer;


class Maps extends Model
{
  public function showMaps($data){

    $data_long = array();
    $data_lat = array();
    $data_alias = array();
    $s=0;
    foreach($data as $t)
    {
        $data_long[$s] = $t->longitude;
        $data_lat[$s] = $t->latitude;
        $data_alias[$s] = $t->alias;
        $s++;
    }
    $coords = new LatLng(['lat' => -3.248434, 'lng' => 117.347373]);
    $map = new Map([

        'center' => $coords,
        'zoom' => 5,
        'width' => '100%' ,
    ]);
    for($x=0;$x<sizeof($data_lat);$x++){
      $coord = new LatLng(['lat' => $data_lat[$x], 'lng' => $data_long[$x]]);
      $marker = new Marker([
          'position' => $coord,
          'title' => $data_alias[$x],
      ]);
      $marker->attachInfoWindow(
          new InfoWindow([
              'content' => '<p>'.$data_alias[$x].'</p>'
          ])
      );
      $map->addOverlay($marker);
    }
    return $map;
  //echo $map->display();
  }
}
