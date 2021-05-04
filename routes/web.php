<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\CatgoryController;
use App\Http\Controllers\Admin\PostController;

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
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
#Route::get('/{anypath}', [App\Http\Controllers\HomeController::class, 'index'])->where('path', '.*');

//category Routes
Route::get('/get-categoreis', [CatgoryController::class, 'index']);
Route::get('/delete-category/{id}', [CatgoryController::class, 'destroy']);
Route::post('/add-category', [CatgoryController::class, 'store'])->name('add-category');
Route::get('/get-category/{id}', [CatgoryController::class, 'edit']);
Route::post('/update-category', [CatgoryController::class, 'update']);
Route::post('/remove/categoryItems', [CatgoryController::class, 'categoryItems']);
Route::post('/change/categoryItems', [CatgoryController::class, 'changecategoryItems']);
Route::get('/get-active-categoreis', [CatgoryController::class, 'getActiveCcategoreis']);

//post Routes
Route::get('/get-posts', [PostController::class, 'index']);
Route::get('/delete-post/{id}', [PostController::class, 'destroy']);
Route::post('/add-post', [PostController::class, 'store'])->name('add-category');
Route::get('/get-post/{id}', [PostController::class, 'edit']);
Route::post('/update-post', [PostController::class, 'update']);
Route::post('/remove/postItems', [PostController::class, 'postItems']);
Route::post('/change/postItems', [PostController::class, 'changepostItems']);
