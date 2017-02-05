<?php

namespace MemMemov\Cybe\Parser\PlainText;

use MemMemov\Cybe\Parser\Compliment;

class PlainTextCompliments
{
    public function create(string $string): Compliment
    {
        return new PlainTextCompliment($string);
    }
}