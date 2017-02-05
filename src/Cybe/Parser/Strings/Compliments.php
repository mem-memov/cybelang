<?php

namespace MemMemov\Cybe\Parser\Strings;

use MemMemov\Cybe\Parser\ICompliment;

class Compliments
{
    public function create(string $string): ICompliment
    {
        return new Compliment($string);
    }
}