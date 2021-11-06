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

/**
 * Class PingController
 * @package App\Http\Controllers
 */
class SemanticsController extends Controller
{

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
        $isNews = $request->news ? (bool)$request->news : false;

        $type = Type::where('slug', $typeParam)->first();


        $job = Job::where('user_id', 1)->where('url', $url)->where('type_id', $type->id)->first();
        if ($job !== null) {
            $this->destroy($job->uuid);
        }

        switch($type->slug) {
            case 'site':
                $uuid = $this->launchJobSite($url, $totalCrawlLimit);
                break;
            case 'web':
                $uuid = $this->launchJobWeb($keyword, $totalCrawlLimit, $isNews);
                break;
            case 'page':
            default:
                $uuid = $this->launchJobPage($url);
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

    private function launchJobPage($url)
    {
        if (!$url = filter_var($url, FILTER_VALIDATE_URL)) {
            return response()->json([
                'message' => 'Invalid url'
            ], 200);
        }
        return $this->dispatch(new PageCrawler($url));
    }

    private function launchJobSite($url, $totalCrawlLimit = 10)
    {
        if (!$url = filter_var($url, FILTER_VALIDATE_URL)) {
            return response()->json([
                'message' => 'Invalid url'
            ], 200);
        }
        return $this->dispatch(new SiteCrawler($url, $totalCrawlLimit));
    }

    private function launchJobWeb($keyword, $totalCrawlLimit, $isNews)
    {
        if ($keyword === '') {
            return response()->json([
                'message' => 'Invalid keyword'
            ], 200);
        }
        return $this->dispatch(new WebCrawler($keyword, $totalCrawlLimit, $isNews));
    }
}
