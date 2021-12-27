<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class FaqController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $faq = Faq::firstOrFail();
        return redirect(route('faq.show', $faq->slug));
    }



    /**
     * Display the specified resource.
     *
     * @param $slug
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $faq = Faq::where('slug', $slug)->firstOrFail();

        $breadcrumb = [['title' => 'Faq', 'link' => route('faq.index')], ['title' => $faq->name]];
        View::share('breadcrumb', $breadcrumb);

        $faqNavs = Faq::select('name', 'slug')->where('active', 1)->orderBy('position', 'ASC')->get();

        return view('pages.faq.show', ['faq' => $faq, 'faqNavs' => $faqNavs]);
    }


}
