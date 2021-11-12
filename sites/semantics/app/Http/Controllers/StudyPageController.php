<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\Url;
use Illuminate\Http\Request;
use App\Models\SyntexRtListe;
use App\Models\SyntexAuditDesc;
use App\Models\SyntexAuditListe;

class StudyPageController extends Controller
{
    private $uuid;
    private $job;

    public function __construct(Request $request)
    {
        $this->uuid = $request->uuid;
        $this->job = Job::find($request->uuid);
    }

    /**
     * Etude Page show
     */
    public function show()
    {
        $uuid = $this->uuid;
        $job = $this->job;
        $countUrls = Url::GetStudyUrls($this->uuid)->count();
        $countKeywords = SyntexRtListe::countBy($this->uuid, 'all')->count();
        $countSyntagmes = SyntexRtListe::countBy($this->uuid, 'syntagmes')->count();

        $topKeywords = SyntexAuditListe::getBestKeywords($this->uuid)->take(5)->get();
        $bestKeyword = $topKeywords->first();
        $dataWordCloud = SyntexAuditListe::getDataWordCloud($this->uuid);

        $bestKeywordLength1 = (SyntexRtListe::getBestKeywordByLength($this->uuid)->first())->forme;

        // $dataKeywordGraph = (new KeywordsGraphV2($this->uuid, $bestKeywordLength1))->run();

        return view('pages.analyse.page.show', compact('job', 'countKeywords', 'countSyntagmes', 'countUrls', 'bestKeyword', 'topKeywords', 'dataWordCloud', 'bestKeywordLength1', 'uuid'));
    }

    /**
     * Page Tous les mots-clés
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function showAllKeywords()
    {
        return view('pages.analyse.page.show-keywords', ['uuid' => $this->uuid]);
    }

     /**
     * Page Descripteurs du corpus
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function showDescripteurs()
    {
        return view('pages.analyse.page.show-descripteurs', ['uuid' => $this->uuid]);
    }

    /**
     * Page Suggestions de mots-clés
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function showSuggestions(Request $request)
    {
        $suggestKeyword = SyntexRtListe::where('uuid', $this->uuid)->whereIn('cat', ['V', 'N'])->orderBy('nincl', 'DESC')->first();
        $keyword = $request->keyword ? $request->keyword : $suggestKeyword->forme;
        return view('pages.analyse.page.show-suggestions', [
            'uuid' => $this->uuid,
            'keyword' => $keyword
        ]);
    }

    /**
     * Page détail d'un mot-clé
     * @param $taskId
     * @param $num
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function showKeyword($uuid, $num)
    {
        $keyword = SyntexRtListe::getKeywordByNum($uuid, (int)$num)->firstOrFail();

        $synonymsByKeywords = null;//Synonyms::getSynonymsByExpression($keyword->lemme, 10);
        $antonymesByKeywords = null;//Antonyms::getAntonymsByExpression($keyword->lemme, 10);
        // foreach ($synonymsByKeywords as $k => $synonymsByKeyword) {
        //     foreach ($synonymsByKeyword as $k2 => $synonymByKeyword) {
        //         $keywordSyn = SyntexRtListe::getKeywordByLemme($uuid, $synonymByKeyword)->first();
        //         if ($keywordSyn !== null) {
        //             $synonymsByKeywords[$k][$k2] = $keywordSyn;
        //         }
        //     }
        // }

        $keywordDocs = SyntexAuditDesc::getKeywordDocs($uuid, (int)$num)->get();
        dd($keywordDocs);
        $keywordsSuggest = null; //SyntexAuditDesc::GetNumsSimilaireKeywords($uuid, $keywordDocs, (int)$num);
        $includings = SyntexRtListe::getIncludings($uuid, $keyword)->take(25)->get();

        $keywordsIncludeds = [];
        if ($keyword->longueur > 1) {
            $keywordsIncludeds = SyntexRtListe::getIncludeds($uuid, $keyword);
        }


        return view('pages.analyse.page.show-keyword', [
            'uuid' => $this->uuid,
            'keyword' => $keyword,
            'synonymsByKeywords' => $synonymsByKeywords,
            'antonymesByKeywords' => $antonymesByKeywords,
            'keywordDocs' => $keywordDocs,
            'keywordsSuggest' => $keywordsSuggest,
            'includings' => $includings,
            'keywordsIncludeds' => $keywordsIncludeds
        ]);
    }
}
