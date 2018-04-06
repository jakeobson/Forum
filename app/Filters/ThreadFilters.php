<?php

namespace App\Filters;

use \App\User;

class ThreadFilters extends Filters
{

    protected $filters = ['by', 'popular'];

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
}