<?php

namespace App\Utilities;

class Spam
{
    protected $inspections = [
        InvalidKeywords::class,
        KeyHeldDown::class
    ];

    public function detect($body)
    {

        foreach ($this->inspections as $inspection) {
            app($inspection)->detect($body);
        }

        return false;

    }

}