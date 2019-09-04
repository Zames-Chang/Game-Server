<?php

namespace App\Http\Controllers;

use App\User;
use App\Reward;
use App\Http\Traits\ApiTrait;
use App\Http\Traits\AuthTrait;
use Illuminate\Http\Request;

class RewardController extends Controller
{
    use ApiTrait;
    use AuthTrait;

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function getReward()
    {
        $user = $this->guard()->user();
        $achievement = $user->achievement;
        $wonReward = collect($achievement[User::WON_REWARD]);

        $reward = Reward::whereNotIn('id', [2000])
            ->inRandomOrder()
            ->first();

        if ($reward) {
            $newReward = $wonReward->push([
                'reward_id' => $reward->id,
                'redeemed' => false,
            ]);
            $achievement[User::WON_REWARD] = $newReward;
            $user->achievement = $achievement;
            $user->save();

            return $this->returnSuccess('Success.', $reward);
        } else {
            return $this->returnSuccess('No More Reward.');
        }
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $reward = Reward::create($request->only([
            'name',
            'name_e',
            'description',
            'description_e',
            'image',
            'redeemable',
        ]));

        return $this->returnSuccess('Store success.', $reward);
    }
}
