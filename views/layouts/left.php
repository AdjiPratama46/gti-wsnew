<aside class="main-sidebar" style="position:fixed;">
    <section class="sidebar">

        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
              <?php
              use yii\helpers\Html;
               ?>
               <?= Html::img('@web/images/profilephoto.png', ['alt'=>'some', 'class'=>'img-circle']);?>
              
            </div>
            <div class="pull-left info">
                <p id="namauser"><?= Yii::$app->user->identity->name ?></p>

                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>

      <hr style="border:0.5px solid #4F7BC3;width:60%;">
      <?php
        if (Yii::$app->user->identity->role=='admin') {
            echo 
            dmstr\widgets\Menu::widget(
                [
                    'options' => ['class' => 'sidebar-menu tree', 'data-widget'=> 'tree'],
                    'items' => [
                        ['label' => 'Dashboard', 'icon' => 'dashboard', 'url' => ['site/index'],
                          'options' => ['id' => 'menu1']
                        ],
                        ['label' => 'Users', 'icon' => 'users', 'url' => ['user/index'],
                            'options' => ['id' => 'menu5']
                        ],
                        ['label' => 'Perangkat', 'icon' => 'th-large', 'url' => ['perangkat/index'],
                          'options' => ['id' => 'menu2']
                        ],
                        ['label' => 'Data Harian', 'icon' => 'calendar', 'url' => ['data/index'],
                          'options' => ['id' => 'menu3']
                        ],
                        ['label' => 'Resume', 'icon' => 'list-alt', 'url' => ['resume/index'],
                            'options' => ['id' => 'menu4']
                        ],
                        
                        ['label' => 'Login', 'url' => ['site/login'], 'visible' => Yii::$app->user->isGuest],
    
                    ],
                ]
                );
        }else {
            echo 
            dmstr\widgets\Menu::widget(
                [
                    'options' => ['class' => 'sidebar-menu tree', 'data-widget'=> 'tree'],
                    'items' => [
                        ['label' => 'Dashboard', 'icon' => 'dashboard', 'url' => ['site/index'],
                          'options' => ['id' => 'menu1']
                        ],
                        ['label' => 'Perangkat', 'icon' => 'th-large', 'url' => ['perangkat/index'],
                          'options' => ['id' => 'menu2']
                        ],
                        ['label' => 'Data Harian', 'icon' => 'calendar', 'url' => ['data/index'],
                          'options' => ['id' => 'menu3']
                        ],
                        ['label' => 'Resume', 'icon' => 'list-alt', 'url' => ['resume/index'],
                            'visible' => Yii::$app->user->identity->role=='admin',  
                            'options' => ['id' => 'menu4']
                        ],
                        ['label' => 'Login', 'url' => ['site/login'], 'visible' => Yii::$app->user->isGuest],
    
                    ],
                ]
                );
        }
      ?>

    </section>

</aside>
