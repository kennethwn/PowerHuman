<?php

namespace App\Services;

use App\Models\Employee;
use App\Repositories\EmployeeRepository;

class EmployeeService {
    protected $repository;

    public function __construct(EmployeeRepository $repository) {
        $this->repository = $repository;
    }

    public function createEmployee(
        $name,
        $email,
        $gender,
        $age,
        $phone,
        $photo,
        $team_id,
        $role_id
    ): Employee {
        return $this->repository->createEmployee(
            $name,
            $email,
            $gender,
            $age,
            $phone,
            $photo,
            $team_id,
            $role_id
        );
    }

    public function updateEmployee(
        $employee,
        $name,
        $email,
        $gender,
        $age,
        $phone,
        $photo,
        $team_id,
        $role_id
    ) {
        return $this->repository->updateEmployee(
            $employee,
            $name,
            $email,
            $gender,
            $age,
            $phone,
            $photo,
            $team_id,
            $role_id
        );
    }

    public function findEmployeeById($id): Employee {
        return $this->repository->findEmployeeById($id);
    }

    public function findEmployeeByName($name) {
        return $this->repository->findEmployeeByName($name);
    }

    public function findEmployeeByEmail($email) {
        return $this->repository->findEmployeeByEmail($email);
    }

    public function findEmployeeByAge($age) {
        return $this->repository->findEmployeeByAge($age);
    }

    public function findEmployeeByPhone($phone) {
        return $this->repository->findEmployeeByPhone($phone);
    }

    public function findEmployeeByRole($role_id) {
        return $this->repository->findEmployeeByRole($role_id);
    }

    public function findEmployeeByTeam($team_id) {
        return $this->repository->findEmployeeByTeam($team_id);
    }

    public function getAllEmployees() {
        return $this->repository->getAllEmployees();
    }
}
