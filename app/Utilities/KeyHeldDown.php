<?php

namespace App\Utilities;

use Exception;

class KeyHeldDown
{

    public function detect($body)
    {
        if (preg_match('|(.)\\1{4,}|is', $body)) {
            throw new Exception('Error!');
        }
    }

}