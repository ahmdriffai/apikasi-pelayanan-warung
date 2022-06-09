<?php

namespace App\Services\Eloquent;

use App\Exceptions\InvariantException;
use App\Http\Requests\MenuCartAddRequest;
use App\Models\Menu;
use App\Models\MenuCart;
use App\Models\User;
use App\Services\MenuCartService;
use Illuminate\Support\Facades\DB;

class MenuCartServiceImpl implements MenuCartService
{

    function addMenuCart(MenuCartAddRequest $request, ?User $user): MenuCart
    {
        $quantity = $request->input('quantity');
        $menu = Menu::find($request->input('menu_id'));

        // cek apakah user berhak menambahkan data
        if ($user == null) {
            throw new InvariantException('Gagal menabah keranjang, belum melakukan login');
        }

        // cek id menu sudah dimasukan
        $menuCart = MenuCart::where('menu_id', $menu->id)->where('user_id' , $user->id)->first();
//        dd($menuCart);
        if ($menuCart != null) {
            // jika sudah dimasukan ubah quantity
            $menuCart->quantity += $quantity;
            $menuCart->save();
        }else {
            // masukan data cart
            try {
                DB::beginTransaction();
                $menuCart = new MenuCart([
                    'user_id' => $user->id,
                    'menu_id' => $menu->id,
                    'quantity' => $quantity,
                ]);

                $menuCart->save();
                DB::commit();
            }catch (\Exception $exception) {
                DB::rollBack();
                throw new InvariantException($exception->getMessage());
            }

        }

        return $menuCart;
    }

    function deleteMenuCart(int $id): void
    {
        $menuCart = MenuCart::find($id);

        if ($menuCart->quantity == 1) {
            try {
                $menuCart->delete();
            }catch (\Exception $exception){
                throw new InvariantException($exception->getMessage());
            }
        }else {
            $menuCart->quantity -= 1;
            $menuCart->save();
        }
    }
}
