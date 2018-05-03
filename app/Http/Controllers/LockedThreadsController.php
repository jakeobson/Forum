<?php

namespace App\Http\Controllers;

use App\Thread;
use Illuminate\Http\Request;

class LockedThreadsController extends Controller
{
    public function store(Thread $thread)
    {
        $thread->update(['locked' => true]);

        return response([], 200);
    }

    public function destroy(Thread $thread)
    {
        $thread->update(['locked' => false]);
        return response([], 200);
    }
}
