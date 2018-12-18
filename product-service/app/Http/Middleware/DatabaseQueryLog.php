<?php

namespace App\Http\Middleware;

use Closure;

class DatabaseQueryLog
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
        if (!app()->isLocal()) {
            return $next($request);
        }

        \DB::enableQueryLog();

        $response = $next($request);

        foreach (\DB::getQueryLog() as $log) {
            logger($log[ 'query' ], [ 'bindings' => $log[ 'bindings' ], 'time' => $log[ 'time' ] ]);
        }

        return $response;
    }
}
