<?php

namespace App\Http\Controllers;

use App\Thread;
use App\Channel;
use App\Filters\ThreadFilters;
use Illuminate\Http\Request;


class ThreadsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
    }

    public function index(Channel $channel, ThreadFilters $filters)
    {
        $threads = Thread::latest()->filter($filters);

        if ($channel->exists) {
            $threads->where('channel_id', $channel->id);
        }


        $threads = $threads->get();

        return view('forum.index', compact('threads'));
    }

    public function show($channel, Thread $thread)
    {

        return view('forum.show', [
            'thread' => $thread
        ]);
    }

    public function create()
    {
        return view('forum.create');
    }

    public function store(Request $request)
    {

        $request->validate([
            'title' => 'required',
            'channel_id' => 'required',
            'body' => 'required'
        ]);

        Thread::create([
            'channel_id' => request('channel_id'),
            'title' => request('title'),
            'body' => request('body'),
            'user_id' => auth()->id()
        ]);

        return redirect('/threads')
            ->with('flash', 'Your thread has been published');
    }

    public function destroy($channel, Thread $thread)
    {
        $this->authorize('update', $thread);

        $thread->delete();

        if (request()->wantsJson()) {
            return response([], 200);
        }

        return redirect('/threads');

    }
}
