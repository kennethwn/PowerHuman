<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateResponsibilityRequest;
use App\Services\ResponsibilityService;
use Exception;
use Illuminate\Http\Request;

class ResponsibilityController extends Controller {
    private ResponsibilityService $service;

    public function __construct(ResponsibilityService $responsibilityService) {
        $this->service = $responsibilityService;
    }

    public function createResponsibility(CreateResponsibilityRequest $request) {
        try {
            $responsibility = $this->service->createResponsibility($request->name, $request->role_id);
            if (!$responsibility) {
                return ResponseFormatter::error(null, 404, 'failed', 'Responsibility not created');
            }
            return ResponseFormatter::success($responsibility, 'Responsibility created');
        }
        catch (Exception $e) {
            return ResponseFormatter::error(null, 500, 'failed', $e->getMessage());
        }
    }

    public function fetch(Request $request) {
        try {
            $id = $request->input('id');
            $name = $request->input('name');
            $role_id = $request->input('role_id');
            $limit = $request->input('limit', 10);

            // Retrieve single data
            if ($id) {
                $responsibility = $this->service->findResponsibilityById($id);
                return ResponseFormatter::success($responsibility, 'Responsibility found');
            }

            // Retrieve multiple data
            $responsibilities = $this->service->getAllResponsibilityByRole($role_id);
            if ($name) {
                $responsibilities = $this->service->findResponsibilityByName($name, $role_id);
            }

            return ResponseFormatter::success($responsibilities->paginate($limit), 'Responsibility found');

        }
        catch (Exception $e) {
            return ResponseFormatter::error(null, 500, 'failed', $e->getMessage());
        }
    }

    public function deleteResponsibility($id) {
        try {
            $responsibility = $this->service->findResponsibilityById($id);
            $responsibility ? $responsibility->delete() : throw new Exception('Responsibility not found');
            return ResponseFormatter::success(null, 'Responsibility deleted');
        }
        catch (Exception $e) {
            return ResponseFormatter::error(null, 500, 'failed', $e->getMessage());
        }
    }
}
