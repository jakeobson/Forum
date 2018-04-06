<?php
/**
 * Created by PhpStorm.
 * User: jt
 * Date: 03.04.2018
 * Time: 07:57
 */

namespace App\Filters;

use Illuminate\Http\Request;

abstract class Filters
{

    protected $request;
    protected $builder;

    protected $filters = [];

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function apply($builder)
    {
        $this->builder = $builder;


//        collect($this->getFilters())
//            ->filter(function ($value, $filter) {
//                return method_exists($this, $filter);
//            })
//            ->each(function ($value, $filter) {
//                $this->$filter($value);
//            });

        foreach ($this->getFilters() as $filter => $value) {
            if (method_exists($this, $filter)) {
                $this->$filter($value);
            }
        }

        return $this->builder;
    }

    public function getFilters()
    {
        return $this->request->only($this->filters);
    }
}