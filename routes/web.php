<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SubCategoryController;

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

Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::prefix('items')->group(function () {
    Route::get('/', [App\Http\Controllers\ItemController::class, 'index'])->name('items.index');
    Route::get('/add', [App\Http\Controllers\ItemController::class, 'add']);
    Route::post('/add', [App\Http\Controllers\ItemController::class, 'add'])->name('items.store');
    Route::get('/{id}/edit', [App\Http\Controllers\ItemController::class, 'edit']);
    Route::put('/{item}', [App\Http\Controllers\ItemController::class, 'update']);
    Route::post('/stock-out/{id}', [App\Http\Controllers\ItemController::class, 'handleStockOut'])->name('items.stock-out');
    Route::delete('/{id}', [App\Http\Controllers\ItemController::class, 'destroy'])->name('item.destroy');
    Route::get('/search', [App\Http\Controllers\ItemController::class, 'search'])->name('item.search');
});

// カテゴリ
// Route::get('categories/add',[App\Http\Controllers\CategoryController::class, 'add']);

Route::resource('categories', CategoryController::class);
Route::resource('subCategories', SubCategoryController::class);

// 大カテゴリから中カテゴリをgetするAJAXのためのルート
Route::post('getsubcategories', [SubCategoryController::class, 'getsubcategories']);

