<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Custom\Tools\KeywordsGraph;

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

}
