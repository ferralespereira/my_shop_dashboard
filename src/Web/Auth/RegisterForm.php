<?php

declare(strict_types=1);

namespace App\Web\Auth;

use Yiisoft\FormModel\FormModel;
use Yiisoft\Validator\Rule\Email;
use Yiisoft\Validator\Rule\Length;
use Yiisoft\Validator\Rule\Required;

final class RegisterForm extends FormModel
{
    #[Required]
    #[Email]
    public string $email = '';

    #[Required]
    #[Length(min: 6, max: 255)]
    public string $password = '';

    #[Required]
    #[Length(min: 6, max: 255)]
    public string $passwordConfirm = '';

    public function passwordsMatch(): bool
    {
        return $this->password === $this->passwordConfirm;
    }
}