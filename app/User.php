<?php

namespace App;

use App\Task;
use App\Mission;
use App\Reward;
use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Model implements AuthenticatableContract, AuthorizableContract, JWTSubject
{
    use Authenticatable, Authorizable;

    const COMPLETED_TASK = 'completed_task';
    const WON_REWARD = 'won_reward';
    const WON_POINT = 'won_point';

    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'uid', 'email',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'id',
        'password',
        'achievement',
        'created_at',
        'updated_at',
    ];

    protected $appends = [
        self::COMPLETED_TASK,
        self::WON_REWARD,
        self::WON_POINT,
    ];

    protected $casts = ['achievement' => 'array'];

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->achievement = [
                self::COMPLETED_TASK => [],
                self::WON_REWARD => [],
                self::WON_POINT => 0,
            ];
        });
    }

    /**
     * JWT
     *
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * JWT
     *
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function getCompletedTaskAttribute()
    {
        return collect($this->achievement[self::COMPLETED_TASK])
            ->map(function ($item) {
                $task = Task::findOrfail($item['task_id']);
                $mission = Mission::findOrFail($item['mission_id']);
                $task->mission_uid = $mission->uid;

                return $task;
            })->all();
    }

    public function getWonRewardAttribute()
    {
        return collect($this->achievement[self::WON_REWARD])
            ->map(function ($item) {
                $reward = Reward::findOrfail($item['reward_id']);
                $reward->redeemed = $item['redeemed'];

                return $reward;
            })->all();
    }

    public function getWonPointAttribute()
    {
        return $this->achievement[self::WON_POINT];
    }
    /**
     * get scores for user
     */
    public function scores()
    {
        return $this->hasMany('App\Scoreboard');
    }
}
