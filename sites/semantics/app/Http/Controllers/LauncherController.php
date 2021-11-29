<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;

class LauncherController extends Controller
{

    /**
     * Page lancer une analyse
     */
    public function analyseLauncher()
    {
        return redirect()->route('analyse.launcher.page');
    }

    /**
     * Page lancer une analyse Page
     */
    public function analyseLauncherPage()
    {
        $breadcrumb = [['title' => 'Analyse sémantique d\'une page', 'link' => route(Route::getCurrentRoute()->getName())]];
        View::share('breadcrumb', $breadcrumb);
        return view('pages.launcher.page');
    }

    /**
     * Page lancer une analyse Site
     */
    public function analyseLauncherSite()
    {
        $breadcrumb = [['title' => 'Analyse sémantique d\'un site', 'link' => route(Route::getCurrentRoute()->getName())]];
        View::share('breadcrumb', $breadcrumb);
        return view('pages.launcher.site');
    }

    /**
     * Page lancer une analyse Web
     */
    public function analyseLauncherWeb()
    {
        $breadcrumb = [['title' => 'Analyse sémantique d\'une thématique', 'link' => route(Route::getCurrentRoute()->getName())]];
        View::share('breadcrumb', $breadcrumb);
        return view('pages.launcher.web');
    }

    /**
     * Page lancer une analyse Custom
     */
    public function analyseLauncherCustom()
    {
        $breadcrumb = [['title' => 'Analyse sémantique d\'un fichier personalisé', 'link' => route(Route::getCurrentRoute()->getName())]];
        View::share('breadcrumb', $breadcrumb);
        return view('pages.launcher.custom');
    }

    /**
     * Page lancer une analyse Suggest
     */
    public function analyseLauncherSuggest()
    {
        $breadcrumb = [['title' => 'Trouver des suggestions', 'link' => route(Route::getCurrentRoute()->getName())]];
        View::share('breadcrumb', $breadcrumb);
        return view('pages.launcher.suggest');
    }

}
