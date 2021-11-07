<?php

namespace App\Http\Controllers;

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
        return view('pages.launcher.page');
    }

    /**
     * Page lancer une analyse Site
     */
    public function analyseLauncherSite()
    {
        return view('pages.launcher.site');
    }

    /**
     * Page lancer une analyse Web
     */
    public function analyseLauncherWeb()
    {
        return view('pages.launcher.web');
    }

    /**
     * Page lancer une analyse Custom
     */
    public function analyseLauncherCustom()
    {
        return view('pages.launcher.custom');
    }

}
