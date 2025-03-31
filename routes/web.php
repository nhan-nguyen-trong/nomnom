<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\IngredientController;
use App\Http\Controllers\PackagingController;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\CakeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReportController;

// Dashboard
Route::group(['prefix' => 'dashboard', 'as' => 'dashboard.'], function () {
    Route::get('/', [DashboardController::class, 'index'])->defaults('_config', [
        'view' => 'dashboard.index'
    ])->name('index');
});

// Quản lý nguyên liệu
Route::group(['prefix' => 'ingredients', 'as' => 'ingredients.'], function () {
    Route::get('/', [IngredientController::class, 'index'])->defaults('_config', [
        'view' => 'ingredients.index'
    ])->name('index');

    Route::get('/create', [IngredientController::class, 'create'])->defaults('_config', [
        'view' => 'ingredients.create'
    ])->name('create');

    Route::post('/store', [IngredientController::class, 'store'])->defaults('_config', [
        'redirect' => 'ingredients.index'
    ])->name('store');

    Route::get('/edit/{id}', [IngredientController::class, 'edit'])->defaults('_config', [
        'view' => 'ingredients.edit'
    ])->name('edit');

    Route::post('/update/{id}', [IngredientController::class, 'update'])->defaults('_config', [
        'redirect' => 'ingredients.index'
    ])->name('update');

    Route::get('/delete/{id}', [IngredientController::class, 'delete'])->defaults('_config', [
        'view' => 'ingredients.delete'
    ])->name('delete');

    Route::delete('/destroy/{id}', [IngredientController::class, 'destroy'])->defaults('_config', [
        'redirect' => 'ingredients.index'
    ])->name('destroy');

    Route::get('/recycle', [IngredientController::class, 'recycle'])->defaults('_config', [
        'view' => 'ingredients.recycle'
    ])->name('recycle');

    Route::get('/restore/{id}', [IngredientController::class, 'restore'])->defaults('_config', [
        'redirect' => 'ingredients.recycle'
    ])->name('restore');

    Route::get('/force-delete/{id}', [IngredientController::class, 'forceDelete'])->defaults('_config', [
        'redirect' => 'ingredients.recycle'
    ])->name('forceDelete');
});

// Quản lý bao bì
Route::group(['prefix' => 'packagings', 'as' => 'packagings.'], function () {
    Route::get('/', [PackagingController::class, 'index'])->defaults('_config', [
        'view' => 'packagings.index'
    ])->name('index');

    Route::get('/create', [PackagingController::class, 'create'])->defaults('_config', [
        'view' => 'packagings.create'
    ])->name('create');

    Route::post('/store', [PackagingController::class, 'store'])->defaults('_config', [
        'redirect' => 'packagings.index'
    ])->name('store');

    Route::get('/edit/{id}', [PackagingController::class, 'edit'])->defaults('_config', [
        'view' => 'packagings.edit'
    ])->name('edit');

    Route::post('/update/{id}', [PackagingController::class, 'update'])->defaults('_config', [
        'redirect' => 'packagings.index'
    ])->name('update');

    Route::get('/delete/{id}', [PackagingController::class, 'delete'])->defaults('_config', [
        'view' => 'packagings.delete'
    ])->name('delete');

    Route::delete('/destroy/{id}', [PackagingController::class, 'destroy'])->defaults('_config', [
        'redirect' => 'packagings.index'
    ])->name('destroy');

    Route::get('/recycle', [PackagingController::class, 'recycle'])->defaults('_config', [
        'view' => 'packagings.recycle'
    ])->name('recycle');

    Route::get('/restore/{id}', [PackagingController::class, 'restore'])->defaults('_config', [
        'redirect' => 'packagings.recycle'
    ])->name('restore');

    Route::get('/force-delete/{id}', [PackagingController::class, 'forceDelete'])->defaults('_config', [
        'redirect' => 'packagings.recycle'
    ])->name('forceDelete');
});

// Quản lý công thức
Route::group(['prefix' => 'recipes', 'as' => 'recipes.'], function () {
    Route::get('/', [RecipeController::class, 'index'])->defaults('_config', [
        'view' => 'recipes.index'
    ])->name('index');

    Route::get('/create', [RecipeController::class, 'create'])->defaults('_config', [
        'view' => 'recipes.create'
    ])->name('create');

    Route::post('/store', [RecipeController::class, 'store'])->defaults('_config', [
        'redirect' => 'recipes.index'
    ])->name('store');

    Route::get('/edit/{id}', [RecipeController::class, 'edit'])->defaults('_config', [
        'view' => 'recipes.edit'
    ])->name('edit');

    Route::post('/update/{id}', [RecipeController::class, 'update'])->defaults('_config', [
        'redirect' => 'recipes.index'
    ])->name('update');

    Route::get('/delete/{id}', [RecipeController::class, 'delete'])->defaults('_config', [
        'view' => 'recipes.delete'
    ])->name('delete');

    Route::delete('/destroy/{id}', [RecipeController::class, 'destroy'])->defaults('_config', [
        'redirect' => 'recipes.index'
    ])->name('destroy');

    Route::get('/recycle', [RecipeController::class, 'recycle'])->defaults('_config', [
        'view' => 'recipes.recycle'
    ])->name('recycle');

    Route::get('/restore/{id}', [RecipeController::class, 'restore'])->defaults('_config', [
        'redirect' => 'recipes.recycle'
    ])->name('restore');

    Route::get('/force-delete/{id}', [RecipeController::class, 'forceDelete'])->defaults('_config', [
        'redirect' => 'recipes.recycle'
    ])->name('forceDelete');
});

// Sản xuất bánh
Route::group(['prefix' => 'cakes', 'as' => 'cakes.'], function () {
    Route::get('/', [CakeController::class, 'index'])->defaults('_config', [
        'view' => 'cakes.index'
    ])->name('index');

    Route::post('/produce', [CakeController::class, 'produce'])->defaults('_config', [
        'redirect' => 'cakes.index'
    ])->name('produce');
});

// Bán bánh
Route::group(['prefix' => 'products', 'as' => 'products.'], function () {
    Route::get('/', [ProductController::class, 'index'])->defaults('_config', [
        'view' => 'products.index'
    ])->name('index');

    Route::post('/sell', [ProductController::class, 'sell'])->defaults('_config', [
        'redirect' => 'products.index'
    ])->name('sell');
});

// Báo cáo doanh thu
Route::group(['prefix' => 'reports', 'as' => 'reports.'], function () {
    Route::get('/', [ReportController::class, 'index'])->defaults('_config', [
        'view' => 'reports.index'
    ])->name('index');
});

require __DIR__.'/auth.php';
