<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserRepository {
    protected $user;

    public function __construct(User $user) {
        $this->user = $user;
    }

    public function createUser($name, $email, $password): User {
        return User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password)
        ]);
    }

    public function findUserByEmail($email): User {
        return User::where('email', $email)->firstOrFail();
    }
}
