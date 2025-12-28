<?php

declare(strict_types=1);

namespace App\Presentation\Api\ResponseFactory\Presenter;

use Yiisoft\Data\Paginator\OffsetPaginator;
use Yiisoft\DataResponse\DataResponse;

/**
 * @implements PresenterInterface<OffsetPaginator>
 */
final readonly class OffsetPaginatorPresenter implements PresenterInterface
{
    private CollectionPresenter $collectionPresenter;

    public function __construct(
        PresenterInterface $itemPresenter = new AsIsPresenter(),
    ) {
        $this->collectionPresenter = new CollectionPresenter($itemPresenter);
    }

    public function present(mixed $value, DataResponse $response): DataResponse
    {
        $collectionResponse = $this->collectionPresenter->present($value->read(), $response);
        return $collectionResponse->withData([
            'items' => $collectionResponse->getData(),
            'page_size' => $value->getPageSize(),
            'current_page' => $value->getCurrentPage(),
            'total_pages' => $value->getTotalPages(),
        ]);
    }
}
