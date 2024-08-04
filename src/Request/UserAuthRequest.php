<?php

namespace App\Request;


use Symfony\Component\Validator\Constraints\Choice;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;


class UserAuthRequest extends BaseRequest
{
    #[NotBlank(message: 'Логин не может быть пустым')]
    public string $login;

    #[NotBlank(message: 'Пароль не может быть пустым.')]
    public string $password;
}
