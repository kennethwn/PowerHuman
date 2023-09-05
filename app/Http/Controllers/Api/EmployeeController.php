<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateEmployeeRequest;
use App\Http\Requests\UpdateEmployeeRequest;
use App\Services\EmployeeService;
use Exception;
use Illuminate\Http\Request;

class EmployeeController extends Controller {
    private $service;

    public function __construct(EmployeeService $service)  {
        $this->service = $service;
    }

    public function createEmployee(CreateEmployeeRequest $request) {
        try {
            if ($request->hasFile('photo')) {
                $path = $request->file('photo')->store('public/photos');
            }

            // Create Employee
            $employee = $this->service->createEmployee(
                $request->name,
                $request->email,
                $request->gender,
                $request->age,
                $request->phone,
                $path,
                $request->team_id,
                $request->role_id
            );
            if (!$employee) {
                return new Exception('Employee not created');
            }

            return ResponseFormatter::success($employee, 'Employee created');
        }
        catch (Exception $e) {
            return ResponseFormatter::error(null, 500, 'failed', $e->getMessage());
        }
    }

    public function fetch(Request $request) {
        try {
            $id = $request->input('id');
            $name = $request->input('name');
            $email = $request->input('email');
            $age = $request->input('age');
            $phone = $request->input('phone');
            $team_id = $request->input('team_id');
            $role_id = $request->input('role_id');
            $limit = $request->input('limit', 10);

            // Retrieve single data
            if ($id) {
                $employee = $this->service->findEmployeeById($id);
                return ResponseFormatter::success($employee, 'Employee found');
            }

            // Retrieve multiple data
            $employees = $this->service->getAllEmployees();

            if ($name) { $employees = $this->service->findEmployeeByName($name); }
            if ($phone) { $employees = $this->service->findEmployeeByPhone($phone); }
            if ($age) { $employees = $this->service->findEmployeeByAge($age); }
            if ($email) { $employees = $this->service->findEmployeeByEmail($email); }
            if ($role_id) { $employees = $this->service->findEmployeeByRole($role_id); }
            if ($team_id) { $employees = $this->service->findEmployeeByTeam($team_id); }

            return ResponseFormatter::success($employees->paginate($limit), 'Employees found');
        }
        catch (Exception $e) {
            return ResponseFormatter::error(null, 500, 'failed', $e->getMessage());
        }
    }

    public function updateEmployee(UpdateEmployeeRequest $request, $id) {
        try {
            $employee = $this->service->findEmployeeById($id);
            if (!$employee) {
                return new Exception('Employee not found');
            }

            if ($request->hasFile('photo')) {
                $path = $request->file('photo')->store('public\photo');
            }

            $this->service->updateEmployee(
                $employee,
                $request->name,
                $request->email,
                $request->gender,
                $request->age,
                $request->phone,
                $path,
                $request->team_id,
                $request->role_id
            );

            return ResponseFormatter::success($employee, 'Employee updated');
        }
        catch (Exception $e) {
            return ResponseFormatter::error(null, 400, 'failed', $e->getMessage());
        }
    }

    public function deleteEmployee($id) {
        try{
            $employee = $this->service->findEmployeeById($id);
            $employee ? $employee->delete() : throw new Exception('Employee not found');
            return ResponseFormatter::success(null, 'Employee deleted');
        }
        catch (Exception $e) {
            return ResponseFormatter::error(null, 500, 'failed', $e->getMessage());
        }
    }
}
