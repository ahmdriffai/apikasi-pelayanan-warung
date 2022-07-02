<?php

namespace App\Services\Eloquent;

use App\Exceptions\InvariantException;
use App\Helper\Media;
use App\Http\Requests\MenuAddRequest;
use App\Http\Requests\MenuUpdateRequest;
use App\Models\Category;
use App\Models\Menu;
use App\Services\MenuService;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use SebastianBergmann\Diff\Exception;

class MenuServiceImpl implements MenuService
{
    use Media;

    function addMenu(MenuAddRequest $request): Menu
    {
        $name = $request->input('name');
        $price = $request->input('price');
        $description = $request->input('description');

        $category = Category::findOrFail($request->input('category_id'));

        try {
            DB::beginTransaction();
            $menu = new Menu([
                'name' => $name,
                'price' => $price,
                'description' => $description,
            ]);

            $category->menus()->save($menu);

            DB::commit();
        }catch (\Exception $exception){
            DB::rollBack();
            throw new InvariantException($exception->getMessage());
        }

        return $menu;
    }

    function list(string $key = '', int $size = 10): LengthAwarePaginator
    {
        $paginate = Menu::where('name', 'like' ,'%'.$key.'%')->orderBy('created_at', 'DESC')
            ->paginate(10);
        return $paginate;
    }

    function update(MenuUpdateRequest $request, int $id): Menu
    {
        $name = $request->input('name');
        $price = $request->input('price');
        $description = $request->input('description');
        $category = Category::findOrFail($request->input('category_id'));
        $menu = Menu::findOrFail($id);

        try {
            DB::beginTransaction();
            $menu->name = $name;
            $menu->price = $price;
            $menu->description = $description;

            $category->menus()->save($menu);
            DB::commit();
        }catch (Exception $exception) {
            DB::rollBack();
            throw new InvariantException($exception->getMessage());
        }

        return $menu;
    }

    function delete(int $id): void
    {
        $menu = Menu::findOrFail($id);

        try {
            if ($menu->image_path != null) {
                unlink($menu->image_path);
            }

            $menu->delete();
        }catch (\Exception $exception) {
            throw new InvariantException($exception->getMessage());
        }
    }

    function addImage(int $menuId, $file): Menu
    {
        $menu = Menu::find($menuId);

        $dataFile = $this->uploads($file, 'menu/image/');
        $imageUrl = asset('storage/'. $dataFile['filePath']);
        $imagePath = public_path('storage/'. $dataFile['filePath']);

        $menu->image_url = $imageUrl;
        $menu->image_path = $imagePath;
        $menu->save();

        return $menu;
    }

    function updateImage(int $menuId, $file): Menu
    {
        $menu = Menu::findOrFail($menuId);

        try {
            if ($menu->image_path != null) {
                unlink($menu->image_path);
            }

            $dataFile = $this->uploads($file, 'pengumuman/');
            $filePath = public_path('storage/'. $dataFile['filePath']);
            $fileUrl = asset('storage/'. $dataFile['filePath']);

            $menu->image_path = $filePath;
            $menu->image_url = $fileUrl;
            $menu->save();

        }catch (\Exception $exception) {
            throw new InvariantException($exception->getMessage());
        }

        return $menu;
    }
}
