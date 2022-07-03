<?php

namespace App\Services\Eloquent;

use App\Exceptions\InvariantException;
use App\Http\Requests\UserAddRequest;
use App\Http\Requests\UserChangePasswordRequest;
use App\Models\Employee;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserServiceImpl implements UserService
{

    public function addUser(UserAddRequest $request): User
    {
        $employee = Employee::find($request->input('employee_id'));
        $email = $request->input('email');
        $roles = $request->input('roles');
        $password = uniqid();

        $hashPassword = Hash::make($password);

        try {
            DB::beginTransaction();
            $user = new User();
            $user->name = $employee->name;
            $user->email = $email;
            $user->password = $hashPassword;
            $user->save();

            $employee->user_id = $user->id;
            $employee->save();

            $user->assignRole($roles);
            DB::commit();
        }catch (\Exception $exception) {
            DB::rollBack();
            throw new InvariantException('Gagal menambah data, terjadi kesalahan pada server kami');
        }

        $user->password = $password;
        return $user;
    }

    public function changePassword(UserChangePasswordRequest $request, $userId): User
    {
        $oldPassword = $request->input('old_password');
        $newPassword = $request->input('new_password');
        try {
            DB::beginTransaction();
            $user = User::findOrFail($userId);

            if (!Hash::check($oldPassword, $user->password)){
                throw new InvariantException('Password lama salah');
            }

            $user->password = Hash::make($newPassword);
            $user->save();
            DB::commit();
        }catch (\Exception $exception) {
            DB::rollBack();
            throw new InvariantException($exception->getMessage());
        }

        return $user;
    }
}
