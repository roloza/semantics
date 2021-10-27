<?php

namespace App\Http\Controllers;

use GuzzleHttp\Psr7\Uri;
use App\Jobs\PageCrawler;
use Exception;
use Illuminate\Http\Request;
use Psr\Http\Message\UriInterface;

/**
 * Class PingController
 * @package App\Http\Controllers
 */
class SemanticsController extends Controller
{

    public function index()
    {
        return response()->json([
            'message' => 'semantics!',
            'data' => ''
        ], 200);
    }

    public function store(Request $request)
    {

        if (!$url = filter_var($request->url, FILTER_VALIDATE_URL)) {
            return response()->json([
                'message' => 'Invalid url'
            ], 200);
        }
        $uuid = $this->dispatch(new PageCrawler($url));
        return response()->json([
            'message' => 'success',
            'uuid' => $uuid,
        ], 200);
    }
}
