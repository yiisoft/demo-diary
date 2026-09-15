<?php

declare(strict_types=1);

use App\Environment;
use Yiisoft\Log\StreamTarget;
use Yiisoft\Log\Target\File\FileTarget;

return [
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

    'yiisoft/log' => [
        'targets' => [
            'file' => FileTarget::class,
            'stream' => StreamTarget::class,
        ],
    ],
];
