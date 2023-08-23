<?php

namespace App\Services;

use App\Models\Company;
use App\Repositories\CompanyRepository;

class CompanyService {
    private CompanyRepository $repository;

    public function __construct(CompanyRepository $repository) {
        $this->repository = $repository;
    }

    public function createCompany($name, $logo): Company {
        return $this->repository->createCompany($name, $logo);
    }

    public function updateCompany($companyById, $name, $logo) {
        return $this->repository->updateCompany($companyById, $name, $logo);
    }

    public function findCompanyById($id) {
        return $this->repository->findCompanyById($id);
    }

    public function findCompanyByName($name) {
        return $this->repository->findCompanyByName($name);
    }

    public function getRelationWithLoggedUser() {
        return $this->repository->getRelationWithLoggedUser();
    }

    public function getRelationWithUser() {
        return $this->repository->getRelationWithUser();
    }
}
