<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\Application\Model\Group;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(!Auth::check()){
            return redirect('/login');
        }
        
        // get user group
        $group = Group::find(Auth::user()->group_id);
        
        if($group->auth !== 1)
        {
            return redirect('/');
        }
        return $next($request);
    }
}
