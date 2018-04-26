<?php
/**
 * Created by PhpStorm.
 * User: jt
 * Date: 23.04.2018
 * Time: 07:31
 */

namespace App;


use Illuminate\Support\Facades\Redis;

class Visits
{
    protected $thread;

    public function __construct($thread)
    {
        $this->thread = $thread;
    }

    public function reset()
    {
        Redis::del($this->cacheKey());

        return $this;
    }

    public function count()
    {
        return Redis::get($this->cacheKey()) ?: 0;
    }

    public function record()
    {
        Redis::incr($this->cacheKey());

        return $this;
    }

    protected function cacheKey()
    {
        return "thread.{$this->thread->id}.visitis";
    }

}