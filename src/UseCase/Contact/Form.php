<?php

declare(strict_types=1);

namespace App\UseCase\Contact;

use Yiisoft\FormModel\FormModel;
use Yiisoft\Hydrator\Attribute\Parameter\Trim;
use Yiisoft\Validator\Rule\Email;
use Yiisoft\Validator\Rule\Length;
use Yiisoft\Validator\Rule\Required;

final class Form extends FormModel
{
    #[Trim]
    #[Required]
    #[Length(max: 100)]
    public string $name = '';

    #[Trim]
    #[Required]
    #[Email]
    public string $email = '';

    #[Trim]
    #[Required]
    #[Length(max: 200)]
    public string $subject = '';

    #[Trim]
    #[Required]
    public string $body = '';
}
