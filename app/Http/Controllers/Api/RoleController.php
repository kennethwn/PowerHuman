<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use App\Services\RoleService;
use Exception;
use Illuminate\Http\Request;

class RoleController extends Controller {
    private RoleService $service;

    public function __construct(RoleService $roleService) {
        $this->service = $roleService;
    }

    public function createRole(CreateRoleRequest $request) {
        try {
            $role = $this->service->createRole($request->name, $request->company_id);
            if (!$role) {
                return new Exception('Role not created');
            }

            return ResponseFormatter::success($role, 'Role created');
        }
        catch (Exception $e) {
            return ResponseFormatter::error(null, 400, 'failed', $e->getMessage());
        }
    }

    public function fetch(Request $request) {
        try {
            $id = $request->input('id');
            $name = $request->input('name');
            $company_id = $request->input('company_id');
            $limit = $request->input('limit', 10);

            // Retrieve single data
            if ($id) {
                $role = $this->service->findRoleById($id);
                return ResponseFormatter::success($role, 'Role is exists');
            }

            // Retrieve multiple data
            $roles = $this->service->getAllRoles($request->company_id);
            if ($name) {
                $roles = $this->service->findRoleByName($company_id, $name);
            }

            return ResponseFormatter::success($roles->paginate($limit), 'Roles is exists');
        }
        catch (Exception $e) {
            return ResponseFormatter::error(null, 500, 'failed', $e->getMessage());
        }
    }

    public function updateRole(UpdateRoleRequest $request, $id) {
        try {
            // Find team by Id
            $role = $this->service->findRoleById($id);
            if (!$role) {
                return new Exception('Team not found');
            }

            $this->service->updateRole($role, $request->name, $request->company_id);
            return ResponseFormatter::success($role, 'Role updated');
        }
        catch (Exception $e) {
            return ResponseFormatter::error(null, 500, 'failed', $e->getMessage());
        }
    }

    public function deleteRole($id) {
        try{
            $role = $this->service->findRoleById($id);
            $role ? $role->delete() : throw new Exception('Role not found');
            return ResponseFormatter::success(null, 'Role deleted');
        }
        catch (Exception $e) {
            return ResponseFormatter::error(null, 500, 'failed', $e->getMessage());
        }
    }
}
