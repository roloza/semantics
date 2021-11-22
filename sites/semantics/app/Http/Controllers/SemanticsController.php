<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\Url;
use App\Models\Type;
use App\Jobs\SuggestJob;
use App\Jobs\WebCrawler;
use GuzzleHttp\Psr7\Uri;
use App\Jobs\PageCrawler;
use App\Jobs\SiteCrawler;
use Illuminate\Http\Request;
use App\Models\SyntexRtListe;
use App\Models\SyntexAuditDesc;
use App\Models\SyntexAuditIncl;
use App\Models\SyntexAuditListe;
use App\Models\SeoAuditStructure;
use App\Models\SyntexDescripteur;

/**
 * Class PingController
 * @package App\Http\Controllers
 */
class SemanticsController extends Controller
{

    private $type;

    public function __construct ()
    {
        $this->type = '';
    }
    public function index()
    {
        $jobs = Job::orderBy('created_at', 'DESC')->paginate(50);
        return $jobs;
    }

    public function store(Request $request)
    {
        $typeParam = $request->type ?? 'page';
        $url = $request->url ?? '';
        $keyword = $request->keyword ?? '';
        $totalCrawlLimit = $request->total_crawl_limit ?? 10;
        $isNews = $request->is_news ? (bool)$request->is_news : false;
        $typeContent = $request->type_content ? $request->type_content : 'all';

        $this->type = Type::where('slug', $typeParam)->first();

        switch($this->type->slug) {
            case 'suggest':
                $params = ['keyword' => $keyword];
                $uuid = $this->launchJobSuggest($params);
                break;
            case 'site':
                $params = ['url' => $url, 'totalCrawlLimit' => $totalCrawlLimit, 'typeContent' => $typeContent];
                $uuid = $this->launchJobSite($params);
                break;
            case 'web':
                $params = ['keyword' => $keyword, 'totalCrawlLimit' => $totalCrawlLimit, 'isNews' => $isNews, 'typeContent' => $typeContent];
                $uuid = $this->launchJobWeb($params);
                break;
            case 'page':
            default:
                $params = ['url' => $url, 'typeContent' => $typeContent];
                $uuid = $this->launchJobPage($params);
                break;
        }

        return response()->json([
            'message' => 'success',
            'uuid' => $uuid,
        ], 200);
    }



    public function destroy($uuid)
    {
        Job::where('uuid', $uuid)->delete();

        SeoAuditStructure::where('uuid', $uuid)->delete();

        SyntexAuditIncl::where('uuid', $uuid)->delete();

        SyntexAuditListe::where('uuid', $uuid)->delete();

        SyntexDescripteur::where('uuid', $uuid)->delete();

        SyntexRtListe::where('uuid', $uuid)->delete();

        Url::where('uuid', $uuid)->delete();

        SyntexAuditDesc::where('uuid', $uuid)->delete();
    }

    public function destroySuggest($uuid)
    {
        Job::where('uuid', $uuid)->delete();
        Url::where('uuid', $uuid)->delete();
        SyntexRtListe::where('uuid', $uuid)->delete();
        SyntexAuditIncl::where('uuid', $uuid)->delete();
    }

    private function launchJobPage($params)
    {

        $job = Job::hasJob($params, 1, $this->type->id);
        if ($job) {
            $this->destroy($job->uuid);
        }

        if (!filter_var($params['url'], FILTER_VALIDATE_URL)) {
            return response()->json([
                'message' => 'Invalid url'
            ], 200);
        }

        return $this->dispatch(new PageCrawler($params));
    }

    private function launchJobSite($params)
    {
        $job = Job::hasJob($params, 1, $this->type->id);
        if ($job) {
            $this->destroy($job->uuid);
        }
        if (!$url = filter_var($params['url'], FILTER_VALIDATE_URL)) {
            return response()->json([
                'message' => 'Invalid url'
            ], 200);
        }
        return $this->dispatch(new SiteCrawler($params));
    }

    private function launchJobWeb($params)
    {
        $job = Job::hasJob($params, 1, $this->type->id);
        if ($job) {
            $this->destroy($job->uuid);
        }
        if ($params['keyword'] === '') {
            return response()->json([
                'message' => 'Invalid keyword'
            ], 200);
        }
        return $this->dispatch(new WebCrawler($params));
    }

    private function launchJobSuggest($params)
    {
        $job = Job::hasJob($params, 1, $this->type->id);
        if ($job) {
            $this->destroySuggest($job->uuid);
        }
        if ($params['keyword'] === '') {
            return response()->json([
                'message' => 'Invalid keyword'
            ], 200);
        }
        return $this->dispatch(new SuggestJob($params));
    }
}
