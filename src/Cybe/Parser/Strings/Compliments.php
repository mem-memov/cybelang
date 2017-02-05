<?php

namespace MemMemov\Cybe\Parser\Strings;

class Compliments
{
    public function create(string $string): Compliment
    {
        return new Compliment($string);
    }
}