<?php

namespace App\Services;

use App\Http\Requests\MenuAddRequest;
use App\Models\Menu;

interface MenuService
{
    function addMenu(MenuAddRequest $request, string $imageUrl): Menu;
}
