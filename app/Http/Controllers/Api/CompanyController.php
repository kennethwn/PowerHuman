<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Services\CompanyService;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    protected CompanyService $service;

    public function __construct(CompanyService $companyService) {
        $this->service = $companyService;
    }

    public function all(Request $request) {
        $id = $request->input('id');
        $name = $request->input('name');
        $limit = $request->input('limit', 10);

        // for URL: powerhuman.com/api/company?id=1
        if ($id) {
            $company = $this->service->findCompanyById($id);
            if ($company) {
                return ResponseFormatter::success($company, 'Company found');
            }
            return ResponseFormatter::error(null, 404, 'not found', 'Company not found');
        }

        // for URL: powerhuman.com/api/company
        if ($name) {
            $this->service->findCompanyByName($name);
        }

        return ResponseFormatter::success(
            $this->service->getRelation()->paginate($limit),
            'Companies found'
        );
    }
}
