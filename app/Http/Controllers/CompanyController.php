<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseFormatter;
use App\Models\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function all(Request $request) {
        $id = $request->input('id');
        $name = $request->input('name');
        $limit = $request->input('limit', 10);

        // for URL: powerhuman.com/api/company?id=1
        if ($id) {
            $company = Company::with('users')->find($id);
            if ($company) {
                return ResponseFormatter::success($company, 'Company found');
            }
            return ResponseFormatter::error(null, 404, 'not found', 'Company not found');
        }

        // for URL: powerhuman.com/api/company
        $companies = Company::with('users');
        if ($name) {
            $companies->where('name', 'like', '%'. $name .'%')->get();
        }

        return ResponseFormatter::success(
            $companies->paginate($limit),
            'Companies found'
        );
    }
}
