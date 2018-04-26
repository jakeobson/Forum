<?php

namespace App\Http\Controllers;

use App\Thread;

class ThreadSubscriptions extends Controller
{

    public function store($channelId, Thread $thread)
    {

        $thread->subscribe();

        return response([], 200);

    }

    public function destroy($channelId, Thread $thread){
        $thread->unsubscribe();

        return response([], 200);
    }

}
