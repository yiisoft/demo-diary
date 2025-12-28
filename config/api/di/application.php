<?php

declare(strict_types=1);

use App\Presentation\Api\ResponseFactory\ExceptionResponderFactory;
use App\Presentation\Api\ResponseFactory\NotFoundMiddleware;
use Yiisoft\DataResponse\Formatter\JsonDataResponseFormatter;
use Yiisoft\DataResponse\Formatter\XmlDataResponseFormatter;
use Yiisoft\DataResponse\Middleware\ContentNegotiator;
use Yiisoft\DataResponse\Middleware\FormatDataResponseAsJson;
use Yiisoft\Definitions\DynamicReference;
use Yiisoft\Definitions\Reference;
use Yiisoft\ErrorHandler\Middleware\ErrorCatcher;
use Yiisoft\Hydrator\TypeCaster\CompositeTypeCaster;
use Yiisoft\Hydrator\TypeCaster\HydratorTypeCaster;
use Yiisoft\Hydrator\TypeCaster\PhpNativeTypeCaster;
use Yiisoft\Input\Http\HydratorAttributeParametersResolver;
use Yiisoft\Input\Http\RequestInputParametersResolver;
use Yiisoft\Middleware\Dispatcher\CompositeParametersResolver;
use Yiisoft\Middleware\Dispatcher\MiddlewareDispatcher;
use Yiisoft\Middleware\Dispatcher\ParametersResolverInterface;
use Yiisoft\Request\Body\RequestBodyParser;
use Yiisoft\Router\Middleware\Router;
use Yiisoft\Yii\Http\Application;

/** @var array $params */

return [
    Application::class => [
        '__construct()' => [
            'dispatcher' => DynamicReference::to([
                'class' => MiddlewareDispatcher::class,
                'withMiddlewares()' => [
                    [
                        ErrorCatcher::class,
                        FormatDataResponseAsJson::class,
                        static fn() => new ContentNegotiator([
                            'application/xml' => new XmlDataResponseFormatter(),
                            'application/json' => new JsonDataResponseFormatter(),
                        ]),
                        static fn(ExceptionResponderFactory $factory) => $factory->create(),
                        RequestBodyParser::class,
                        Router::class,
                        NotFoundMiddleware::class,
                    ],
                ],
            ]),
        ],
    ],

    ParametersResolverInterface::class => [
        'class' => CompositeParametersResolver::class,
        '__construct()' => [
            DynamicReference::to([
                'class' => HydratorAttributeParametersResolver::class,
                '__construct()' => [
                    'typeCaster' => DynamicReference::to(
                        static fn() => new CompositeTypeCaster(
                            new PhpNativeTypeCaster(),
                            new HydratorTypeCaster(),
                        ),
                    ),
                ],
            ]),
            Reference::to(RequestInputParametersResolver::class),
        ],
    ],
];
