<?php

declare(strict_types=1);

use App\Environment;
use Yiisoft\Log\StreamTarget;
use Yiisoft\Log\Target\File\FileTarget;

return [
    'app' => [
        'contactEmail' => 'admin@example.com',
        // Symfony Mailer DSN. `null://null` accepts every message without delivering it; set a real transport, such as
        // `smtp://user:pass@smtp.example.com:587`, where mail must leave the application.
        'mailerDsn' => 'null://null',
    ],

    'yii3/debug' => [
        'application' => [
            'name' => 'Yii3 Demo Diary',
            'version' => '1.0',
            'charset' => 'UTF-8',
            'language' => 'en',
            'sourceLanguage' => 'en',
            'debug' => Environment::appDebug(),
        ],
    ],

    'yiisoft/aliases' => [
        'aliases' => require __DIR__ . '/aliases.php',
    ],

    'yiisoft/mailer-symfony' => [
        'messageSettings' => [
            'from' => ['noreply@example.com' => 'Yii3 Demo Diary'],
        ],
    ],

    'yiisoft/log' => [
        'targets' => [
            'file' => FileTarget::class,
            'stream' => StreamTarget::class,
        ],
    ],
];
