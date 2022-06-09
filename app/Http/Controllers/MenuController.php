<?php

namespace App\Http\Controllers;

use App\Exceptions\InvariantException;
use App\Helper\Media;
use App\Http\Requests\MenuAddRequest;
use App\Models\Category;
use App\Models\Menu;
use App\Models\MenuCart;
use App\Services\MenuService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MenuController extends Controller
{
    use Media;

    private MenuService $menuService;

    public function __construct(MenuService $menuService)
    {
        $this->middleware(['role:admin'])->only(['create']);
        $this->menuService = $menuService;
    }


    public function index(Request $request)
    {
        $title = 'Menu';
        $paginate = 10;
        $categories = Category::all();
        $menuCarts = MenuCart::where('user_id', Auth::user()->id)->get();
        $data = Menu::paginate($paginate);
        return view('menus.index', compact('data', 'title', 'categories', 'menuCarts'))
            ->with('i', ($request->input('page', 1) - 1) * $paginate);
    }

    public function create()
    {
        $categories = Category::all()->pluck('name' , 'id');
        return view('menus.create', compact('categories'));
    }

    public function store(MenuAddRequest $request)
    {
        try {

            $dataFile = $this->uploads($request->file('image'), 'menu/image/');

            $imageUrl = asset('storage/'. $dataFile['filePath']);

            $result = $this->menuService->addMenu($request, $imageUrl);

            return redirect()->back()->with('success', 'Berhasil Menambah Menu Baru ');
        }catch (InvariantException $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $categories = Category::all()->pluck('name' , 'id');
        $menu = Menu::find($id);
        return view('menus.edit', compact('menu', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
