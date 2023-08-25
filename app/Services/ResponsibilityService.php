<?php

namespace App\Services;

use App\Models\Responsibility;
use App\Repositories\ResponsibilityRepository;

class ResponsibilityService {
    private ResponsibilityRepository $repository;

    public function __construct(ResponsibilityRepository $responsibilityRepository) {
        $this->repository = $responsibilityRepository;
    }

    public function createResponsibility($name, $role_id): Responsibility {
        return $this->repository->createResponsibility($name, $role_id);
    }

    public function findResponsibilityById($id) {
        return $this->repository->findResponsibilityById($id);
    }

    public function findResponsibilityByName($name, $role_id) {
        return $this->repository->findResponsibilityByName($name, $role_id);
    }

    public function getAllResponsibilityByRole($role_id) {
        return $this->repository->getAllResponsibilitiesByRole($role_id);
    }

}
