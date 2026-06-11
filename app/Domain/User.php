<?php

namespace App\Domain;

class User {
    public ?int $id;
    public string $username;
    public string $email;
    public string $password;
    public ?string $created_at;

    public function __construct(string $username, string $email, string $password) {
        $this->username = $username;
        $this->email = $email;
        $this->password = $password;
    }
}
