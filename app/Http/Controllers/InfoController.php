<?php

namespace App\Http\Controllers;

use App\Mission;
use App\Reward;
use App\Http\Traits\ApiTrait;

class InfoController extends Controller
{
    use ApiTrait;

    const GAME_INFO = [
        'landing_page_title' => '歡迎加入',
        'landing_page_title_en' => 'Welcome',
        'landing_page_text' => '歡迎來到Mopcon闖關大進擊，透過達成各關卡任務，將有神秘大獎等著你!',
        'landing_page_text_en' => 'Welcome to MOPCON Game Field.',
        'welcome_img' => 'https://lorempixel.com/640/480/technics/Faker/?66666',
    ];

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function showGameInfo()
    {
        $data = SELF::GAME_INFO;

        $mission_list = Mission::all();
        $data['mission_list'] = $mission_list;

        $reward_list = Reward::all();
        $data['reward_list'] = $reward_list;

        return $this->returnSuccess('Success.', $data);
    }
}
