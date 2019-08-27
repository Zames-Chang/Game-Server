<?php

namespace App\Http\Controllers;

use App\User;
use App\Http\Traits\ApiTrait;
use App\Http\Traits\AuthTrait;
use Illuminate\Http\Request;

class UserController extends Controller
{
    use ApiTrait;
    use AuthTrait;

    /**
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getMySession()
    {
        $user = $this->guard()->user();
        $favorite = empty($user->favorite)
            ? collect([])
            : collect($user->favorite);

        return $this->returnSuccess('Success.', $favorite);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function saveMySession(Request $request)
    {
        $this->validate($request, [
            'session_id' => 'required|integer',
            'action' => 'required|string'
        ]);

        $user = $this->guard()->user();
        $session_id = (int) $request->input('session_id');
        $favorite = empty($user->favorite)
            ? collect([])
            : collect($user->favorite);

        switch ($request->input('action')) {
            case 'add':
                $favorite->push($session_id);
                break;

            case 'remove':
                $newFavorite = $favorite->reject(function ($value) use ($session_id) {
                    return $value == $session_id;
                });

                $favorite = $newFavorite;

                break;

            default:
                return $this->return400Response();
        }

        $user->favorite = $favorite
            ->unique()
            ->sort()
            ->values()
            ->all();

        if ($user->isDirty('favorite')) {
            $user->save();
        }

        return $this->returnSuccess('Success.');
    }
}
