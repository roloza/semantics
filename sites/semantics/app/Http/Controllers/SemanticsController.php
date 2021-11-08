<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\Url;
use App\Models\Type;
use App\Jobs\WebCrawler;
use App\Jobs\PageCrawler;
use App\Jobs\SiteCrawler;
use Illuminate\Http\Request;
use App\Models\SyntexRtListe;
use App\Models\SyntexAuditDesc;
use App\Models\SyntexAuditIncl;
use App\Models\SyntexAuditListe;
use App\Models\SeoAuditStructure;
use App\Models\SyntexDescripteur;
use GuzzleHttp\Psr7\Uri;

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
            case 'site':
                $uuid = $this->launchJobSite($url, $totalCrawlLimit, $typeContent);
                break;
            case 'web':
                $uuid = $this->launchJobWeb($keyword, $totalCrawlLimit, $isNews, $typeContent);
                break;
            case 'page':
            default:
                $uuid = $this->launchJobPage($url, $typeContent);
                break;
        }

        return response()->json([
            'message' => 'success',
            'uuid' => $uuid,
        ], 200);
    }



    public function destroy($uuid)
    {
        $res = Job::find($uuid);
        if ($res !== null) $res->delete();

        $res = SeoAuditStructure::find($uuid);
        if ($res !== null) $res->delete();

        $res = SyntexAuditIncl::find($uuid);
        if ($res !== null) $res->delete();

        $res = SyntexAuditListe::find($uuid);
        if ($res !== null) $res->delete();

        $res = SyntexDescripteur::find($uuid);
        if ($res !== null) $res->delete();

        $res = SyntexRtListe::find($uuid);
        if ($res !== null) $res->delete();

        $res = Url::find($uuid);
        if ($res !== null) $res->delete();

        $res = SyntexAuditDesc::find($uuid);
        if ($res !== null) $res->delete();
    }

    private function launchJobPage($url, $typeContent)
    {
        $job = Job::where('user_id', 1)
            ->where('params.url', $url)
            ->where('type_id', $this->type->id)
            ->where('params.type_content',$typeContent)
            ->first();
        if ($job !== null) {
            $this->destroy($job->uuid);
        }

        if (!$url = filter_var($url, FILTER_VALIDATE_URL)) {
            return response()->json([
                'message' => 'Invalid url'
            ], 200);
        }
        return $this->dispatch(new PageCrawler($url, $typeContent));
    }

    private function launchJobSite($url, $totalCrawlLimit = 10, $typeContent)
    {
        $job = Job::where('user_id', 1)
            ->where('params.url', $url)
            ->where('params.total_crawl_limit',(string)$totalCrawlLimit)
            ->where('type_id', $this->type->id)
            ->where('params.type_content', $typeContent)
            ->first();
        if ($job !== null) {
            $this->destroy($job->uuid);
        }
        if (!$url = filter_var($url, FILTER_VALIDATE_URL)) {
            return response()->json([
                'message' => 'Invalid url'
            ], 200);
        }
        return $this->dispatch(new SiteCrawler($url, $totalCrawlLimit, $typeContent));
    }

    private function launchJobWeb($keyword, $totalCrawlLimit, $isNews, $typeContent)
    {
        $job = Job::where('user_id', 1)
            ->where('params.keyword', $keyword)
            ->where('params.total_crawl_limit', (string)$totalCrawlLimit)
            ->where('params.is_news', (int)$isNews)
            ->where('type_id', $this->type->id)
            ->where('params.type_content', $typeContent)
            ->first();
            if ($job !== null) {
                $this->destroy($job->uuid);
            }
        if ($keyword === '') {
            return response()->json([
                'message' => 'Invalid keyword'
            ], 200);
        }
        return $this->dispatch(new WebCrawler($keyword, $totalCrawlLimit, $isNews, $typeContent));
    }
}
