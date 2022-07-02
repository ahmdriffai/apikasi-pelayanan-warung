<?php

use App\Models\Category;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    $title = 'Daftar Menu';
    $categories = Category::all();
    return view('welcome', compact('categories', 'title'));
});

Route::get('/test-layout', function () {
    return view('test-layout');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware(['auth'])->group(function() {
    Route::resource('roles', \App\Http\Controllers\RoleController::class);
    // user
    Route::resource('users', \App\Http\Controllers\UserController::class);
    Route::post('users/search', [\App\Http\Controllers\UserController::class, 'search'])->name('users.search');
    // category
    Route::resource('categories', \App\Http\Controllers\CategoryController::class)->except(['create', 'show']);
    // Table
    Route::resource('tables', \App\Http\Controllers\TableController::class);
    // Menu
    Route::resource('menus', \App\Http\Controllers\MenuController::class);
    // menu cart
    Route::resource('menu-carts', \App\Http\Controllers\MenuCartController::class)->except(['destroy']);
    Route::get('menu-carts/{id}/delete', [\App\Http\Controllers\MenuCartController::class, 'delete'])->name('menu-carts.delete');
    // Order
    Route::resource('orders', \App\Http\Controllers\OrderController::class)->only(['index', 'store', 'create']);
    Route::get('orders/done/{id}', [\App\Http\Controllers\OrderController::class, 'done'])->name('orders.done');
    Route::get('orders/cancel/{id}', [\App\Http\Controllers\OrderController::class, 'cancel'])->name('orders.cancel');
    Route::get('orders/process/{id}', [\App\Http\Controllers\OrderController::class, 'process'])->name('orders.process');
    Route::get('orders/paid/{id}', [\App\Http\Controllers\OrderController::class, 'paid'])->name('orders.paid');
    Route::get('orders/save/{id}', [\App\Http\Controllers\OrderController::class, 'save'])->name('orders.save');

    // payment
    Route::resource('payments', \App\Http\Controllers\PaymentController::class)->only(['index', 'store']);
    Route::get('payments/create/{orderId}', [\App\Http\Controllers\PaymentController::class, 'create'])->name('payments.create');
    Route::get('payments/export', [\App\Http\Controllers\PaymentController::class, 'exsport'])->name('payments.exsport');

    // employ

    Route::resource('employees', \App\Http\Controllers\EmployeeController::class);
});

// Test

Route::get('/test-email-credential', function () {
    $email = 'ahmmd.riffai@gmail.com';
    $password = 'rahasia';

    dispatch(new \App\Jobs\SendEMailJob($email, $password));

    dd('send email progress');
});
