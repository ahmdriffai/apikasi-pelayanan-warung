<?php

namespace App\Services\Eloquent;

use App\Exceptions\InvariantException;
use App\Http\Requests\OrderAddRequest;
use App\Models\Menu;
use App\Models\MenuCart;
use App\Models\Order;
use App\Models\Table;
use App\Services\OrderService;
use Illuminate\Support\Facades\DB;

class OrderServiceImpl implements OrderService
{

    function addOrder(OrderAddRequest $request): Order
    {
        $customerName = $request->input('customer_name');
        $table = Table::find($request->input('table_id'));
        $note = $request->input('note');
        $menuId = $request->input('menu_id');
        $quantity = $request->input('quantity');

        try {
            DB::beginTransaction();

            $order = new Order([
                'customer_name' => $customerName,
                'status' => 'pending',
                'note' => $note,
            ]);

            $table->order()->save($order);

            for($i = 0; $i < count($menuId); $i++){
                $order->menus()->attach($menuId[$i],['quantity' => $quantity[$i]]);
            }

            // jika mau dibatasi per meja

            // $table->is_available = 0;
            // $table->save();

            DB::table('menu_carts')->delete();

            DB::commit();
        }catch (\Exception $exception) {
            DB::rollBack();
            throw new InvariantException($exception->getMessage());
        }

        return $order;
    }

    function done(int $id): Order
    {
        $order = Order::find($id);
        if ($order->status == 'save') {
            throw new InvariantException('Pesanan sudah disimapn');
        }
        try {
            $order->status = 'done';
            $order->save();
        }catch (\Exception $exception) {
            throw new InvariantException($exception->getMessage());
        }
        return $order;
    }

    function process(int $id): Order
    {
        $order = Order::find($id);
        try {
            $order->status = 'process';
            $order->save();
        }catch (\Exception $exception) {
            throw new InvariantException($exception->getMessage());
        }
        return $order;
    }

    function paid(int $id): Order
    {
        $order = Order::find($id);
        try {
            $order->status = 'paid';
            $order->save();
        }catch (\Exception $exception) {
            throw new InvariantException($exception->getMessage());
        }
        return $order;
    }

    function cancel(int $id): Order
    {
        $order = Order::find($id);

        if ($order->status != 'pending') {
            throw new InvariantException('Tidak bisa membatalkan pesanan');
        }

        try {
            $order->status = 'cancel';
            $order->save();
        }catch (\Exception $exception) {
            throw new InvariantException($exception->getMessage());
        }
        return $order;
    }

    function save(int $id): Order
    {
        $order = Order::find($id);
        if ($order->status != 'done') {
            throw new InvariantException('Pesanan gagal disimpan, selesaikan pesanan dulu sebelum disimpan');
        }
        try {
            $order->status = 'save';
            $order->save();
        }catch (\Exception $exception) {
            throw new InvariantException($exception->getMessage());
        }
        return $order;
    }
}
