<?php

declare(strict_types=1);

use App\Presentation\Site\Layout\Breadcrumbs\Breadcrumb;
use App\Shared\UrlGenerator;
use App\UseCase\Contact\Form;
use Yiisoft\FormModel\FieldFactory;
use Yiisoft\Html\Html;
use Yiisoft\View\WebView;
use Yiisoft\Yii\View\Renderer\Csrf;

/**
 * @var WebView $this
 * @var Csrf $csrf
 * @var UrlGenerator $urlGenerator
 * @var Form $form
 */

$this->setTitle('Contact');
$this->addToParameter(
    'breadcrumbs',
    new Breadcrumb('Contact'),
);

$field = new FieldFactory();
?>
<h1>Contact</h1>
<p class="text-body-secondary">
    If you have business inquiries or other questions, please fill out the following form to contact us.
</p>
<div class="row mt-4">
    <div class="col-md-6">
        <?= $field->errorSummary($form)->onlyCommonErrors() ?>
        <?= Html::form()
            ->post($urlGenerator->contact())
            ->csrf($csrf)
            ->open() ?>
        <?= $field->text($form, 'name') ?>
        <?= $field->email($form, 'email') ?>
        <?= $field->text($form, 'subject') ?>
        <?= $field->textarea($form, 'body') ?>
        <?= $field->submitButton('Send') ?>
        <?= '</form>' ?>
    </div>
</div>
