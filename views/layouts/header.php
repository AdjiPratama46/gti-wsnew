<?php
use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $content string */
?>

<header class="main-header" style="position:fixed;width:100%;border-bottom:1px solid #4F7BC3;">

      <a href="/" class="logo" style="background-color:#2F5189;" >
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
                      <img src="images/profilephoto.png" width="160" height="160" class="user-image" alt="User Image"/>

                        <span class="hidden-xs"><?= Yii::$app->user->identity->name ?></span>
                    </a>
                    <ul class="dropdown-menu" style="width:200px;" >
                        <!-- User image -->
                        <li class="user-header" style="background-color: #E7E7E7;">
                          <img src="images/profilephoto.png" width="160" height="160" class="img-circle" alt="User Image"/>


                            <p style="color:#222D32;">
                                <?= Yii::$app->user->identity->name ?>
                            </p>
                            <hr style="border:0.5px solid #4F7BC3;width:60%;">

                        </li>

                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="pull-left">
                                <a href="#" class="btn btn-primary btn-xs btn-flat">Profile</a>
                            </div>
                            <div class="pull-right">
                                <?= Html::a(
                                    'Sign out',
                                    ['/site/logout'],
                                    ['data-method' => 'post', 'class' => 'btn btn-danger btn-xs btn-flat']
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
