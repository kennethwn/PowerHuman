<?php

namespace App\Repositories;

use App\Models\Role;

class RoleRepository {
    protected $role;

    public function __construct(Role $role) {
        $this->role = $role;
    }

    public function createRole($name, $company_id): Role {
        return Role::create([
            'name' => $name,
            'company_id' => $company_id
        ]);
    }

    public function updateRole($role, $name, $company_id) {
        return $role->update([
            'name' => $name,
            'company_id' => $company_id
        ]);
    }

    public function findRoleById($id): Role {
        return Role::find($id);
    }

    public function findRoleByName($company_id, $name) {
        return $this->getAllRoles($company_id)->where('name', 'like', '%'.$name.'%');
    }

    public function getAllRoles($company_id) {
        return Role::where('company_id', $company_id);
    }
}
