<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{

    use Favoritable, RecordsActivity;

    protected $guarded = [];


    protected $with = ['user', 'favorites'];

    protected $appends = ['favoritesCount', 'isFavorited'];

    public function favorites()
    {
        return $this->morphMany(Favourites::class, 'favorited');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function thread()
    {
        return $this->belongsTo(Thread::class);
    }

    public function path()
    {
        return $this->thread->path() . '#reply-' . $this->id;
    }
}
