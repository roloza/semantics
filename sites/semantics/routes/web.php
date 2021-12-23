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

// Blog
Route::get('/articles', \App\Http\Controllers\PostController::class . '@index')->name('blog.index');
Route::get('/article/{slug}', \App\Http\Controllers\PostController::class . '@show')->name('blog.show');

// Faq
Route::get('/faq', \App\Http\Controllers\FaqController::class . '@index')->name('faq.index');

// Démos
Route::get('/demos', \App\Http\Controllers\PageController::class . '@demos')->name('demos');

// Affichage images
Route::get('image/{filename}', \App\Http\Controllers\ImageController::class . '@displayImage')->name('image.displayImage');

// Analyse
Route::get('/analyses', \App\Http\Controllers\PageController::class . '@analyseList')->name('analyse.list');
Route::middleware(['auth'])->group(function () {
    Route::get('/analyse/page', \App\Http\Controllers\LauncherController::class . '@analyseLauncherPage')->name('analyse.launcher.page');
    Route::get('/analyse/site', \App\Http\Controllers\LauncherController::class . '@analyseLauncherSite')->name('analyse.launcher.site');
    Route::get('/analyse/web', \App\Http\Controllers\LauncherController::class . '@analyseLauncherWeb')->name('analyse.launcher.web');
    Route::get('/analyse/custom', \App\Http\Controllers\LauncherController::class . '@analyseLauncherCustom')->name('analyse.launcher.custom');
    Route::get('/analyse/suggest', \App\Http\Controllers\LauncherController::class . '@analyseLauncherSuggest')->name('analyse.suggest');
});

// Analyse détails
Route::middleware(['user-job'])->group(function () {
    Route::get('/analyse/{type}/{uuid}', \App\Http\Controllers\StudyController::class . '@show')->name('analyse.show');
    Route::get('/analyse/{type}/{uuid}/tous-les-mots-cles', \App\Http\Controllers\StudyController::class . '@showAllKeywords')->name('analyse.show.keywords.all');
    Route::get('/analyse/{type}/{uuid}/descripteurs', \App\Http\Controllers\StudyController::class . '@showDescripteurs')->name('analyse.show.descripteurs');
    Route::get('/analyse/{type}/{uuid}/suggestions', \App\Http\Controllers\StudyController::class . '@showSuggestions')->name('analyse.show.suggestions');
    Route::get('/analyse/{type}/{uuid}/urls', \App\Http\Controllers\StudyController::class . '@showUrls')->name('analyse.show.urls');
    Route::get('/analyse/{type}/{uuid}/urls/{doc_id}', \App\Http\Controllers\StudyController::class . '@showUrl')->name('analyse.show.url');
    Route::get('/analyse/{type}/{uuid}/urls/{doc_id}/cloud', \App\Http\Controllers\StudyController::class . '@showUrlCloud')->name('analyse.show.url.cloud');
    Route::get('/analyse/{type}/{uuid}/urls/{doc_id}/audit', \App\Http\Controllers\StudyController::class . '@showUrlAudit')->name('analyse.show.url.audit');
    Route::get('/analyse/{type}/{uuid}/keyword/{num}', \App\Http\Controllers\StudyController::class . '@showKeyword')->name('analyse.show.keyword');
    Route::get('/analyse/{type}/{uuid}/mots-cles-suggest', \App\Http\Controllers\StudyController::class . '@showKeywordsSuggest')->name('analyse.show.keywords.suggest');
});

Route::get('dictionnaire/synonymes', \App\Http\Controllers\PageController::class . '@synonym')->name('dictionnaire.synonyms');
Route::get('dictionnaire/antonymes', \App\Http\Controllers\PageController::class . '@antonym')->name('dictionnaire.antonyms');

// Ajax
Route::middleware(['user-job'])->group(function () {
    Route::get('/ajax/network-graph-data/{uuid}', \App\Http\Controllers\AjaxController::class . '@getNetworkgraph')->name('ajax.networkgraph-data');
    Route::get('/ajax/suggest/{uuid}', \App\Http\Controllers\AjaxController::class . '@getSuggest')->name('ajax.suggest-data');
});

// Auth
Route::get('/mon-profil', \App\Http\Controllers\PageController::class . '@userProfile')->middleware(['auth'])->name('user.profile');

require __DIR__.'/auth.php';
require __DIR__.'/export.php';
require __DIR__.'/admin.php';
require __DIR__.'/socialite.php';