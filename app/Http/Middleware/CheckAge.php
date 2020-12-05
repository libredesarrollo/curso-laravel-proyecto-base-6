<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckAge
{
    
    public function handle(Request $request, Closure $next, $age = 17,$name)
    {

        //$age = 19;

        if ($age < 18) {
            return redirect()->route('contact');
        }

        return $next($request);
    }
}
