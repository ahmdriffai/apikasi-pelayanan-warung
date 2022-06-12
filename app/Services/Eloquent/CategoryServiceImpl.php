<?php

namespace App\Services\Eloquent;

use App\Exceptions\InvariantException;
use App\Http\Requests\CategoryAddRequest;
use App\Models\Category;
use App\Services\CategoryService;
use Illuminate\Support\Facades\DB;

class CategoryServiceImpl implements CategoryService
{

    function addCategory(CategoryAddRequest $request): Category
    {
        try {
            DB::beginTransaction();
            $category = new Category([
                'name' => $request->input('name')
            ]);

            $category->save();
            DB::commit();
        }catch (\Exception $exception) {
            DB::rollBack();
            throw new InvariantException($exception->getMessage());
        }

        return $category;
    }
}
