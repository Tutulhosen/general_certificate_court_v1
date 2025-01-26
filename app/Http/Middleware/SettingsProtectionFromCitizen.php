<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SettingsProtectionFromCitizen
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $role_id=globalUserInfo()->role_id;
        if(in_array($role_id,[1,2]))
        {
            return $next($request);
        }
        return redirect('/dashboard')->with('error','দুঃখিত আপনি এই Page এ authorized না');
    }
}
