<?php

declare(strict_types=1);

namespace App\UseCase\Contact;

use App\Presentation\Site\Layout\ContentNotices\ContentNotices;
use App\Presentation\Site\ResponseFactory\ResponseFactory;
use App\Shared\UrlGenerator;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Yiisoft\FormModel\FormHydrator;
use Yiisoft\Mailer\MailerInterface;
use Yiisoft\Mailer\Message;

final readonly class Action
{
    public function __construct(
        private ResponseFactory $responseFactory,
        private FormHydrator $formHydrator,
        private UrlGenerator $urlGenerator,
        private ContentNotices $contentNotices,
        private MailerInterface $mailer,
        private string $contactEmail,
    ) {}

    public function __invoke(ServerRequestInterface $request): ResponseInterface
    {
        $form = new Form();
        if (!$this->formHydrator->populateFromPostAndValidate($form, $request)) {
            return $this->responseFactory->render(
                __DIR__ . '/template.php',
                ['form' => $form],
            );
        }

        $this->mailer->send(
            new Message(
                to: $this->contactEmail,
                replyTo: [$form->email => $form->name],
                subject: $form->subject,
                textBody: $form->body,
            ),
        );

        $this->contentNotices->success('Thank you for contacting us. We will respond to you as soon as possible.');
        return $this->responseFactory->temporarilyRedirect(
            $this->urlGenerator->contact(),
        );
    }
}
