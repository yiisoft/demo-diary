<?php

declare(strict_types=1);

namespace App\Tests\Functional;

use App\Tests\Support\FunctionalTester;
use HttpSoft\Message\ServerRequest;

use function PHPUnit\Framework\assertSame;
use function PHPUnit\Framework\assertStringContainsString;

final class ContactCest
{
    public function base(FunctionalTester $tester): void
    {
        $response = $tester->sendSiteRequest(
            new ServerRequest(uri: '/contact'),
        );

        assertSame(200, $response->getStatusCode());
        assertStringContainsString(
            '<h1>Contact</h1>',
            $response->getBody()->getContents(),
        );
    }
}
