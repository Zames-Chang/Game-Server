<?php

namespace App\Http\Middleware;

use Closure;

class BasicAuthMiddleware
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
        if ($request->getUser() != env('QRCODE_USER', 'qrcode_user') || $request->getPassword() != env('QRCODE_PASS', 'qrcode_pass')) {
            $headers = array('WWW-Authenticate' => 'Basic');
            return response('Invalid Access.', 401, $headers);
        }
        return $next($request);
    }
}
