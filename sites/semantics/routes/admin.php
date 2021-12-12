<?php


use Illuminate\Support\Facades\Route;

Route::prefix('admin')->name('admin.')->group(function () {
    Route::post('/attachments', [\App\Http\Controllers\Admin\AttachmentController::class, 'store'])->name('attachments.store');
    Route::resource('/posts', \App\Http\Controllers\Admin\PostController::class);
});
