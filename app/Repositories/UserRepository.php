<?php

namespace App\Repositories;

use App\User;
use App\Repositories\UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface
{
    public function store(array $data)
    {
        return User::create([
            'name'    => $data['email'],
            'email'    => $data['email'],
            'password' => $data['password'],
        ]);
    }
}
