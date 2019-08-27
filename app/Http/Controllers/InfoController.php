<?php

namespace App\Http\Controllers;

use App\Mission;
use App\Reward;
use App\Http\Traits\ApiTrait;

class InfoController extends Controller
{
    use ApiTrait;

    const GAME_INFO = [
        'image' => 'https://lorempixel.com/640/480/technics/Faker/?66666',
        'title' => '歡迎加入',
        'title_e' => 'Welcome',
        'description' => '歡迎來到Mopcon闖關大進擊，透過達成各關卡任務，將有神秘大獎等著你!',
        'description_e' => 'Welcome to MOPCON Game Field.',
    ];

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function showGameInfo()
    {
        return $this->returnSuccess('Success.', self::GAME_INFO);
    }
}
