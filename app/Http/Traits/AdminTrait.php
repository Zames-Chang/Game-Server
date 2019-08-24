<?php

namespace App\Http\Traits;

use Illuminate\Http\Request;

trait AdminTrait
{
    public function checkAdmin(Request $request)
    {
        $local_key = env('ADMIN_KEY', null);
        $remote_key = $request->input('admin_key', null);

        return ($local_key
            && $remote_key
            && $local_key == $remote_key);
    }
}
