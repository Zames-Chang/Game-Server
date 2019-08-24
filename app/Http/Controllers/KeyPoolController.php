<?php

namespace App\Http\Controllers;

use App\KeyPool;
use App\Http\Traits\ApiTrait;
use App\Http\Traits\AdminTrait;
use Illuminate\Http\Request;

class KeyPoolController extends Controller
{
    use ApiTrait;
    use AdminTrait;

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        if (!$this->checkAdmin($request)) {
            return $this->return401Response();
        }

        $key = KeyPool::create($request->only([
            'key',
            'type',
            'note',
        ]));

        return $this->returnSuccess('Store success.', $key);
    }
}
