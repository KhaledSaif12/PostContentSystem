<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\MediaFileController;
use App\Http\Controllers\PostController;

use Illuminate\Support\Facades\Route;



Route::get('/', [PostController::class, 'postscategorized'])->name('postscategorized');

Route::group(['middleware'=>'auth'], function ()  {
//Category Controller
Route::get('/listcategories', [CategoryController::class, 'index'])->name('listcategories');
Route::get('/categories/{category}/edit', [CategoryController::class, 'edit'])->name('categoriesedit');
Route::put('/categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');
Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');
Route::get('/categories/{id}', [CategoryController::class, 'show'])->name('categories.show');

//End

// Routes for MediaFile resource
Route::resource('mediafiles', MediaFileController::class);

// Routes for Post resource
Route::resource('posts', PostController::class);
Route::get('/indexposts', [PostController::class, 'index'])->name('indexposts');

// Example of individual routes if you prefer to define them explicitly
// Route::get('posts', [PostController::class, 'index'])->name('posts.index');
 Route::get('posts/create', [PostController::class, 'create'])->name('posts.create');
 Route::post('posts', [PostController::class, 'store'])->name('posts.store');
 Route::get('posts/{post}', [PostController::class, 'show'])->name('posts.show');
 Route::get('posts/{post}/edit', [PostController::class, 'edit'])->name('posts.edit');
 Route::put('posts/{post}', [PostController::class, 'update'])->name('posts.update');
 Route::delete('posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');
});
//Auth Controller
Route::get('/login',[AuthController::class,'login'])->name('login');
Route::get('/register',[AuthController::class,'CreatUser'])->name('register');
Route::post('/saveuser',[AuthController::class,'store'])->name('save_user_old');
Route::post('/check_usar',[AuthController::class,'checkUser'])->name('check_usar');
Route::get('/logout',[AuthController::class,'logout'])->name('logout');
