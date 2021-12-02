<?php


use Illuminate\Support\Facades\Route;

Route::get('/export/{uuid}/audit-list', [\App\Http\Controllers\ExportController::class, 'auditList'])->name('export.audit-list');
Route::get('/export/{uuid}/rt-list', [\App\Http\Controllers\ExportController::class, 'rtList'])->name('export.rt-list');
Route::get('/export/{uuid}/urls', [\App\Http\Controllers\ExportController::class, 'urls'])->name('export.urls');
