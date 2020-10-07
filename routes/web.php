<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SubcategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\FrontProductListController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\UserController;

Route::get('/index', function () {
    return view('admin.dashboard');
});
Route::get('/test', function () {
    return view('test');
});
Auth::routes();


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('subcatories/{id}',[ProductController::class, 'loadSubCategories']);


Route::get('/', [FrontProductListController::class,'index']);
Route::get('/product/{id}',[FrontProductListController::class, 'show'])->name('product.view');
Route::get('/category/{name}',[FrontProductListController::class, 'allProduct'])->name('product.list');
Route::get('all/products',[FrontProductListController::class, 'moreProducts'])->name('more.product');


Route::get('/addToCart/{product}',[CartController::class, 'addToCart'])->name('add.cart');
Route::get('/cart',[CartController::class, 'showCart'])->name('cart.show');
Route::post('/products/{product}',[CartController::class, 'updateCart'])->name('cart.update');
Route::post('/product/{product}',[CartController::class, 'removeCart'])->name('cart.remove');


Route::get('/checkout/{amount}',[CartController::class, 'checkout'])->name('cart.checkout')->middleware('auth');
Route::post('/charge',[CartController::class, 'change'])->name('cart.charge');
Route::get('/orders',[CartController::class, 'order'])->name('order')->middleware('auth');

Route::group(['middleware'=>'isAdmin'],function(){
	Route::get('auth/dashboard', function () {
    return view('admin.dashboard');
});

	
Route::resource('category',CategoryController::class);
Route::resource('subcategory',SubcategoryController::class);
Route::resource('product',ProductController::class);

Route::get('slider/create',[SliderController::class, 'create'])->name('slider.create');
Route::get('slider',[SliderController::class, 'index'])->name('slider.index');
Route::post('slider',[SliderController::class, 'store'])->name('slider.store');
Route::delete('slider/{id}',[SliderController::class, 'destroy'])->name('slider.destroy');

Route::get('users',[UserController::class, 'index'])->name('user.index');

Route::get('/orders',[CartController::class, 'userOrder'])->name('order.index');
Route::get('/orders/{userid}/{orderid}',[CartController::class, 'viewUserOrder'])->name('user.order');

});