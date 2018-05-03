<?php

namespace App\Http\Controllers;

use App\Rules\Recaptcha;
use App\Rules\SpamFree;
use App\Thread;
use App\Channel;
use App\Filters\ThreadFilters;
use App\Trending;
use Illuminate\Http\Request;

class ThreadsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
    }

    public function index(Channel $channel, ThreadFilters $filters, Trending $trending)
    {

        $threads = Thread::latest()->filter($filters);

        if ($channel->exists) {
            $threads->where('channel_id', $channel->id);
        }

        $threads = $threads->paginate(25);

        return view('forum.index', [
            'threads' => $threads,
            'trending' => $trending->get()
        ]);
    }

    public function show($channel, Thread $thread, Trending $trending)
    {

        if (auth()->check()) {
            auth()->user()->read($thread);
        }
//rozwiazanie dla klasy
//        $thread->visits()->record();

        $thread->increment('visits_count');

        $trending->push($thread);

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
            'title' => ['required', new SpamFree],
            'channel_id' => 'required',
            'body' => ['required', new SpamFree],
            'g-recaptcha-response' => ['required', new Recaptcha]
        ]);

        $thread = Thread::create([
            'channel_id' => request('channel_id'),
            'title' => request('title'),
            'body' => request('body'),
            'user_id' => auth()->id()
        ]);

        return redirect($thread->path())
            ->with('flash', 'Your thread has been published');
    }

    public function update($channel, Thread $thread)
    {
        $this->authorize('update', $thread);

        $data = request()->validate([
            'title' => ['required', new SpamFree],
            'body' => ['required', new SpamFree],
        ]);

        $thread->update($data);
    }

    public function destroy($channel, Thread $thread)
    {
        $this->authorize('update', $thread);

        $thread->delete();

        if (request()->wantsJson()) {
            return response([], 200);
        }

        return redirect(' / threads');

    }
}
