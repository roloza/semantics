<?php

namespace App\Http\Controllers;

use App\Custom\Tools\Avatar;
use App\Models\Job;
use App\Models\Synonym;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;

class PageController extends Controller
{
    /**
     * Page d'accueil
     */
    public function accueil()
    {
        return view('pages.accueil');
    }

    /**
     * Page liste des analyses
     */
    public function analyseList()
    {
        $breadcrumb = [['title' => 'Analyse', 'link' => route(Route::getCurrentRoute()->getName())]];
        View::share('breadcrumb', $breadcrumb);
        return view('pages.analyse.list');
    }

    /**
     * Page de recherche d'un synonyme
     */
    public function synonym()
    {
        $breadcrumb = [['title' => 'Recherche de synonymes', 'link' => route(Route::getCurrentRoute()->getName())]];
        View::share('breadcrumb', $breadcrumb);
        return view('pages.dico.synonym');
    }

     /**
     * Page de recherche d'un antonyme
     */
    public function antonym()
    {
        $breadcrumb = [['title' => 'Recherche d\'antonymes', 'link' => route(Route::getCurrentRoute()->getName())]];
        View::share('breadcrumb', $breadcrumb);
        return view('pages.dico.antonym');
    }

    /**
     * Page profil d'un utilisateur
     */
    public function userProfile()
    {
        $user = Auth::user();
        $jobs = Job::where('user_id', $user->id)->where('status_id', 3)->orderBy('created_at', 'DESC')->get();
        $breadcrumb = [['title' => 'Profile']];
        View::share('breadcrumb', $breadcrumb);
        return view('pages.user.profil', [
            'user' => $user,
            'jobs' => $jobs
        ]);
    }



}
