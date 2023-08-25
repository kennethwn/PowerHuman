<?php

namespace App\Services;

use App\Models\Role;
use App\Repositories\RoleRepository;

class RoleService {
    private $repository;

    public function __construct(RoleRepository $roleRepository) {
        $this->repository = $roleRepository;
    }

    public function createRole($name, $company_id): Role {
        return $this->repository->createRole($name, $company_id);
    }

    public function updateRole($role, $name, $company_id) {
        return $this->repository->updateRole($role, $name, $company_id);
    }

    public function findRoleById($id): Role {
        return $this->repository->findRoleById($id);
    }

    public function findRoleByName($company_id, $name): Role {
        return $this->repository->findRoleByName($company_id, $name);
    }

    public function getAllRoles($company_id) {
        return $this->repository->getAllRoles($company_id);
    }
}
