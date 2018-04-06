<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{

    use RecordsActivity;

    protected $guarded = [];

    protected $with = ['user', 'channel'];

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope('replyCount', function ($builder) {
            $builder->withCount('replies');
        });

        static::deleting(function ($thread) {
            $thread->replies->each->delete();
            //same thing
//            $thread->replies->each(function ($reply) {
//                $reply->delete();
//            });
        });
    }


    public function replies()
    {
        return $this->hasMany(Reply::class)
//            ->withCount('favorites')
//            ->with('user')
            ->orderBy('created_at', 'DESC');
    }

    public function path()
    {
        return '/threads/' . $this->channel->slug . '/' . $this->id;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function channel()
    {
        return $this->belongsTo(Channel::class);
    }

    public function scopeFilter($query, $filters)
    {
        return $filters->apply($query);
    }
}
