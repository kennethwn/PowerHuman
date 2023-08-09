<?php

namespace App\Services;

use App\Models\Company;
use App\Repositories\CompanyRepository;

class CompanyService {
    private CompanyRepository $repository;

    public function __construct(CompanyRepository $repository) {
        $this->repository = $repository;
    }

    public function findCompanyById($id): Company {
        return $this->repository->findCompanyById($id);
    }

    public function findCompanyByName($name): Company {
        return $this->repository->findCompanyByName($name);
    }

    public function getRelation() {
        return $this->repository->getRelationWithUser();
    }
}
