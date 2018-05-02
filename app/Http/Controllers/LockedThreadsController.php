<?php

namespace App\Http\Controllers;

use App\Thread;
use Illuminate\Http\Request;

class LockedThreadsController extends Controller
{
    public function store(Thread $thread)
    {
        $this->update(['locked' => true]);
    }

    public function destroy(Thread $thread)
    {
        $this->update(['locked' => false]);
    }
}
