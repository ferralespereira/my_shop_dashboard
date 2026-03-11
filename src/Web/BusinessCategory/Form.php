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

    public ?string $description = null;
}