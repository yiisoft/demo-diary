<?php

declare(strict_types=1);

use App\UseCase\Contact\Action as ContactAction;
use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mailer\Transport\TransportInterface;

/** @var array $params */

return [
    TransportInterface::class => static fn(): TransportInterface => Transport::fromDsn($params['app']['mailerDsn']),

    ContactAction::class => [
        '__construct()' => [
            'contactEmail' => $params['app']['contactEmail'],
        ],
    ],
];
