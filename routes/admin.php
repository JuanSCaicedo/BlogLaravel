<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\PostController;

Route::get('', [HomeController::class, 'index'])->middleware('can:admin.home')->name('admin.home');

Route::resource('users', UserController::class)
    ->only(['index', 'edit', 'update'])
    ->names('admin.users')
    ->middleware('role:Admin');

Route::resource('categories', CategoryController::class)->except('show')
    ->middleware('role:Admin')
    ->names('admin.categories');

Route::resource('tags', TagController::class)->except('show')
    ->middleware('role:Admin')
    ->names('admin.tags');

Route::resource('posts', PostController::class)->except('show')
    ->middleware('role:Admin,Blogger')
    ->names('admin.posts');