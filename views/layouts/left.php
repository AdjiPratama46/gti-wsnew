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
      <?= dmstr\widgets\Menu::widget(
                [
                    'options' => ['class' => 'sidebar-menu tree', 'data-widget'=> 'tree'],
                    'items' => [
                        ['label' => 'Dashboard', 'icon' => 'dashboard', 'url' => ['site/index'],
                          'options' => ['id' => 'menu1']
                        ],
                        ['label' => 'Users', 'icon' => 'users', 'url' => ['user/index'],
                            'visible' => Yii::$app->user->identity->role=='admin',
                            'options' => ['id' => 'menu5']
                        ],
                        [
                                'label' => 'Perangkat',
                                'visible' => Yii::$app->user->identity->role=='user',
                                'icon' => 'th-large',
                                'url' => '#',
                                'items' => [
                                  ['label' => 'Pengajuan Perangkat', 'icon' => 'share', 'url' => ['permintaan/index'],
                                      'options' => ['id' => 'menu2']
                                  ],
                                  ['label' => 'Perangkat Saya', 'icon' => 'tasks', 'url' => ['perangkat/index'],
                                      'options' => ['id' => 'menu2']
                                  ],
                                ],
                            ],
                        [
                                'label' => 'Perangkat',
                                'visible' => Yii::$app->user->identity->role=='admin',
                                'icon' => 'th-large',
                                'url' => '#',
                                'items' => [
                                  ['label' => 'Pengajuan Perangkat', 'icon' => 'inbox', 'url' => ['permintaan/index'],
                                      'options' => ['id' => 'menu2']
                                  ],
                                  ['label' => 'Perangkat Aktif', 'icon' => 'check', 'url' => ['perangkat/index'],
                                      'options' => ['id' => 'menu2']
                                  ],
                                  ['label' => 'Perangkat Tidak Aktif', 'icon' => 'remove', 'url' => ['temptable/index'],
                                      'options' => ['id' => 'menu2']
                                  ],
                                ],
                            ],
                        ['label' => 'Data Harian', 'icon' => 'calendar', 'url' => ['data/index'],
                            'options' => ['id' => 'menu3']
                        ],
                        ['label' => 'Resume', 'icon' => 'list-alt', 'url' => ['resume/index'],
                            'options' => ['id' => 'menu4']
                        ],


                        [
                                'label' => 'Mqtt',
                                'visible' => Yii::$app->user->identity->role=='admin',
                                'icon' => 'wrench',
                                'url' => '#',
                                'items' => [
                                  ['label' => 'Mqtt Konfigurasi', 'icon' => 'cog', 'url' => ['mqtt/konfig'],
                                      'options' => ['id' => 'menu4']
                                  ],
                                  ['label' => 'Riwayat Konfigurasi', 'icon' => 'list', 'url' => ['mqtt/index'],
                                      'options' => ['id' => 'menu4']
                                  ],
                                ],
                            ],

                        ['label' => 'Login', 'url' => ['site/login'], 'visible' => Yii::$app->user->isGuest],

                    ],
                ]
            );
        ?>

    </section>

</aside>
