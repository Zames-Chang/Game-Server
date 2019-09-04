<?php

namespace App\Http\Traits;

use Illuminate\Support\Facades\Auth;

trait AuthTrait
{
    /**
     * set guard to replace auth()
     */
    public function guard()
    {
        return Auth::guard('api');
    }
}
