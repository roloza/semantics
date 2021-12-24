<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\Url;
use App\Models\Antonym;
use App\Models\Synonym;
use Illuminate\Http\Request;
use App\Models\SyntexRtListe;
use App\Custom\AuditValidation;
use App\Models\SyntexAuditDesc;
use App\Models\SyntexAuditListe;
use App\Models\SeoAuditStructure;
use App\Models\SyntexDescripteur;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;

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

        $breadcrumb = [
            ['title' => 'Mes analyses', 'link' => route('analyse.list')],
            ['title' =>  'Analyse ' . $job->type->name . ' - ' . $job->name]
        ];
        View::share('breadcrumb', $breadcrumb);
        return view('pages.analyse.show', compact('job', 'countKeywords', 'countSyntagmes', 'countUrls', 'bestKeyword', 'topKeywords', 'dataWordCloud', 'bestKeywordLength1'));
    }

    /**
     * Page Tous les mots-clés
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function showAllKeywords()
    {
        $breadcrumb = [
            ['title' => 'Mes analyses', 'link' => route('analyse.list')],
            ['title' =>  'Analyse ' . $this->job->type->name . ' - ' . $this->job->name, 'link' => route('analyse.show', ['type' => $this->job->type->name, 'uuid' => $this->job->uuid])],
            ['title' => 'Tous les mots-clés']
        ];
        View::share('breadcrumb', $breadcrumb);
        return view('pages.analyse.show-keywords', ['job' => $this->job]);
    }

     /**
     * Page Descripteurs du corpus
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function showDescripteurs()
    {
        $breadcrumb = [
            ['title' => 'Mes analyses', 'link' => route('analyse.list')],
            ['title' =>  'Analyse ' . $this->job->type->name . ' - ' . $this->job->name, 'link' => route('analyse.show', ['type' => $this->job->type->name, 'uuid' => $this->job->uuid])],
            ['title' => 'Sujets principaux']
        ];
        View::share('breadcrumb', $breadcrumb);
        return view('pages.analyse.show-descripteurs', ['job' => $this->job]);
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

        $breadcrumb = [
            ['title' => 'Mes analyses', 'link' => route('analyse.list')],
            ['title' =>  'Analyse ' . $this->job->type->name . ' - ' . $this->job->name, 'link' => route('analyse.show', ['type' => $this->job->type->name, 'uuid' => $this->job->uuid])],
            ['title' => 'Suggestions de thématiques']
        ];
        View::share('breadcrumb', $breadcrumb);

        return view('pages.analyse.show-suggestions', [
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

        $synonymsByKeywords = Synonym::fuzzySearchByExpression($keyword->forme);
        $antonymesByKeywords = Antonym::fuzzySearchByExpression($keyword->forme);

        $keywordDocs = SyntexAuditDesc::getKeywordDocs($this->job->uuid, (int)$request->num)->get();
        $keywordsSuggest = SyntexAuditDesc::GetNumsSimilaireKeywords($this->job->uuid, $keywordDocs, (int)$request->num);
        $includings = SyntexRtListe::getIncludings($this->job->uuid, $keyword)->take(25)->get();

        $keywordsIncludeds = [];
        if ($keyword->longueur > 1) {
            $keywordsIncludeds = SyntexRtListe::getIncludeds($this->job->uuid, $keyword);
        }

        $breadcrumb = [
            ['title' => 'Mes analyses', 'link' => route('analyse.list')],
            ['title' =>  'Analyse ' . $this->job->type->name . ' - ' . $this->job->name, 'link' => route('analyse.show', ['type' => $this->job->type->name, 'uuid' => $this->job->uuid])],
            ['title' => $keyword->forme]
        ];
        View::share('breadcrumb', $breadcrumb);

        return view('pages.analyse.show-keyword', [
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

        $breadcrumb = [
            ['title' => 'Mes analyses', 'link' => route('analyse.list')],
            ['title' =>  'Analyse ' . $this->job->type->name . ' - ' . $this->job->name, 'link' => route('analyse.show', ['type' => $this->job->type->name, 'uuid' => $this->job->uuid])],
            ['title' => 'Liste des urls']
        ];
        View::share('breadcrumb', $breadcrumb);

        return view('pages.analyse.show-urls', ['job' => $job]);
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

        $breadcrumb = [
            ['title' => 'Mes analyses', 'link' => route('analyse.list')],
            ['title' =>  'Analyse ' . $this->job->type->name . ' - ' . $this->job->name, 'link' => route('analyse.show', ['type' => $this->job->type->name, 'uuid' => $this->job->uuid])],
            ['title' => $url->url]
        ];
        View::share('breadcrumb', $breadcrumb);

        return view('pages.analyse.show-url', ['job' => $this->job, 'url' => $url]);
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
        $keywords = SyntexDescripteur::tableUrlDetail(['uuid' => $this->job->uuid, 'doc_id' => $request->doc_id])->get();

        $dataWordCloud = [];
        foreach ($keywords as $keyword) {

            $dataWordCloud[] = [
                'name' => $keyword->forme,
                'weight' => (int)$keyword->freq_pond
            ];

        }
        $dataWordCloud = json_encode($dataWordCloud);

        $breadcrumb = [
            ['title' => 'Mes analyses', 'link' => route('analyse.list')],
            ['title' =>  'Analyse ' . $this->job->type->name . ' - ' . $this->job->name, 'link' => route('analyse.show', ['type' => $this->job->type->name, 'uuid' => $this->job->uuid])],
            ['title' => 'Nuage de mots-clés']
        ];
        View::share('breadcrumb', $breadcrumb);

        return view('pages.analyse.show-url-cloud', ['job' => $this->job, 'url' => $url, 'dataWordCloud' => $dataWordCloud]);
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

        $breadcrumb = [
            ['title' => 'Mes analyses', 'link' => route('analyse.list')],
            ['title' =>  'Analyse ' . $this->job->type->name . ' - ' . $this->job->name, 'link' => route('analyse.show', ['type' => $this->job->type->name, 'uuid' => $this->job->uuid])],
            ['title' => 'Audit SEO']
        ];
        View::share('breadcrumb', $breadcrumb);
        return view('pages.analyse.show-url-audit', ['job' => $this->job, 'url' => $url, 'audit' => $audit, 'auditStructure' => $auditStructure, 'auditStructureScore' => $auditStructureScore]);
    }

    /**
     * Page de listing des suggests trouvés
     */
    public function showKeywordsSuggest(Request $request)
    {
        $breadcrumb = [
            ['title' => 'Mes analyses', 'link' => route('analyse.list')],
            ['title' =>  'Analyse ' . $this->job->type->name . ' - ' . $this->job->name, 'link' => route('analyse.show', ['type' => $this->job->type->name, 'uuid' => $this->job->uuid])],
            ['title' => 'Suggestions']
        ];
        View::share('breadcrumb', $breadcrumb);
        return view('pages.analyse.show-keywords-suggest', ['job' => $this->job, 'keyword' => $request->keyword]);


    }


}
