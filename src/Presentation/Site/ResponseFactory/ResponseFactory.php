<?php

declare(strict_types=1);

namespace App\Presentation\Site\ResponseFactory;

use App\Presentation\Site\Layout\Layout;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Yiisoft\Http\Status;
use Yiisoft\Yii\View\Renderer\ViewRenderer;

final readonly class ResponseFactory implements ResponseFactoryInterface
{
    public function __construct(
        private ResponseFactoryInterface $responseFactory,
        private ViewRenderer $viewRenderer,
    ) {}

    public function createResponse(int $code = 200, string $reasonPhrase = ''): ResponseInterface
    {
        return $this->responseFactory->createResponse($code, $reasonPhrase);
    }

    public function temporarilyRedirect(string $url, ?ResponseInterface $response = null): ResponseInterface
    {
        return ($response ?? $this->createResponse())
            ->withStatus(Status::FOUND)
            ->withHeader('Location', $url);
    }

    public function notFound(string $title = 'Page not found', string $description = ''): ResponseInterface
    {
        return $this->viewRenderer
            ->withLayout(Layout::ERROR)
            ->render(__DIR__ . '/not-found.php', ['title' => $title, 'description' => $description])
            ->withStatus(Status::NOT_FOUND);
    }

    public function accessDenied(): ResponseInterface
    {
        return $this->viewRenderer
            ->withLayout(Layout::ERROR)
            ->render(__DIR__ . '/access-denied.php')
            ->withStatus(Status::FORBIDDEN);
    }

    /**
     * @param array<string, mixed> $parameters
     */
    public function render(string $view, array $parameters = [], string $layout = Layout::MAIN): ResponseInterface
    {
        return $this->viewRenderer->withLayout($layout)->render($view, $parameters);
    }
}
