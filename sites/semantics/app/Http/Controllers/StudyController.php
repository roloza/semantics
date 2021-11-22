<?php

namespace App\Http\Controllers;

use App\Custom\AuditValidation;
use App\Models\Job;
use App\Models\SeoAuditStructure;
use App\Models\Url;
use Illuminate\Http\Request;
use App\Models\SyntexRtListe;
use App\Models\SyntexAuditDesc;
use App\Models\SyntexAuditListe;
use App\Models\SyntexDescripteur;

class StudyController extends Controller
{
    private $uuid;
    private $job;

    public function __construct(Request $request)
    {
        $this->uuid = $request->uuid;
        $this->job = Job::where('uuid', $this->uuid)->first();
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

        $bestKeywordLength1 = (SyntexRtListe::getBestKeywordByLength($this->job->uuid)->first())->forme;

        // $dataKeywordGraph = (new KeywordsGraphV2($this->uuid, $bestKeywordLength1))->run();

        return view('pages.analyse.page.show', compact('job', 'countKeywords', 'countSyntagmes', 'countUrls', 'bestKeyword', 'topKeywords', 'dataWordCloud', 'bestKeywordLength1'));
    }

    /**
     * Page Tous les mots-clés
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function showAllKeywords()
    {
        return view('pages.analyse.page.show-keywords', ['job' => $this->job]);
    }

     /**
     * Page Descripteurs du corpus
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function showDescripteurs()
    {
        return view('pages.analyse.page.show-descripteurs', ['job' => $this->job]);
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
            'job' => $this->job,
            'keyword' => $keyword
        ]);
    }

    /**
     * Page détail d'un mot-clé
     * @param $uuid
     * @param $num
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function showKeyword(Request $request)
    {
        $keyword = SyntexRtListe::getKeywordByNum($this->job->uuid, (int)$request->num)->firstOrFail();

        $synonymsByKeywords = [];//Synonyms::getSynonymsByExpression($keyword->lemme, 10);
        $antonymesByKeywords = [];//Antonyms::getAntonymsByExpression($keyword->lemme, 10);
        // foreach ($synonymsByKeywords as $k => $synonymsByKeyword) {
        //     foreach ($synonymsByKeyword as $k2 => $synonymByKeyword) {
        //         $keywordSyn = SyntexRtListe::getKeywordByLemme($uuid, $synonymByKeyword)->first();
        //         if ($keywordSyn !== null) {
        //             $synonymsByKeywords[$k][$k2] = $keywordSyn;
        //         }
        //     }
        // }

        $keywordDocs = SyntexAuditDesc::getKeywordDocs($this->job->uuid, (int)$request->num)->get();
        $keywordsSuggest = SyntexAuditDesc::GetNumsSimilaireKeywords($this->job->uuid, $keywordDocs, (int)$request->num);
        $includings = SyntexRtListe::getIncludings($this->job->uuid, $keyword)->take(25)->get();

        $keywordsIncludeds = [];
        if ($keyword->longueur > 1) {
            $keywordsIncludeds = SyntexRtListe::getIncludeds($this->job->uuid, $keyword);
        }

        return view('pages.analyse.page.show-keyword', [
            'job' => $this->job,
            'keyword' => $keyword,
            'synonymsByKeywords' => $synonymsByKeywords,
            'antonymesByKeywords' => $antonymesByKeywords,
            'keywordDocs' => $keywordDocs,
            'keywordsSuggest' => $keywordsSuggest,
            'includings' => $includings,
            'keywordsIncludeds' => $keywordsIncludeds
        ]);
    }

    /**
     * Page Study Urls
     * @param $uuid
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function showUrls()
    {
        $job = $this->job;
        return view('pages.analyse.page.show-urls', ['job' => $job]);
    }

    /**
     * Page détail d'une url
     * @param $uuid
     * @param $docId
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function showUrl(Request $request)
    {
        $url = Url::getUrl($this->job->uuid, $request->doc_id)->firstOrFail();
        return view('pages.analyse.page.show-url', ['job' => $this->job, 'url' => $url]);
    }

    /**
     * Page détail d'une url Nuage
     * @param $uuid
     * @param $docId
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function showUrlCloud(Request $request)
    {
        $url = Url::getUrl($this->job->uuid, $request->doc_id)->firstOrFail();
        $keywords = SyntexDescripteur::tableUrlDetail(['job' => $this->job, 'doc_id' => $request->doc_id])->get();
        $dataWordCloud = [];
        foreach ($keywords as $keyword) {

            $dataWordCloud[] = [
                'name' => $keyword->forme,
                'weight' => (int)$keyword->freq_pond
            ];

        }
        $dataWordCloud = json_encode($dataWordCloud);
        return view('pages.analyse.page.show-url-cloud', ['job' => $this->job, 'url' => $url, 'dataWordCloud' => $dataWordCloud]);
    }

    /**
     * Page détail d'une url Audit de la structure
     * @param $uuid
     * @param $docId
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function showUrlAudit(Request $request)
    {
        $job = $this->job;
        $url = Url::getUrl($this->job->uuid, $request->doc_id)->firstOrFail();
        $audit = SeoAuditStructure::where('uuid', $this->job->uuid)->where('url_id', $url->id)->firstOrFail();
        $auditValidation = new AuditValidation($audit);
        $auditStructure = $auditValidation->getStructure();
        $auditStructureScore = $auditValidation->getStructureScore();
        return view('pages.analyse.page.show-url-audit', ['job' => $this->job, 'url' => $url, 'audit' => $audit, 'auditStructure' => $auditStructure, 'auditStructureScore' => $auditStructureScore]);
    }


}
