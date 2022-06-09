<?php

namespace App\Http\Controllers;

use App\Exceptions\InvariantException;
use App\Http\Requests\OrderAddRequest;
use App\Models\MenuCart;
use App\Models\Order;
use App\Models\Table;
use App\Services\OrderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    private OrderService $orderService;

    /**
     * @param OrderService $orderService
     */
    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }


    public function index()
    {
        $pending = Order::where('status','pending')->orderBy('created_at', 'DESC')->paginate(5);
        $cooking = Order::where('status','process')->orderBy('created_at', 'DESC')->paginate(5);
        $done = Order::where('status','done')->orderBy('created_at', 'DESC')->paginate(5);
        $paid = Order::where('status','paid')->orderBy('created_at', 'DESC')->paginate(5);
        $notPaid = Order::where('status','!=','paid')->where('status', '!=', 'cancel')->orderBy('created_at', 'DESC')->paginate(5);

        return view('orders.index', compact('pending', 'cooking', 'done', 'paid', 'notPaid'));
    }


    public function create()
    {
        $menuCarts = MenuCart::where('user_id', Auth::user()->id)->get();
        $cartId = MenuCart::where('user_id', Auth::user()->id)->pluck('id');
        $tables = Table::all();

        return view('orders.create', compact('menuCarts', 'tables', 'cartId'));
    }

    public function store(OrderAddRequest $request)
    {
        try {
            $this->orderService->addOrder($request);
            return redirect()->route('orders.index')->with('success', 'Berhasil Membuat Pesanan');
        }catch (InvariantException $exception){
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    public function process($id) {
        try {
            $this->orderService->process($id);
            return redirect()->back()->with('success', 'Pesanan dalam proses memasak');
        }catch (InvariantException $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    public function done($id) {
        try {
            $this->orderService->done($id);
            return redirect()->back()->with('success', 'Pesanan sudah selesai');
        }catch (InvariantException $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    public function cancel($id) {
        try {
            $this->orderService->cancel($id);
            return redirect()->back()->with('success', 'Berhasil membatalka pesanan');
        }catch (InvariantException $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    public function paid($id) {
        try {
            $this->orderService->paid($id);
            return redirect()->back()->with('success', 'Pesanan berhasil terbayar');
        }catch (InvariantException $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }
}
