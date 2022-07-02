<?php

namespace App\Services;

use App\Http\Requests\MenuAddRequest;
use App\Http\Requests\MenuUpdateRequest;
use App\Models\Menu;
use Illuminate\Pagination\LengthAwarePaginator;

interface MenuService
{
    function addMenu(MenuAddRequest $request): Menu;
    function list(string $key, int $size): LengthAwarePaginator;
    function update(MenuUpdateRequest $request, int $id): Menu;
    function delete(int $id): void;
    function addImage(int $menuId, $file): Menu;
    function updateImage(int $menuId, $file): Menu;
}
