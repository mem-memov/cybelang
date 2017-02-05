<?php

namespace MemMemov\Cybe\Parser;

class Compliments
{
    public function create(string $string): Compliment
    {
        return new Compliment($string);
    }
}