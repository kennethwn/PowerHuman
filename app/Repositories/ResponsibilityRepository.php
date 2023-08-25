<?php

namespace App\Repositories;

use App\Models\Responsibility;

class ResponsibilityRepository {
    private $responsibility;

    public function __construct(Responsibility $responsibility) {
        $this->responsibility = $responsibility;
    }

    public function createResponsibility($name, $role_id): Responsibility {
        return Responsibility::create([
            'name' => $name,
            'role_id' => $role_id
        ]);
    }

    public function findResponsibilityById($id) {
        return Responsibility::find($id);
    }

    public function findResponsibilityByName($name, $role_id) {
        return $this->getAllResponsibilitiesByRole($role_id)->where('name', 'like', '%'.$name.'%');
    }

    public function getAllResponsibilitiesByRole($role_id) {
        return Responsibility::where('role_id', $role_id);
    }
}
