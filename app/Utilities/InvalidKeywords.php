<?php

namespace App\Utilities;

use Exception;

class InvalidKeywords
{
    protected $keywords = [
        'yahoo',
        'support'
    ];

    public function detect($body)
    {

        foreach ($this->keywords as $invalidKeyword) {
            if (stripos($body, $invalidKeyword) !== false) {
                throw new Exception('Error!');
            }
        }
    }
}