<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::middleware(['visitor'])->group(function () {
    // jika sudah login tetapi pengguna menggunakan url /login maka auto logout dan login ulang
    Route::get('/login', App\Livewire\Auth\Login::class)->name('public.login');
    if (auth()->check()) {
        Route::get('/login', function () {
            auth()->logout();
            return redirect()->route('public.login');
        });
    }

    Route::get('/logout', App\Livewire\Auth\Logout::class)->name('public.logout');

    Route::get('/', App\Livewire\Public\Home\Index::class)->name('public.index');
});

Route::middleware(['auth', 'visitor'])->group(function () {
    Route::middleware(['role:admin,super-admin,developer,user'])->group(function () {
        Route::get('/dashboard', App\Livewire\Admin\Dashboard\Index::class)->name('admin.dashboard');
    });

    Route::middleware(['role:admin,user'])->group(function () {
        Route::get('/sales', App\Livewire\Admin\Sales\Index::class)->name('admin.sales');
        Route::get('/sales/create', App\Livewire\Admin\Sales\Create::class)->name('admin.sales.create');
        Route::get('/sales/{id}/edit', App\Livewire\Admin\Sales\Edit::class)->name('admin.sales.edit');
    });

    Route::middleware(['role:admin'])->group(function () {
        Route::get('/inventory', App\Livewire\Admin\Inventory\Index::class)->name('admin.inventory');

        Route::get('/store', App\Livewire\Admin\Store\Index::class)->name('admin.store');

        // Product
        Route::get('/product', App\Livewire\Admin\Product\Index::class)->name('admin.product');
    });

    Route::middleware(['role:admin,super-admin,developer'])->group(function () {
        Route::get('/users', App\Livewire\Admin\User\Index::class)->name('admin.users');
    });

    Route::middleware(['role:super-admin,developer'])->group(function () {
        Route::get('/list-store', App\Livewire\Admin\Store\ListStore::class)->name('admin.list-store');

    });
});
