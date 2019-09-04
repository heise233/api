<?php

$params = array_merge(
        require(__DIR__ . '/../../common/config/params.php'),
        require(__DIR__ . '/../../common/config/params-local.php'),
        require(__DIR__ . '/params.php'),
        require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-api',
    'language' => 'zh-CN',
    'basePath' => dirname(__DIR__),
    'defaultRoute' => 'v1/user',
    'controllerNamespace' => 'api\controllers',
    'bootstrap' => [
        'log',
        [
            'class' => 'yii\filters\ContentNegotiator',
            'formats' => [
                'application/json' => yii\web\Response::FORMAT_JSON,
                //'application/xml' => yii\web\Response::FORMAT_XML,
            ],
        ]
    ],
    'modules' => [
        'v1' => [
            'class' => 'api\modules\v1\Module'
        ]
    ],
    'components' => [
        'tools' => [
            'class' => 'api\components\Tools'
        ],
        'user' => [
            'identityClass' => 'api\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => [
                'name' => '_identity-api',
                'httpOnly' => true
            ],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'advanced-api',
        ],
        'request' => [
            'cookieValidationKey' => 'BLt7chH5PYCV6zTeMQjZ7ThmB5Rk_rY4',
            'parsers' => [
                'application/json' => 'yii\web\JsonParser'
            ]
        ],
        'i18n' => [
            'translations' => [//多语言包设置
                'app*' => [
                    'class' => yii\i18n\PhpMessageSource::className(),
                    'basePath' => '@api/messages',
                    'sourceLanguage' => 'zh',
                    'fileMap' => [
                        'app' => 'app.php',
                        'app/error' => 'error.php',
                    ],
                ]
            ],
        ],
        'response' => [
            'class' => 'yii\web\Response',
            'as resBeforeSend' => [
                'class' => 'api\components\ResBeforeSendBehavior',
                'defaultCode' => 500,
                'defaultMsg' => 'error',
            ],
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
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'enableStrictParsing' => false,
            'suffix' => '',
            'rules' => [
                'POST v1/orders' => "v1/order/order-pay",
                "GET v1/users/<id:\d+>" => "v1/user/user-info",
                "<module:\w+>/<controller:\w+>/<action:\w+>/<id:\d+>" => "<module>/<controller>/<action>",
                "<controller:\w+>/<action:\w+>/<id:\d+>" => "<controller>/<action>",
                "<controller:\w+>/<action:\w+>" => "<controller>/<action>",
            ],
        ]
    ],
    'params' => $params,
];
