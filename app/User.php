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
        $completed_task = collect($this->achievement[self::COMPLETED_TASK]);

        $tasks = Task::findOrFail($completed_task->pluck('task_id'));
        $missions = Mission::findOrFail($completed_task->pluck('mission_id'));

        return $completed_task
            ->map(function ($item) use ($tasks, $missions) {
                $task = $tasks->where('id', $item['task_id'])->first();
                $task->mission_uid = $missions->where('id', $item['mission_id'])->first()->uid;

                return $task;
            });
    }

    public function getWonRewardAttribute()
    {
        $won_reward = collect($this->achievement[self::WON_REWARD]);
        $rewards = Reward::findOrFail($won_reward->pluck('reward_id'));

        return $won_reward
            ->map(function ($item) use ($rewards) {
                $reward = $rewards->where('id', $item['reward_id'])->first();
                $reward->redeemed = $item['redeemed'];

                return $reward;
            });
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
