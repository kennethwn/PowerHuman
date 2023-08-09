<?php

namespace App\Repositories;

use App\Models\Company;

class CompanyRepository {
    protected $company;

    public function __construct(Company $company) {
        $this->company = $company;
    }

    public function findCompanyById($id): Company {
        return $this->getRelationWithUser()->find($id);
    }

    public function findCompanyByName($name): Company {
        return $this->getRelationWithUser()->where('name', 'like', '%'. $name .'%')->get();
    }

    public function getRelationWithUser() {
        return Company::with('users');
    }
}
