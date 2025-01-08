<?php

namespace App\DTO;

use Symfony\Component\Validator\Constraints as Assert;

class UserLoginRequestPayload
{
    public function __construct(
        #[Assert\Email(message: 'Invalid email address')]
        #[Assert\NotBlank(message: 'Email cannot be blank')]
        private string $email,
        #[Assert\NotBlank(message: 'Password cannot be blank')]
        private string $password
    ) {}

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }
}
