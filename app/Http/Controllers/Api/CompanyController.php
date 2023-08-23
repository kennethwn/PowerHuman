<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateCompanyRequest;
use App\Http\Requests\UpdateCompanyRequest;
use App\Models\Company;
use App\Models\User;
use App\Services\CompanyService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CompanyController extends Controller
{
    private CompanyService $service;

    public function __construct(CompanyService $companyService) {
        $this->service = $companyService;
    }

    public function fetch(Request $request) {
        $id = $request->input('id');
        $name = $request->input('name');
        $limit = $request->input('limit', 100);

        // for URL: powerhuman.com/api/company
        if (!$id && !$name) {
            $companies = $this->service->getRelationWithLoggedUser();
            return ResponseFormatter::success($companies->paginate($limit), 'Company found');
        }

        if ($id) {
            // for URL: powerhuman.com/api/company?id=<id_of_company>
            $company = $this->service->findCompanyById($id);
        }
        else {
            // for URL: powerhuman.com/api/company?name=<name_of_company>
            $company = $this->service->findCompanyByName($name);
        }


        if (!$company) {
            return ResponseFormatter::error(null, 404, 'not found', 'Company not found');
        }
        return ResponseFormatter::success($company, 'Company found');
    }

    public function createCompany(CreateCompanyRequest $request) {
        try {
            // Upload logo image
            if ($request->hasFile('logo')) {
                $path = $request->file('logo')->store('public\logo');
            }

            $company = $this->service->createCompany($request->name, $path);

            if (!$company) {
                return new Exception('Company not created');
            }

            $user = User::find(Auth::id());
            $user->companies()->attach($company->id);

            $company->load('users');
            return ResponseFormatter::success($company, 'Company created');
        }
        catch (Exception $e) {
            return ResponseFormatter::error(null, 500, 'failed', $e->getMessage());
        }
    }

    public function updateCompany(UpdateCompanyRequest $request, $id) {
        try {
            // Find company by Id
            $company = $this->service->findCompanyById($id);
            if (!$company) {
                return new Exception('Company not found');
            }

            // Update logo image from Form Request
            if ($request->hasFile('logo')) {
                $path = $request->file('logo')->store('public\logo');
            }

            $this->service->updateCompany($company, $request->name, $path);
            return ResponseFormatter::success($company, 'Company updated');
        }
        catch (Exception $e) {
            return ResponseFormatter::error(null, 500, 'failed', $e->getMessage());
        }
    }
}
