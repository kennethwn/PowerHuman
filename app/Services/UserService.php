<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\UserRepository;

class UserService {
    private $userRepository;

    public function __construct(UserRepository $userRepository) {
        $this->userRepository = $userRepository;
    }

    public function createUser($name, $email, $password): User {
        return $this->userRepository->createUser($name, $email, $password);
    }

    public function findUserByEmail($email): User {
        return $this->userRepository->findUserByEmail($email);
    }
}
