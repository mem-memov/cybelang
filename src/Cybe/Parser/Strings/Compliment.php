<?php

namespace MemMemov\Cybe\Parser\Strings;

use MemMemov\Cybe\Parser\ICompliment;

class Compliment implements ICompliment
{
    private $string;

    public function __construct(string $string)
    {
        $this->string = $string;
    }
}