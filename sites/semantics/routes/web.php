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
Route::get('/analyse/page', \App\Http\Controllers\LauncherController::class . '@analyseLauncherPage')->name('analyse.launcher.page');
Route::get('/analyse/site', \App\Http\Controllers\LauncherController::class . '@analyseLauncherSite')->name('analyse.launcher.site');
Route::get('/analyse/web', \App\Http\Controllers\LauncherController::class . '@analyseLauncherWeb')->name('analyse.launcher.web');
Route::get('/analyse/custom', \App\Http\Controllers\LauncherController::class . '@analyseLauncherCustom')->name('analyse.launcher.custom');

// Analyse détails
//Page
Route::get('/analyse/page/{uuid}', \App\Http\Controllers\StudyPageController::class . '@show')->name('analyse.page.show');
Route::get('/analyse/page/{uuid}/tous-les-mots-cles', \App\Http\Controllers\StudyPageController::class . '@showAllKeywords')->name('analyse.page.show.keywords.all');
Route::get('/analyse/page/{uuid}/descripteurs', \App\Http\Controllers\StudyPageController::class . '@showDescripteurs')->name('analyse.page.show.descripteurs');
Route::get('/analyse/page/{uuid}/suggestions', \App\Http\Controllers\StudyPageController::class . '@showSuggestions')->name('analyse.page.show.suggestions');
Route::get('/analyse/page/{uuid}/keyword/{num}', \App\Http\Controllers\StudyPageController::class . '@showKeyword')->name('analyse.page.show.keyword');


// Site
Route::get('/analyse/site/{uuid}', \App\Http\Controllers\StudyPageController::class . '@show')->name('analyse.site.show');

// Web
Route::get('/analyse/web/{uuid}', \App\Http\Controllers\StudyPageController::class . '@show')->name('analyse.web.show');

// Custom
Route::get('/analyse/custom/{uuid}', \App\Http\Controllers\StudyPageController::class . '@show')->name('analyse.custom.show');

// Ajax
Route::get('/ajax/network-graph-data/{uuid}', \App\Http\Controllers\AjaxController::class . '@getNetworkgraph')->name('ajax.networkgraph-data');
