<?php

$config = [
    'components' => [
        'request' => [
            'enableCsrfValidation' => true,
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => '10xI6pUo4zNDaMSSzhekbdpnl5CGckrz',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@app/mail',
            'htmlLayout' => 'layouts/main-html',
            'textLayout' => 'layouts/main-text',
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'smtp.gmail.com',
                'username' => 'koozyy13@gmail.com',
                'password' => '125255503',
                'port' => '587',
                'encryption' => 'tls',
            ],
        ],
    ],
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        'generators'=>[
            'model' => ['class' => 'app\modules\gii\generators\model\Generator'],
            'crud' => ['class' => 'app\modules\gii\generators\crud\Generator'],
        ],
    ];
}

return $config;
