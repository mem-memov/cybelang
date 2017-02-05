<?php

namespace MemMemov\Cybe\Parser\PlainText;

use MemMemov\Cybe\Parser\Compliment;

class PlainTextCompliment implements Compliment
{
    private $string;

    public function __construct(string $string)
    {
        $this->string = $string;
    }
}