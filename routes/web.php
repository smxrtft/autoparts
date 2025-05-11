<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ProductController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

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

/*Route::get('/', function () {
    return view('welcome');
});*/

/*Route::get('/', function () {
    return view('index');
});*/

Route::get('/', [\App\Http\Controllers\ProductController::class, 'index'])->name('home');

Route::get('/products/{slug}', [\App\Http\Controllers\ProductController::class, 'show'])->name('products.show');
Route::get('/category/{slug}', [\App\Http\Controllers\CategoryController::class,'show'])->name('categories.show');

Route::get('/about', [\App\Http\Controllers\ViewController::class,'about'])->name('about');
Route::get('/contacts', [\App\Http\Controllers\ViewController::class,'contacts'])->name('contacts');
Route::get('/delivery', [\App\Http\Controllers\ViewController::class,'delivery'])->name('delivery');


Route::post('/cart/add', [\App\Http\Controllers\CartController::class, 'add'])->name('cart.add');
Route::get('/cart/del-item/{product_id}', [\App\Http\Controllers\CartController::class, 'delItem'])->name('cart.del_item');
Route::get('/cart/clear', [\App\Http\Controllers\CartController::class, 'clear'])->name('cart.clear');
Route::get('/cart/show', [\App\Http\Controllers\CartController::class, 'show'])->name('cart.show');

Route::middleware(['isAdmin'])->group(function() {
    Route::get('/admin',[\App\Http\Controllers\ProductController::class, 'indexAdmin'])->name('admin.index');
    Route::post('/admin/update/{id}', [\App\Http\Controllers\ProductController::class, 'update'])->name('admin.update');
    Route::get('/admin/create', [\App\Http\Controllers\ProductController::class, 'create'])->name('admin.create');
    Route::get('/admin/create-category', [\App\Http\Controllers\CategoryController::class, 'createCategory'])->name('admin.create-category');
    Route::post('/admin/store-category', [\App\Http\Controllers\CategoryController::class, 'storeCategory'])->name('admin.store-category');
    Route::post('/admin/updatecat/{id}', [\App\Http\Controllers\CategoryController::class, 'updateCategory'])->name('admin.update-category');
    Route::post('/admin/destroycat/{product}', [\App\Http\Controllers\CategoryController::class, 'destroyCategory'])->name('admin.destroy-category');
    Route::post('/admin/store/', [\App\Http\Controllers\ProductController::class, 'store'])->name('admin.store');
    Route::post('/admin/destroy/{product}', [\App\Http\Controllers\ProductController::class, 'destroy'])->name('admin.destroy');
});

Route::match(['get', 'post'], '/cart/checkout', [\App\Http\Controllers\CartController::class, 'checkout'])->name('cart.checkout')->middleware(['auth', 'verified']);

Route::get('dashboard', [RegisterController::class, 'dashboard'])->name('dashboard')->middleware(['auth', 'verified']);

Route::get('verify-email', function() {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function(EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect()->route('home');    
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request){
    $request->user()->sendEmailVerificationNotification();

    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:3,1'])->name('verification.send');

Route::middleware('guest')->group(function () {
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::get('forgot-password', function() {
        return view('auth.forgot-password');
    })->name('password.request');

    Route::post('forgot-password', [LoginController::class, 'forgotPasswordStore'])->name('password.email')->middleware('throttle:3,1');

    Route::get('reset-password/{token}', function (string $token) {
        return view('auth.reset-password', ['token' => $token]);
    })->name('password.reset');

    Route::post('reset-password', [LoginController::class, 'resetPasswordUpdate'])->name('password.update');
});
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/search', [ProductController::class, 'search'])->name('products.search');
Route::get('/orders',[CartController::class, 'orders'])->name('orders');