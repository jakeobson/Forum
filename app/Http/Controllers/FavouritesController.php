<?php

namespace App\Http\Controllers;

use App\Reply;
use App\Favourites;
use Illuminate\Http\Request;

class FavouritesController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Reply $reply)
    {
        $reply->favorite();

        return back()->with('flash', 'You favorited a reply');
    }

    public function destroy(Reply $reply)
    {
        $reply->unfavorite();
    }
}
