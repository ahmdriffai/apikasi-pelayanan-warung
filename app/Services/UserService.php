<?php

namespace App\Services;

use App\Http\Requests\UserAddRequest;
use App\Http\Requests\UserChangePasswordRequest;
use App\Models\User;

interface UserService
{
    public function addUser(UserAddRequest $request): User;
    public function changePassword(UserChangePasswordRequest $request, $userId): User;
}
