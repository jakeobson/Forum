<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Events\ThreadHasNewReply;

class Thread extends Model
{

    use RecordsActivity;

    protected $guarded = [];

    protected $with = ['user', 'channel'];

    protected $appends = ['isSubscribedTo'];


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

        static::created(function ($thread) {
            $thread->update(['slug' => $thread->title]);
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
        return '/threads/' . $this->channel->slug . '/' . $this->slug;
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

    public function addReply($reply)
    {
        $reply = $this->replies()->create($reply);

        event(new ThreadHasNewReply($this, $reply));

        return $reply;
    }

    public function subscribe($userId = null)
    {
        if (!$this->subscriptions()->where('user_id', $userId ?: auth()->id())->exists()) {
            $this->subscriptions()->create([
                'user_id' => $userId ?: auth()->id()
            ]);
        }

        return $this;

    }

    public function unsubscribe($userId = null)
    {
        $this->subscriptions()->where(['user_id' => $userId ?: auth()->id()])->delete();
    }

    public function subscriptions()
    {
        return $this->hasMany(ThreadSubscription::class);
    }

    public function getIsSubscribedToAttribute()
    {
        return $this->subscriptions()->where('user_id', auth()->id())->exists();
    }

    public function hasUpdatesFor($user = null)
    {

        $user = $user ?: auth()->user();

        $key = $user->visitedThreadCacheKey($this);

        return $this->updated_at > cache($key);
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function setSlugAttribute($value)
    {
        $slug = str_slug($value);

        if (static::whereSlug($slug)->exists()) {
            $slug = "{$slug}-" . $this->id;
        }

        $this->attributes['slug'] = $slug;
    }

    public function markBestReply($reply)
    {
        $this->update(['best_reply_id' => $reply->id]);
    }

//    public function visits()
//    {
//        return new Visits($this);
//    }

}
