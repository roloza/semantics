<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class UserJob
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $job = Job::where('uuid', $request->uuid)->first();
        if ($job === null) {
            abort(404, 'Désolé, cette analyse n\'existe pas');
        }
        if ($job->user_id !== (int)env('DEMO_USER_ID', 0) && !Gate::allows('user-job', $job)) {
            abort(403, 'Désolé, vous n\'êtes pas autorisé à accéder à ce contenu.');
        }
        return $next($request);
    }
}
