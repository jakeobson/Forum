<?php

namespace App\Http\Controllers;

use App\Reply;
use App\Thread;
use Illuminate\Http\Request;

class RepliesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index']);
    }

    public function index($channelId, Thread $thread)
    {
        return $thread->replies()->paginate(10);
    }

    public function store($channelId, Thread $thread)
    {
        $reply = $thread->replies()->create([
            'body' => request('body'),
            'user_id' => auth()->id()
        ]);

        if (request()->expectsJson()) {
            return $reply->load('user');
        }

        return back()->with('flash', 'Your reply has been posted');
    }

    public function destroy(Reply $reply)
    {
        $this->authorize('update', $reply);

//        if($reply->user_id != auth()->id){
//            return response([], 403);
//        }

        $reply->delete();

        if (request()->expectsJson()) {
            return response(['status' => 'Reply deleted']);
        }


        return back()->with('flash', 'Reply has been deleted');
    }

    public function update(Reply $reply)
    {
        $this->authorize('update', $reply);

        $reply->update(['body' => request('body')]);
    }
}
