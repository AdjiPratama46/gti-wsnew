<?php
$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';
$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'modules' => [
        'gridview' => [
            'class' => 'kartik\grid\Module',
            'downloadAction' => 'export',
            // other module settings
        ]
    ],
    'components' => [
          'formatter' => [
               'dateFormat' => 'Y-M-d',
               'datetimeFormat' => 'Y-m-d H:i:s',
               'timeFormat' => 'H:i',
               'locale' => 'de-DE', //your language locale
               'defaultTimeZone' => 'Europe/Berlin', // time zone
          ],
          'assetManager' => [
            'bundles' => [
                'dosamigos\google\maps\MapAsset' => [
                    'options' => [
                        //'key' => 'AIzaSyCEKkG9jlRbavkuE6unDPFGjZ6Ur5cYjHM',
                        'key' => 'AIzaSyAXfaI-Fbkct2TMoZ5EeJVwLoDxPKco54Q',
                        'language' => 'id',
                        'version' => '3.1.18'
                    ]
                ]
            ],
        ],
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'tYc-wH6CnxOVmQeH7GUCXCgy_Is704oq',
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ]
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => $db,
        'urlManager' => [
            'enablePrettyUrl' => true,
            //'showScriptName' => true,
            //'enableStrictParsing' => true,
            'rules' => [
                            ['class' => 'yii\rest\UrlRule',
                            'controller' => 'papi'],

                            ['class' => 'yii\rest\UrlRule',
                            'controller' => 'dapi'],

                            ['class' => 'yii\rest\UrlRule',
                            'controller' => 'upi'],
                        ],
        ],
    ],
    'params' => $params,
];
if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];
    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}
return $config;
