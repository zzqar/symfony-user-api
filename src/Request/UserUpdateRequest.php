<?php

namespace App\Request;


use Symfony\Component\Validator\Constraints\Choice;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;


class UserUpdateRequest extends BaseRequest
{

    #[NotBlank(message: 'Имя не может быть пустым')]
    public string $name;

    #[NotBlank(message: 'Пароль не может быть пустым.')]
    public string $password;

    #[Email(message: "Некорректный email.")]
    public string $email;

    #[NotBlank(message: 'Телефон не может быть пустым.')]
    public string $phone;

    #[Choice(choices: [0,1], message: 'Некорректная пол: 0-муж.,1-жен.')]
    public int $sex;

    #[Date(message: 'Некорректная дата рождения.')]
    #[NotBlank(message: 'День рождения не может быть пустым.')]
    public string $birthday;
}
