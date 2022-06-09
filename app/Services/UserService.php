<?php

namespace App\Services;

use App\Http\Requests\UserAddRequest;
use App\Models\User;

interface UserService
{
    public function addUser(UserAddRequest $request): User;
}
