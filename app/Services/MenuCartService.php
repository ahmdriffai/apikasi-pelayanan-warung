<?php

namespace App\Services;

use App\Http\Requests\MenuCartAddRequest;
use App\Models\MenuCart;
use App\Models\User;

interface MenuCartService
{
    function addMenuCart(MenuCartAddRequest $request, User $user) : MenuCart;
    function deleteMenuCart(int $id): void;

}
