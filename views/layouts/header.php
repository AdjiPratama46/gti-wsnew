<?php
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this \yii\web\View */
/* @var $content string */
$id = Yii::$app->user->identity->id;
$urlu = Url::to(['user/index']);
$urlp = Url::to(['perangkat/index']);
$urld = Url::to(['data/index']);
$uba = Yii::$app->db->createCommand
('SELECT COUNT(*)as ubar FROM perangkat WHERE DATE(tgl_instalasi)=DATE(NOW())')
->queryOne();
$per = Yii::$app->db->createCommand
('SELECT COUNT(*) AS perba FROM perangkat WHERE DATE(tgl_instalasi) = DATE(NOW())')
->queryOne();
$dasuk = Yii::$app->db->createCommand
('SELECT count(*) as jml FROM data WHERE DAY(tgl)=DAY(NOW())')
->queryOne();

$pe = $per['perba'];
$da = $dasuk['jml'];
$ub = $uba['ubar'];
$tot = $ub+$pe+$da;
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
                <li class="notifications-menu">
                    <a id="fs">
                        <i class="fa fa-arrows-alt" id="io"></i>
                    </a>
                </li>
                <?php
                    if (Yii::$app->user->identity->role =='admin') { ?>
                        <li class="dropdown notifications-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                <i class="fa fa-bell-o"></i>
                                <?php
                                    if ($tot > 0) { ?>
                                        <span class="label label-warning"><?= $tot ?> </span>
                                <?php } ?>
                            </a>
                            <ul class="dropdown-menu">
                                <li class="header">
                                    <?php 
                                        if ($tot <= 0) {
                                            echo 'Belum ada notifikasi';
                                        }else {
                                            echo 'Kamu mempunyai '.$tot.' notifikasi'; ?> 
                                </li>
                                <li>
                                    <ul class="menu">
                                        <li>
                                            <a href=" <?= $urlu ?> ">
                                                <i class="fa fa-users text-aqua"></i>
                                                <?= $uba['ubar'] ?> Member baru telah bergabung
                                            </a>
                                            <a href=" <?= $urlp ?> ">
                                                <i class="ion ion-ios-construct text-yellow"></i>
                                                <?= $per['perba'] ?> Perangkat baru hari ini
                                            </a>
                                            <a href=" <?= $urld ?> ">
                                                <i class="ion ion-ios-download text-red"></i>
                                                <?= $dasuk['jml'] ?> Data baru hari ini
                                            </a>
                                        </li>
                                    </ul>
                                <?php } ?>
                                </li>
                            </ul>
                        </li> 
                <?php } ?>
            
                <li class="dropdown user user-menu" >
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                      <?= Html::img('@web/images/profilephoto.png', ['alt'=>'User Image', 'class'=>'user-image']);?>

                        <span class="hidden-xs"><?= Yii::$app->user->identity->name ?></span>
                        <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu" style="width:200px;" >
                        <!-- User image -->
                        <li class="user-header" style="background-color: #3963A9;">
                          <?= Html::img('@web/images/profilephoto.png', ['alt'=>'User Image', 'class'=>'img-circle']);?>



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
