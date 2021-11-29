<?php

namespace App\Http\Controllers;

use App\Models\Synonym;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

        return view('pages.analyse.list');
    }

    /**
     * Page de recherche d'un synonyme
     */
    public function synonym()
    {
        return view('pages.dico.synonym');
    }

     /**
     * Page de recherche d'un antonyme
     */
    public function antonym()
    {
        return view('pages.dico.antonym');
    }




}
