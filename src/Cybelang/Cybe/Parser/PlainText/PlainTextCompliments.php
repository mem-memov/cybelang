<?php

namespace MemMemov\Cybelang\Cybe\Parser\PlainText;

use MemMemov\Cybelang\Cybe\Parser\Compliment;

class PlainTextCompliments
{
    public function create(string $string): Compliment
    {
        return new PlainTextCompliment($string);
    }
}