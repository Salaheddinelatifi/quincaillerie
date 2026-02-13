<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\StoreTrackingController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ProduitController;
use App\Http\Controllers\CommandeController;
use App\Http\Controllers\OrderAdminController;

/*
|-------------------------------------
| PUBLIC ROUTES (STORE)
|-------------------------------------
*/
Route::get('/', [StoreController::class, 'index'])->name('store.index');
Route::get('/store', [StoreController::class, 'index']);
Route::post('/store/commande', [StoreController::class, 'store'])->name('store.store');
Route::get('/store/modules', [StoreController::class, 'modules'])->name('store.modules');
Route::get('/store/contact', [StoreController::class, 'contact'])->name('store.contact');
Route::get('/store/cartevisite', [StoreController::class, 'carteVisite'])
    ->name('store.cartevisite');


Route::get('/store/cartevisite', [StoreController::class, 'carteVisite'])
    ->name('store.cartevisite');





Route::get('/store/confirmation', function () {
    return view('store.confirmation');
})->name('store.confirmation');

/*
|-------------------------------------
| TRACKING
|-------------------------------------
*/
Route::get('/store/tracking', [StoreTrackingController::class,'index'])->name('store.tracking');
Route::post('/store/tracking', [StoreTrackingController::class,'check'])->name('store.tracking.check');

/*
|-------------------------------------
| AUTH ROUTES
|-------------------------------------
*/
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

/*
|-------------------------------------
| ADMIN ROUTES
|-------------------------------------
*/
Route::middleware(['admin'])->group(function () {


    Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard');

    // Orders
    Route::get('/admin/mes-orders', [OrderAdminController::class, 'index'])->name('admin.orders');
    Route::post('/admin/orders/{commande}/accept', [OrderAdminController::class, 'accept'])->name('admin.orders.accept');
    Route::post('/admin/orders/{commande}/reject', [OrderAdminController::class, 'reject'])->name('admin.orders.reject');

    // Clients
    Route::prefix('admin/clients')->group(function () {
        Route::get('/', [ClientController::class, 'index'])->name('clients.index');
        Route::get('/create', [ClientController::class, 'create'])->name('clients.create');
        Route::post('/store', [ClientController::class, 'store'])->name('clients.store');
        Route::get('/{id}/edit', [ClientController::class, 'edit'])->name('clients.edit');
        Route::post('/{id}/update', [ClientController::class, 'update'])->name('clients.update');
        Route::get('/{id}/delete', [ClientController::class, 'destroy'])->name('clients.delete');
    });

    // Produits
    Route::prefix('admin/produits')->group(function () {
        Route::get('/', [ProduitController::class, 'index'])->name('produits.index');
        Route::get('/create', [ProduitController::class, 'create'])->name('produits.create');
        Route::post('/store', [ProduitController::class, 'store'])->name('produits.store');
        Route::get('/{id}/edit', [ProduitController::class, 'edit'])->name('produits.edit');
        Route::put('/{id}/update', [ProduitController::class, 'update'])->name('produits.update');
        Route::get('/{id}/delete', [ProduitController::class, 'destroy'])->name('produits.delete');
    });

    // Commandes
    Route::prefix('admin/commandes')->group(function () {
        Route::get('/', [CommandeController::class, 'index'])->name('commandes.index');
        Route::get('/create', [CommandeController::class, 'create'])->name('commandes.create');
        Route::post('/store', [CommandeController::class, 'store'])->name('commandes.store');
        Route::get('/{id}', [CommandeController::class, 'show'])->name('commandes.show');
        Route::get('/{id}/facture', [CommandeController::class, 'facture'])->name('commandes.facture');
        Route::get('/{id}/delete', [CommandeController::class, 'destroy'])->name('commandes.delete');
    });
    
});
