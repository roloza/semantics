<?php

use Illuminate\Support\Facades\Route;

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

// Accueil
Route::get('/', \App\Http\Controllers\PageController::class . '@accueil')->name('accueil');

// Analyse
Route::get('/analyses', \App\Http\Controllers\PageController::class . '@analyseList')->name('analyse.list');
Route::get('/analyse-page', \App\Http\Controllers\LauncherController::class . '@analyseLauncherPage')->name('analyse.launcher.page');
Route::get('/analyse-site', \App\Http\Controllers\LauncherController::class . '@analyseLauncherSite')->name('analyse.launcher.site');
Route::get('/analyse-web', \App\Http\Controllers\LauncherController::class . '@analyseLauncherWeb')->name('analyse.launcher.web');
Route::get('/analyse-custom', \App\Http\Controllers\LauncherController::class . '@analyseLauncherCustom')->name('analyse.launcher.custom');
