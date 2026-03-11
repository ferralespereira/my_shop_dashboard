<?php

declare(strict_types=1);

namespace App\Web\BusinessCategory;

use Yiisoft\FormModel\FormModel;
use Yiisoft\Validator\Rule\Length;
use Yiisoft\Validator\Rule\Required;

final class Form extends FormModel
{
    #[Required]
    #[Length(min: 1, max: 255)]
    public ?string $name = null;

    #[Length(min: 0, max: 1000)]
    public ?string $description = null;
}