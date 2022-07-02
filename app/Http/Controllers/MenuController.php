<?php

namespace App\Http\Controllers;

use App\Exceptions\InvariantException;
use App\Helper\Media;
use App\Http\Requests\MenuAddRequest;
use App\Http\Requests\MenuUpdateRequest;
use App\Models\Category;
use App\Models\Menu;
use App\Models\MenuCart;
use App\Services\MenuService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Nette\Utils\ImageException;

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
        $data = $this->menuService->list($request->query('key') ?? '', $paginate);
        return view('menus.index', compact('data', 'title', 'categories', 'menuCarts'))
            ->with('i', ($request->input('page', 1) - 1) * $paginate);
    }

    public function search(Request $request) {
        $key = $request->input('key');

        $title = 'Menu';
        $paginate = 10;
        $menuCarts = MenuCart::where('user_id', Auth::user()->id)->get();
        $categories = Category::with('menus')
            ->whereRelation('menus', 'name', 'like', '%'.$key.'%')
            ->get();
        $data = Menu::where('name', 'like', '%'.$key.'%')->orderBy('created_at', 'DESC')->paginate($paginate);
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
            $result = $this->menuService->addMenu($request);

            $this->menuService->addImage($result->id, $request->file('image'));

            return redirect()->route('menus.index')->with('success', 'Berhasil Menambah Menu Baru ');
        }catch (InvariantException $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    public function show($id)
    {
        //e
    }

    public function edit($id)
    {
        $categories = Category::all()->pluck('name' , 'id');
        $menu = Menu::find($id);
        return view('menus.edit', compact('menu', 'categories'));
    }

    public function update(MenuUpdateRequest $request, $id)
    {
        $image = $request->file('image');
        try {
            $menu = $this->menuService->update($request, $id);
            if ($image != null) {
                $this->menuService->updateImage($id, $image);
            }
            return redirect()->route('menus.index')->with('success', 'Berhasil mengubah menu');
        }catch (InvariantException $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $this->menuService->delete($id);
            return redirect()->route('menus.index')->with('success', 'Berhasil mengubah menu');
        }catch (ImageException$exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }
}
