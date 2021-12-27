<?php


use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('/posts', \App\Http\Controllers\Admin\PostController::class);
    Route::resource('/faqs', \App\Http\Controllers\Admin\FaqController::class);
    Route::resource('/images', \App\Http\Controllers\Admin\ImageController::class);
    Route::resource('/categories', \App\Http\Controllers\Admin\CategoryController::class);

    Route::post('/attachments', [\App\Http\Controllers\Admin\AttachmentController::class, 'store'])->name('attachments.store');
    Route::get('/users', [\App\Http\Controllers\Admin\UserController::class, 'index'])->name('users.index');
});
