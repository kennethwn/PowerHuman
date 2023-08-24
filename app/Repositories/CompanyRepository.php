<?php

namespace App\Repositories;

use App\Models\Company;
use Illuminate\Support\Facades\Auth;

class CompanyRepository {
    protected $company;

    public function __construct(Company $company) {
        $this->company = $company;
    }

    public function createCompany($name, $path): Company {
        return Company::create([
            'name' => $name,
            'logo' => $path
        ]);
    }

    public function updateCompany($companyById, $name, $path) {
        return $companyById->update([
            'name' => $name,
            'logo' => $path
        ]);
    }

    public function findCompanyById($id) {
        return $this->getAllCompanies()->find($id);
    }

    public function findCompanyByName($name) {
        return $this->getAllCompanies()->where('name', 'like', '%'.$name.'%')->first();
    }

    public function getAllCompanies() {
        return Company::whereHas('users', function ($query) {
            $query->where('user_id', Auth::id());
        });
    }
}
