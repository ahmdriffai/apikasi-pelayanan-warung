<?php

namespace App\Services\Eloquent;

use App\Exceptions\InvariantException;
use App\Helper\Media;
use App\Http\Requests\MenuAddRequest;
use App\Models\Category;
use App\Models\Menu;
use App\Services\MenuService;
use Illuminate\Support\Facades\DB;

class MenuServiceImpl implements MenuService
{
    use Media;

    function addMenu(MenuAddRequest $request, $imageUrl): Menu
    {
        $name = $request->input('name');
        $price = $request->input('price');
        $description = $request->input('description');

        $category = Category::find($request->input('category_id'));

        try {
            DB::beginTransaction();
            $menu = new Menu([
                'name' => $name,
                'price' => $price,
                'description' => $description,
                'imageUrl' => $imageUrl,
            ]);

            $category->menus()->save($menu);

            DB::commit();
        }catch (\Exception $exception){
            DB::rollBack();
            throw new InvariantException($exception->getMessage());
        }

        return $menu;
    }
}
