<?php
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this \yii\web\View */
/* @var $content string */
$id = Yii::$app->user->identity->id;
$urlu = Url::to(['user/index']);
$urlp = Url::to(['perangkat/index']);
$urld = Url::to(['data/index']);
$urlper = Url::to(['permintaan/index']);
$uba = Yii::$app->db->createCommand
('SELECT COUNT(*)as ubar FROM user WHERE DATE(tgl_buat)=DATE(NOW())')
->queryOne();
$per = Yii::$app->db->createCommand
('SELECT COUNT(*) AS perba FROM perangkat WHERE DATE(tgl_instalasi) = DATE(NOW())')
->queryOne();
$dasuk = Yii::$app->db->createCommand
('SELECT count(*) as jml FROM data WHERE DATE(tgl)=DATE(NOW())')
->queryOne();
$permin = Yii::$app->db->createCommand
('SELECT count(*) as permin FROM permintaan WHERE DATE(tgl_pengajuan)=DATE(NOW())')
->queryOne();
$pe = $per['perba'];
$da = $dasuk['jml'];
$ub = $uba['ubar'];
$perm = $permin['permin'];

if ($pe > 0) {
    $pe=1;
}if ($da > 0) {
    $da=1;
}if ($ub > 0) {
    $ub=1;
}if ($perm > 0) {
    $perm=1;
}
$tot = $pe+$da+$ub+$perm;
$this->registerJs("
    $('#fs').on('click ', function (event) {
        if ($('#io').hasClass('fa-arrows-alt')) {
            $('#io').removeClass('fa-arrows-alt').addClass('fa-compress');
            document.documentElement.webkitRequestFullscreen();
        }else{
            $('#io').removeClass('fa-compress').addClass('fa-arrows-alt');
            document.webkitExitFullscreen();
        }
        })
    ");
?>
<header class="main-header" style="position:fixed;width:100%;border-bottom:1px solid #4F7BC3;">

      <a href="<?php  Url::to(['site/index']); ?>" class="logo" style="background-color:#2F5189;" >
        <!-- mini logo for sidebar mini 50x50 pixels -->

          <span class="logo-mini"><b>W</b>S</span>
          <!-- logo for regular state and mobile devices -->
          <span class="logo-lg"><b>Weather</b>Station</span>
    </a>
    <nav class="navbar navbar-static-top" role="navigation" style="background-color: #3963A9;">

        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>

        <div class="navbar-custom-menu">

            <ul class="nav navbar-nav">
              

                <li class="dropdown user user-menu" >
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <?= Html::img('@web/images/'.Yii::$app->user->identity->gambar, ['alt'=>'User Image', 'class'=>'user-image']);?>

                        <span class="hidden-xs"><?= Yii::$app->user->identity->name ?></span>
                        <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu" style="width:200px;" >
                        <!-- User image -->
                        <li class="user-header" style="background-color: #3963A9;">
                          <?= Html::img('@web/images/'.Yii::$app->user->identity->gambar, ['alt'=>'User Image', 'class'=>'img-circle']);?>



                            <p style="color:white;">
                                <?= Yii::$app->user->identity->name ?>
                            </p>
                            <hr style="border:0.5px solid #4F7BC3;width:60%;">

                        </li>

                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="menu-dd">
                            <?= Html::a(
                                    'Setting',
                                    ['/user/update', 'id' => $id],
                                    ['class' => 'btn btn-block btn-menu-dd']
                                ) ?>
                            </div>
                            <div class="menu-dd">
                                <?= Html::a(
                                    'Sign out',
                                    ['/site/logout'],
                                    ['data-method' => 'post', 'class' => 'btn btn-block btn-menu-dd']
                                ) ?>
                            </div>
                        </li>
                    </ul>
                </li>

                <!-- User Account: style can be found in dropdown.less -->

            </ul>
        </div>

    </nav>
</header>
