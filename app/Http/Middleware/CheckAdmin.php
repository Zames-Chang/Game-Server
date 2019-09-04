<?php

namespace App\Http\Middleware;

use Closure;

use App\Http\Traits\ApiTrait;
use \Illuminate\Http\Request;

class CheckAdmin
{
    use ApiTrait;

    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $local_key = env('ADMIN_KEY', null);
        $remote_key = $request->input('admin_key', null);

        if ($local_key
            && $remote_key
            && $local_key == $remote_key) {
            return $next($request);
        } else {
            return $this->return401Response();
        }
    }
}
