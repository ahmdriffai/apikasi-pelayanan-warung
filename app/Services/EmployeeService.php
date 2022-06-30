<?php

namespace App\Services;

use App\Http\Requests\EmployeeAddRequest;
use App\Http\Requests\EmployeeUpdateRequest;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;

interface EmployeeService
{
    function addEmployee(EmployeeAddRequest $request): User;
    function updateEmployee(EmployeeUpdateRequest $request, $employeeId): Employee;
    function addImageUrl($file, int $employeeId): Employee;
    function deleteEmployee($id): void;
    function updateImage($file, $id): Employee;
    function deleteImage($id): Employee;
    function list(string $key, int $size): LengthAwarePaginator;
}
