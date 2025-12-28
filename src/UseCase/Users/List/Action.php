<?php

declare(strict_types=1);

namespace App\UseCase\Users\List;

use App\Presentation\Site\ResponseFactory\ResponseFactory;
use App\UseCase\Users\List\DataReader\UserDataReader;
use Psr\Http\Message\ResponseInterface;

final readonly class Action
{
    public function __construct(
        private UserDataReader $userDataReader,
        private ResponseFactory $responseFactory,
    ) {}

    public function __invoke(): ResponseInterface
    {
        return $this->responseFactory->render(
            __DIR__ . '/template.php',
            [
                'dataReader' => $this->userDataReader,
            ],
        );
    }
}
