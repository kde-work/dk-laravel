<?php

namespace App\DTO;

class UserLoginDTO
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
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            throw new \InvalidArgumentException($validator->errors()->first());
        }
    }
}
