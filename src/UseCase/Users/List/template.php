<?php

declare(strict_types=1);

use App\Presentation\Site\Layout\Breadcrumbs\Breadcrumb;
use App\Shared\UrlGenerator;
use App\UseCase\Users\List\DataReader\User;
use Yiisoft\Data\Db\QueryDataReader;
use Yiisoft\Html\Html;
use Yiisoft\Html\NoEncode;
use Yiisoft\View\WebView;
use Yiisoft\Yii\DataView\GridView\Column\ActionButton;
use Yiisoft\Yii\DataView\GridView\Column\ActionColumn;
use Yiisoft\Yii\DataView\GridView\Column\DataColumn;
use Yiisoft\Yii\DataView\GridView\GridView;

/**
 * @var WebView $this
 * @var UrlGenerator $urlGenerator
 * @var QueryDataReader<array-key,User> $dataReader
 */

$this->setTitle('Users');
$this->addToParameter('breadcrumbs', new Breadcrumb('Users'));
?>
<div class="d-flex justify-content-between align-items-center">
    <h1>Users</h1>
    <?= Html::a(
        NoEncode::string('<i class="bi bi-person-plus me-1"></i> Create user'),
        $urlGenerator->generate('user/create'),
        ['class' => 'btn btn-outline-primary btn-sm'],
    ) ?>
</div>
<?= GridView::widget()
    ->dataReader($dataReader)
    ->containerClass('mt-4')
    ->columns(
        new DataColumn(
            'id',
            header: 'ID',
            filter: true,
        ),
        new DataColumn(
            'login',
            filter: true,
        ),
        new DataColumn(
            'name',
            filter: true,
        ),
        new DataColumn(
            'status',
            content: static fn(User $user) => $user->status->label(),
        ),
        new DataColumn(
            'roles',
            header: 'Role',
            content: static fn(User $user) => implode(
                ', ',
                array_map(
                    static fn($role) => $role->label(),
                    $user->roles,
                ),
            ),
        ),
        new ActionColumn(
            before: '<div class="btn-group">',
            after: '</div>',
            buttons: [
                new ActionButton(
                    Html::i()->class('bi bi-pencil'),
                    static fn(User $user) => $urlGenerator->generate('user/update', ['id' => $user->id]),
                    title: 'Update',
                ),
                new ActionButton(
                    Html::i()->class('bi bi-key'),
                    static fn(User $user) => $urlGenerator->generate('user/change-password', ['id' => $user->id]),
                    title: 'Change password',
                ),
                new ActionButton(
                    Html::i()->class('bi bi-x-lg'),
                    static fn(User $user) => $urlGenerator->generate('user/delete', ['id' => $user->id]),
                    title: 'Delete',
                ),
            ],
        ),
    )
?>
