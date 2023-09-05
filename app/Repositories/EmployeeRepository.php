<?php

namespace App\Repositories;

use App\Models\Employee;

class EmployeeRepository {
    protected $employee;

    public function __construct(Employee $employee) {
        $this->employee = $employee;
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
        return Employee::create([
            'name' => $name,
            'email' => $email,
            'gender' => $gender,
            'age' => $age,
            'phone' => $phone,
            'photo' => $photo,
            'team_id' => $team_id,
            'role_id' => $role_id
        ]);
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
        return $employee->update([
            'name' => $name,
            'email' => $email,
            'gender' => $gender,
            'age' => $age,
            'phone' => $phone,
            'photo' => isset($photo) ? $photo : $employee->photo,
            'team_id' => $team_id,
            'role_id' => $role_id
        ]);
    }

    public function findEmployeeById($id): Employee {
        return Employee::find($id);
    }

    public function findEmployeeByName($name) {
        return $this->getAllEmployees()->where('name', 'like', '%'.$name.'%');
    }

    public function findEmployeeByEmail($email) {
        return $this->getAllEmployees()->where('email', $email);
    }

    public function findEmployeeByAge($age) {
        return $this->getAllEmployees()->where('age', $age);
    }

    public function findEmployeeByPhone($phone) {
        return $this->getAllEmployees()->where('phone', 'like', '%'.$phone.'%');
    }

    public function findEmployeeByRole($role_id) {
        return $this->getAllEmployees()->where('role_id', $role_id);
    }

    public function findEmployeeByTeam($team_id) {
        return $this->getAllEmployees()->where('team_id', $team_id);
    }

    public function getAllEmployees() {
        return Employee::query();
    }
}
