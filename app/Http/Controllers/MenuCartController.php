<?php

namespace App\Http\Controllers;

use App\Exceptions\InvariantException;
use App\Http\Requests\MenuCartAddRequest;
use App\Services\MenuCartService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MenuCartController extends Controller
{
    private MenuCartService $menuCartService;


    public function __construct(MenuCartService $menuCartService)
    {
        $this->menuCartService = $menuCartService;
    }


    public function index()
    {
        //
    }

    public function create()
    {
        //
    }

    public function store(MenuCartAddRequest $request)
    {
        $user = Auth::user();
        try {
            $this->menuCartService->addMenuCart($request, $user);
            return redirect()->back()->with('success', 'Berhasil Menambah Pesanan');
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
        //
    }


    public function update(Request $request, $id)
    {
        //
    }


    public function delete($id)
    {
        try {
            $this->menuCartService->deleteMenuCart($id);
            return redirect()->back();
        }catch (InvariantException $exception) {
            return redirect()->back()->with('error', 'Gagal menghapus menu pada keranjang');
        }
    }
}
