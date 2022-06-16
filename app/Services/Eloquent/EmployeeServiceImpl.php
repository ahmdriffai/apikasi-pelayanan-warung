<?php

namespace App\Services\Eloquent;

use App\Exceptions\InvariantException;
use App\Helper\Media;
use App\Http\Requests\EmployeeAddRequest;
use App\Http\Requests\EmployeeUpdateRequest;
use App\Models\Employee;
use App\Models\User;
use App\Services\EmployeeService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use SebastianBergmann\Diff\Exception;

class EmployeeServiceImpl implements EmployeeService
{
    use Media;

    function addEmployee(EmployeeAddRequest $request): User
    {
        $name = $request->input('name');
        $telp = $request->input('telp');
        $address = $request->input('address');
        $email = $request->input('email');
        $password = uniqid();
        $roles = $request->input('roles');

        $hashedPassword = Hash::make($password);

        try {
            DB::beginTransaction();
            $user = new User([
                'name' => $name,
                'email' => $email,
                'password' => $hashedPassword,
            ]);
            $user->save();
            $user->assignRole($roles);

            $employee = new Employee([
                'name' => $name,
                'telp' => $telp,
                'image_url' => null,
                'user_id' => $user->id,
                'address' => $address,
            ]);
            $employee->save();

            DB::commit();
        }catch (\Exception $exception) {
            DB::rollBack();
            throw new InvariantException($exception->getMessage());
        }

        $user->password = $password;
        return $user;
    }

    function addImageUrl($file, int $employeeId): Employee
    {
        $employee = Employee::find($employeeId);

        $dataFile = $this->uploads($file, 'employee/image/');
        $imageUrl = asset('storage/'. $dataFile['filePath']);
        $imagePath = public_path('storage/'. $dataFile['filePath']);

        $employee->image_url = $imageUrl;
        $employee->image_path = $imagePath;
        $employee->save();

        return $employee;
    }

    function updateEmployee(EmployeeUpdateRequest $request, $employeeId): Employee
    {
        $employee = Employee::find($employeeId);
        $user = User::find($employee->user_id);
        $name = $request->input('name');
        $telp = $request->input('telp');
        $address = $request->input('address');
        $email = $request->input('email');
        $roles = $request->input('roles');

        try {
            $employee->name = $name;
            $employee->telp = $telp;
            $employee->address = $address;
            $employee->save();
            if ($user != null) {
                $user->email = $email;

                $user->assignRole($roles);
                $user->save();
            }
        }catch (\Exception $exception) {
            throw new InvariantException($exception->getMessage());
        }

        return $employee;
    }

    function deleteEmployee($id): void
    {
        $employee = Employee::find($id);
        try {
            if($employee->image_url != null || $employee->image_path != null){
                unlink($employee->image_path);
            }

            $employee->deleta();
        }catch (\Exception $exception) {
            throw new InvariantException($exception->getMessage());
        }
    }

    function updateImage($file, $id): Employee
    {
        $employee = Employee::find($id);

        try {
            unlink($employee->image_path);
            $dataFile = $this->uploads($file, 'employee/image/');
            $imageUrl = asset('storage/'. $dataFile['filePath']);
            $imagePath = public_path('storage/'. $dataFile['filePath']);

            $employee->image_url = $imageUrl;
            $employee->image_path = $imagePath;
            $employee->save();
        }catch (Exception $exception) {
            throw new InvariantException($exception->getMessage());
        }

        return $employee;
    }

    function deleteImage($id): Employee
    {
        $employee = Employee::find($id);
        try {
            unlink($employee->image_path);
            $employee->image_path = null;
            $employee->image_url = null;
            $employee->save();
        }catch (\Exception $exception) {
            throw new InvariantException($exception->getMessage());
        }

        return $employee;
    }
}
