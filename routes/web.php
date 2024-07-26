<?php

use Illuminate\Support\Facades\Hash;
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

// Rute untuk autentikasi
Route::middleware(['guest'])->group(function () {
    // Rute login
    Route::get('/login', App\Livewire\Auth\Login::class)->name('public.login');
    // Rute logout
    Route::get('/logout', App\Livewire\Auth\Logout::class)->name('public.logout');
});

// Rute publik (untuk non-autentikasi)
Route::middleware(['visitor'])->group(function () {
    // Rute beranda publik
    Route::get('/', App\Livewire\Public\Home\Index::class)->name('public.index');
});

// Rute admin
Route::middleware(['auth'])->group(function () {
    // Rute dashboard admin
    Route::middleware(['role:admin,super-admin,developer'])->group(function () {
        Route::get('/dashboard', App\Livewire\Admin\Dashboard\Index::class)->name('admin.dashboard');

        // Rute Article
        Route::get('/articles', App\Livewire\Admin\Article\Index::class)->name('admin.articles');
        Route::get('/articles/create', App\Livewire\Admin\Article\Create::class)->name('admin.articles.create');
        Route::get('/articles/{id}/edit', App\Livewire\Admin\Article\Edit::class)->name('admin.articles.edit');

        // Rute page admin
        Route::get('/pages', App\Livewire\Admin\Page\Index::class)->name('admin.pages');
        Route::get('/pages/create', App\Livewire\Admin\Page\Create::class)->name('admin.pages.create');
        Route::get('/pages/{id}/edit', App\Livewire\Admin\Page\Edit::class)->name('admin.pages.edit');

        // Rute gallery admin
        Route::get('/galleries', App\Livewire\Admin\Gallery\Index::class)->name('admin.galleries');

        // Rute video admin
        Route::get('/videos', App\Livewire\Admin\Video\Index::class)->name('admin.videos');

        // Rute banner admin
        Route::get('/banners', App\Livewire\Admin\Banner\Index::class)->name('admin.banners');

        // Rute pengumuman admin
        Route::get('/pengumumans', App\Livewire\Admin\Pengumuman\Index::class)->name('admin.pengumumans');
        Route::get('/pengumumans/create', App\Livewire\Admin\Pengumuman\Create::class)->name('admin.pengumumans.create');
        Route::get('/pengumumans/{id}/edit', App\Livewire\Admin\Pengumuman\Edit::class)->name('admin.pengumumans.edit');

        // Rute berkas admin
        Route::get('/berkas', App\Livewire\Admin\Berkas\Index::class)->name('admin.berkas');

        // Rute menu admin
        Route::get('/menus', App\Livewire\Admin\Menu\Index::class)->name('admin.menus');
    });

    // Rute user admin
    Route::middleware(['role:admin,super-admin,developer'])->group(function () {
        Route::get('/users', App\Livewire\Admin\User\Index::class)->name('admin.users');
    });

    //  Rute super admin
    Route::middleware(['role:super-admin,developer'])->group(function () {
        Route::get('/identity-web', App\Livewire\Admin\Identity\Index::class)->name('admin.identity-web');
    });
});
