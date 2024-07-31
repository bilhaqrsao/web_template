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

    // Rute artikel publik
    Route::get('/articles', App\Livewire\Public\Article\Index::class)->name('public.articles');
    Route::get('/articles/{slug}', App\Livewire\Public\Article\Detail::class)->name('public.articles.detail');

    // Rute halaman publik
    Route::get('/page/{slug}', App\Livewire\Public\Page\Detail::class)->name('public.pages.detail');

    // Rute galeri publik
    Route::get('/galleries', App\Livewire\Public\Gallery\Index::class)->name('public.galleries');
    Route::get('/galleries/{slug}', App\Livewire\Public\Gallery\Detail::class)->name('public.galleries.detail');

    // Rute video publik
    Route::get('/videos', App\Livewire\Public\Video\Index::class)->name('public.videos');
    Route::get('/videos/{slug}', App\Livewire\Public\Video\Detail::class)->name('public.videos.detail');

    // Rute pengumuman publik
    Route::get('/pengumumans', App\Livewire\Public\Pengumuman\Index::class)->name('public.pengumumans');
    Route::get('/pengumumans/{slug}', App\Livewire\Public\Pengumuman\Detail::class)->name('public.pengumumans.detail');

    // Rute berkas publik
    Route::get('/berkas', App\Livewire\Public\Berkas\Index::class)->name('public.berkas');

    // Rute tags
    Route::get('/tags/{slug}', App\Livewire\Public\Tags\Detail::class)->name('public.tags.detail');

    // Rute kontak publik
    Route::get('/contact', App\Livewire\Public\Kontak\Index::class)->name('public.contact');
});

// Rute admin
Route::middleware(['auth'])->group(function () {
    // Rute dashboard admin
    Route::middleware(['role:admin,super-admin,developer'])->group(function () {
        Route::get('/panel-admin/dashboard', App\Livewire\Admin\Dashboard\Index::class)->name('admin.dashboard');

        // Rute Article
        Route::get('/panel-admin/articles', App\Livewire\Admin\Article\Index::class)->name('admin.articles');
        Route::get('/panel-admin/articles/create', App\Livewire\Admin\Article\Create::class)->name('admin.articles.create');
        Route::get('/panel-admin/articles/{id}/edit', App\Livewire\Admin\Article\Edit::class)->name('admin.articles.edit');

        // Rute page admin
        Route::get('/panel-admin/pages', App\Livewire\Admin\Page\Index::class)->name('admin.pages');
        Route::get('/panel-admin/pages/create', App\Livewire\Admin\Page\Create::class)->name('admin.pages.create');
        Route::get('/panel-admin/pages/{id}/edit', App\Livewire\Admin\Page\Edit::class)->name('admin.pages.edit');

        // Rute gallery admin
        Route::get('/panel-admin/galleries', App\Livewire\Admin\Gallery\Index::class)->name('admin.galleries');

        // Rute video admin
        Route::get('/panel-admin/videos', App\Livewire\Admin\Video\Index::class)->name('admin.videos');

        // Rute banner admin
        Route::get('/panel-admin/banners', App\Livewire\Admin\Banner\Index::class)->name('admin.banners');

        // Rute pengumuman admin
        Route::get('/panel-admin/pengumumans', App\Livewire\Admin\Pengumuman\Index::class)->name('admin.pengumumans');
        Route::get('/panel-admin/pengumumans/create', App\Livewire\Admin\Pengumuman\Create::class)->name('admin.pengumumans.create');
        Route::get('/panel-admin/pengumumans/{id}/edit', App\Livewire\Admin\Pengumuman\Edit::class)->name('admin.pengumumans.edit');

        // Rute berkas admin
        Route::get('/panel-admin/berkas', App\Livewire\Admin\Berkas\Index::class)->name('admin.berkas');

        // Rute menu admin
        Route::get('/panel-admin/menus', App\Livewire\Admin\Menu\Index::class)->name('admin.menus');

        // Rute link terkait admin
        Route::get('/panel-admin/link-terkaits', App\Livewire\Admin\Linked\Index::class)->name('admin.link-terkaits');
    });

    // Rute user admin
    Route::middleware(['role:admin,super-admin,developer'])->group(function () {
        Route::get('/panel-admin/users', App\Livewire\Admin\User\Index::class)->name('admin.users');

        Route::get('/kritik-saran', App\Livewire\Admin\Feedback\Index::class)->name('admin.feedback');
    });

    //  Rute super admin
    Route::middleware(['role:super-admin,developer'])->group(function () {
        Route::get('/panel-admin/identity-web', App\Livewire\Admin\Identity\Index::class)->name('admin.identity-web');
    });
});
