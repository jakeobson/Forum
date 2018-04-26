<?php

namespace App\Filters;

use \App\User;

class ThreadFilters extends Filters
{

    protected $filters = ['by', 'popular', 'unanswered'];

    public function by($username)
    {
        $user = User::where('name', $username)->firstOrFail();

        return $this->builder->where('user_id', $user->id);
    }

    protected function popular()
    {
        //we have to override order by created_at with new order by
        $this->builder->getQuery()->orders = [];

        return $this->builder->orderBy('replies_count', 'desc');
    }

    protected function unanswered()
    {

        return $this->builder->where('replies_count', 0);
//        return $this->builder->has('replies', '=' , 0);

    }
}