<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Custom\Tools\KeywordsGraph;
use App\Custom\Tools\SuggestGraph;

/**
 * Class PingController
 * @package App\Http\Controllers
 */
class AjaxController extends Controller
{

    public function getNetworkgraph($uuid, Request $request)
    {
        if (!isset($request->keyword)) {
            return false;
        }

        $keywordsGraph = new KeywordsGraph($uuid, $request->keyword);
        $keywordsGraph->run();
        return response()
            ->json([
                'nodes' => $keywordsGraph->getNodes(), // nodes: [{ "id": "Lannister" }]
                'edges' => $keywordsGraph->getEdges() // edges: [{ "from": "Lannister", "to": "Tully" }]

            ]);

    }

    public function getSuggest($uuid, Request $request)
    {
        if (!isset($request->keyword)) {
            return false;
        }

        $suggestGraph = new SuggestGraph($uuid, $request->keyword);
        $suggestGraph->run();
        return response()
            ->json([
                'nodes' => $suggestGraph->getNodes(), // nodes: [{ "id": "Lannister" }]
                'edges' => $suggestGraph->getEdges() // edges: [{ "from": "Lannister", "to": "Tully" }]

            ]);
    }
}
