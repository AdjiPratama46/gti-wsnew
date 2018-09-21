<aside class="main-sidebar">

    <section class="sidebar">

        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
              <img src="images/profilephoto.png" width="160" height="160" class="img-circle" alt="User Image"/>

            </div>
            <div class="pull-left info">
                <p><?= Yii::$app->user->identity->name ?></p>

                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>

        <!-- search form -->

        <!-- /.search form -->

        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu tree', 'data-widget'=> 'tree'],
                'items' => [
                    ['label' => 'Dashboard', 'icon' => 'file-code-o', 'url' => ['/gii'],
                      'options' => ['id' => 'menu1']
                    ],
                    ['label' => 'Perangkat', 'icon' => 'dashboard', 'url' => ['perangkat/index'],
                      'options' => ['id' => 'menu2']
                    ],
                    ['label' => 'Data harian', 'icon' => 'dashboard', 'url' => ['/debug'],
                      'options' => ['id' => 'menu3']
                    ],
                    ['label' => 'Resume', 'icon' => 'dashboard', 'url' => ['/debug'],
                      'options' => ['id' => 'menu4']
                    ],
                    ['label' => 'Profile', 'icon' => 'user', 'url' => ['/user/index'],
                      'options' => ['id' => 'menu5']
                    ],
                    ['label' => 'Login', 'url' => ['site/login'], 'visible' => Yii::$app->user->isGuest],

                ],
            ]
        ) ?>

    </section>

</aside>
