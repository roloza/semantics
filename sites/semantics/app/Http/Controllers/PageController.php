<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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


}
