<?php

namespace App\DTO;

class UserRegistrationDTO
{
    public function __construct(
        public string $email,
        public string $password
    )
    {
        $this->validate();
    }

    private function validate(): void
    {
        $validator = validator([
            'email' => $this->email,
            'password' => $this->password,
        ], [
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
        ]);

        if ($validator->fails()) {
            throw new \InvalidArgumentException($validator->errors()->first());
        }
    }
}
