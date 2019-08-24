<?php

namespace App\Http\Controllers;

use App\Mission;
use App\Http\Traits\ApiTrait;
use App\Http\Traits\AdminTrait;
use Illuminate\Http\Request;

class MissionController extends Controller
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

        $mission = Mission::create($request->only([
            'name',
            'name_e',
            'description',
            'description_e',
            'image',
            'open',
        ]));

        return $this->returnSuccess('Store success.', $mission);
    }
}
