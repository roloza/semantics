<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\HttpException;

/**
 * Class PingController
 * @package App\Http\Controllers
 */
class PingController extends Controller
{

    public function index()
    {
        return response()->json([
            'message' => 'PONG!',
            'data' => ''
        ], 200);

    }

    public function authenticated()
    {
        $user = Auth::user();
        return response()->json([
            'message' => 'PONG!',
            'data' => $user
        ], 200);
    }
}
