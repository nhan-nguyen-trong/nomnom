<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\IngredientController;
use App\Http\Controllers\PackagingController;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\CakeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReportController;

// Dashboard tại URL gốc '/'
Route::get('/', [DashboardController::class, 'index'])->defaults('_config', [
    'view' => 'dashboard'
])->name('dashboard.index');

// Quản lý nguyên liệu
Route::group(['prefix' => 'ingredients', 'as' => 'ingredients.'], function () {
    // Route tùy chỉnh cho recycle, restore, forceDelete của phân loại nguyên liệu
    Route::get('/recycle', [IngredientController::class, 'recycle'])->defaults('_config', [
        'view' => 'ingredients.recycle'
    ])->name('recycle');

    Route::post('/restore/{id}', [IngredientController::class, 'restore'])->defaults('_config', [
        'redirect' => 'ingredients.recycle'
    ])->name('restore');

    Route::post('/force-delete/{id}', [IngredientController::class, 'forceDelete'])->defaults('_config', [
        'redirect' => 'ingredients.recycle'
    ])->name('forceDelete');

    // Route cho việc quản lý nguyên liệu trong phân loại
    Route::get('/{categoryId}/create-ingredient', [IngredientController::class, 'createIngredient'])->defaults('_config', [
        'view' => 'ingredients.create_ingredient'
    ])->name('createIngredient');

    Route::post('/{categoryId}/store-ingredient', [IngredientController::class, 'storeIngredient'])->defaults('_config', [
        'redirect' => 'ingredients.show'
    ])->name('storeIngredient');

    Route::get('/edit-ingredient/{id}', [IngredientController::class, 'editIngredient'])->defaults('_config', [
        'view' => 'ingredients.edit_ingredient'
    ])->name('editIngredient');

    Route::put('/update-ingredient/{id}', [IngredientController::class, 'updateIngredient'])->defaults('_config', [
        'redirect' => 'ingredients.show'
    ])->name('updateIngredient');

    Route::delete('/destroy-ingredient/{id}', [IngredientController::class, 'destroyIngredient'])->defaults('_config', [
        'redirect' => 'ingredients.show'
    ])->name('destroyIngredient');

    // Route cho thùng rác của nguyên liệu trong phân loại
    Route::get('/{categoryId}/recycle-ingredient', [IngredientController::class, 'recycleIngredient'])->defaults('_config', [
        'view' => 'ingredients.recycle_ingredient'
    ])->name('recycleIngredient');

    Route::post('/restore-ingredient/{id}', [IngredientController::class, 'restoreIngredient'])->defaults('_config', [
        'redirect' => 'ingredients.recycleIngredient'
    ])->name('restoreIngredient');

    Route::post('/force-delete-ingredient/{id}', [IngredientController::class, 'forceDeleteIngredient'])->defaults('_config', [
        'redirect' => 'ingredients.recycleIngredient'
    ])->name('forceDeleteIngredient');

    // Sử dụng Route::resource để định nghĩa các route chuẩn cho phân loại nguyên liệu
    // Đặt ở cuối để tránh ghi đè các route cụ thể
    Route::resource('/', IngredientController::class)->parameters(['' => 'ingredient']);
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

    Route::get('/create', [CakeController::class, 'create'])->defaults('_config', [
        'view' => 'cakes.create'
    ])->name('create');

    Route::post('/store', [CakeController::class, 'store'])->defaults('_config', [
        'redirect' => 'cakes.index'
    ])->name('store');

    Route::get('/edit/{id}', [CakeController::class, 'edit'])->defaults('_config', [
        'view' => 'cakes.edit'
    ])->name('edit');

    Route::post('/update/{id}', [CakeController::class, 'update'])->defaults('_config', [
        'redirect' => 'cakes.index'
    ])->name('update');

    Route::delete('/destroy/{id}', [CakeController::class, 'destroy'])->defaults('_config', [
        'redirect' => 'cakes.index'
    ])->name('destroy');

    Route::get('/recycle', [CakeController::class, 'recycle'])->defaults('_config', [
        'view' => 'cakes.recycle'
    ])->name('recycle');

    Route::get('/restore/{id}', [CakeController::class, 'restore'])->defaults('_config', [
        'redirect' => 'cakes.recycle'
    ])->name('restore');

    Route::get('/force-delete/{id}', [CakeController::class, 'forceDelete'])->defaults('_config', [
        'redirect' => 'cakes.recycle'
    ])->name('forceDelete');
});

// Bán bánh
Route::group(['prefix' => 'products', 'as' => 'products.'], function () {
    Route::get('/', [ProductController::class, 'index'])->defaults('_config', [
        'view' => 'products.index'
    ])->name('index');

    Route::get('/create', [ProductController::class, 'create'])->defaults('_config', [
        'view' => 'products.create'
    ])->name('create');

    Route::post('/store', [ProductController::class, 'store'])->defaults('_config', [
        'redirect' => 'products.index'
    ])->name('store');

    Route::get('/edit/{id}', [ProductController::class, 'edit'])->defaults('_config', [
        'view' => 'products.edit'
    ])->name('edit');

    Route::post('/update/{id}', [ProductController::class, 'update'])->defaults('_config', [
        'redirect' => 'products.index'
    ])->name('update');

    Route::delete('/destroy/{id}', [ProductController::class, 'destroy'])->defaults('_config', [
        'redirect' => 'products.index'
    ])->name('destroy');

    Route::get('/recycle', [ProductController::class, 'recycle'])->defaults('_config', [
        'view' => 'products.recycle'
    ])->name('recycle');

    Route::get('/restore/{id}', [ProductController::class, 'restore'])->defaults('_config', [
        'redirect' => 'products.recycle'
    ])->name('restore');

    Route::get('/force-delete/{id}', [ProductController::class, 'forceDelete'])->defaults('_config', [
        'redirect' => 'products.recycle'
    ])->name('forceDelete');
});

// Báo cáo doanh thu
Route::group(['prefix' => 'reports', 'as' => 'reports.'], function () {
    Route::get('/', [ReportController::class, 'index'])->defaults('_config', [
        'view' => 'reports.index'
    ])->name('index');

    Route::get('/create', [ReportController::class, 'create'])->defaults('_config', [
        'view' => 'reports.create'
    ])->name('create');

    Route::post('/store', [ReportController::class, 'store'])->defaults('_config', [
        'redirect' => 'reports.index'
    ])->name('store');

    Route::get('/edit/{id}', [ReportController::class, 'edit'])->defaults('_config', [
        'view' => 'reports.edit'
    ])->name('edit');

    Route::post('/update/{id}', [ReportController::class, 'update'])->defaults('_config', [
        'redirect' => 'reports.index'
    ])->name('update');

    Route::get('/delete/{id}', [ReportController::class, 'delete'])->defaults('_config', [
        'view' => 'reports.delete'
    ])->name('delete');

    Route::delete('/destroy/{id}', [ReportController::class, 'destroy'])->defaults('_config', [
        'redirect' => 'reports.index'
    ])->name('destroy');

    Route::get('/recycle', [ReportController::class, 'recycle'])->defaults('_config', [
        'view' => 'reports.recycle'
    ])->name('recycle');

    Route::get('/restore/{id}', [ReportController::class, 'restore'])->defaults('_config', [
        'redirect' => 'reports.recycle'
    ])->name('restore');

    Route::get('/force-delete/{id}', [ReportController::class, 'forceDelete'])->defaults('_config', [
        'redirect' => 'reports.recycle'
    ])->name('forceDelete');
});
