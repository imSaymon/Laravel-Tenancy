<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ShippingOptionsController;
use App\Http\Controllers\Front\StoreController;
use App\Models\Product;
use App\Models\Store;
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

Route::domain('{subdomain}.localhost')->group(function () {
    Route::get('/', [StoreController::class, 'index'])
        ->name('front.store');

    Route::prefix('cart')->name('cart.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Front\CartController::class, 'index'])->name('index');
        Route::get('add/{product}', [\App\Http\Controllers\Front\CartController::class, 'add'])->name('add');
        Route::get('remove/{product}', [\App\Http\Controllers\Front\CartController::class, 'remove'])->name('remove');
        Route::get('cancel', [\App\Http\Controllers\Front\CartController::class, 'cancel'])->name('cancel');
        Route::post('shipping', [\App\Http\Controllers\Front\CartController::class, 'shipping'])->name('store-shipping');
    });

    Route::prefix('checkout')->middleware('auth.store')->name('checkout.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Front\CheckoutController::class, 'checkout'])->name('checkout');
        Route::post('/proccess', [\App\Http\Controllers\Front\CheckoutController::class, 'proccess'])->name('proccess');
        Route::get('/thanks', [\App\Http\Controllers\Front\CheckoutController::class, 'thanks'])->name('thanks');
    });

    Route::name('sign.')->group(function () {
        Route::get('/sign-in', [\App\Http\Controllers\Front\AuthenticateController::class, 'index'])->name('index');
        Route::post('/sign-in', [\App\Http\Controllers\Front\AuthenticateController::class, 'signIn'])->name('in');
        Route::post('/sign-up', [\App\Http\Controllers\Front\AuthenticateController::class, 'signUp'])->name('up');
    });

    Route::get('/my-orders', [\App\Http\Controllers\Front\MyOrdersController::class, 'index'])
        ->name('my.orders')
        ->middleware('auth')
    ;
    Route::get('logout', [\App\Http\Controllers\Front\AuthenticateController::class, 'logout'])->name('up');
});


Route::get('/', function () {
    return view('welcome');
});

Route::middleware('acl:ROLE_TENANT_CUSTOMER')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->middleware(['auth'])->name('dashboard');

    Route::prefix('admin')->name('admin.')->group(function () {
        Route::resource('products', ProductController::class);
        Route::resource('categories', CategoryController::class);
        Route::resource('shippings', ShippingOptionsController::class);

        Route::get('/meus-inquilinos', fn() => 'Meus Inquilinos')->middleware('acl:ROLE_TENANT');
    });
});

require __DIR__ . '/auth.php';
