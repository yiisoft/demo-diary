<?php

declare(strict_types=1);

namespace App\Presentation\Api\ResponseFactory\Presenter;

use Yiisoft\DataResponse\DataResponse;

/**
 * @template T
 */
interface PresenterInterface
{
    /**
     * @param T $value
     */
    public function present(mixed $value, DataResponse $response): DataResponse;
}
