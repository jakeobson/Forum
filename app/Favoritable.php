<?php

namespace App;


trait Favoritable
{

    protected static function bootFavoritable()
    {
        static::deleting(function ($model) {
            $model->favorites->each->delete();
        });
    }

    public function favorites()
    {


        return $this->morphMany(Favourites::class, 'favorited');
    }

    public function favorite()
    {

        if (!$this->favorites()->where(['user_id' => auth()->id()])->exists())
            $this->favorites()->create(['user_id' => auth()->id()]);
    }

    public function unfavorite()
    {
        $this->favorites()->where(['user_id' => auth()->id()])->get()->each->delete();

    }

    public function getFavoritesCountAttribute()
    {
        return $this->favorites->count();
    }

    public function isFavorited()
    {
        return !!$this->favorites->where('user_id', auth()->id())->count();
    }

    public function getIsFavoritedAttribute()
    {
        return $this->isFavorited();
    }

}