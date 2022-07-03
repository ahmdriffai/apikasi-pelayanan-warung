<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Employee;
use App\Models\Menu;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $menu = Menu::all()->count();
        $category = Category::all()->count();
        $user = Employee::all()->count();
        $payment = Payment::select(DB::raw('sum(amount_paid) as `data`'), DB::raw("DATE_FORMAT(created_at, '%M') name_month"), DB::raw('YEAR(created_at) year, MONTH(created_at) month'))
            ->groupby('year', 'month')
            ->get();
        $total_payment = Payment::sum('amount_paid');

        return view('home', compact('menu', 'category', 'user', 'payment', 'total_payment'));
    }
}
