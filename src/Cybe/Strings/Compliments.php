<?php

namespace MemMemov\Cybe\Strings;

class Compliments
{
    public function create(string $string): Compliment
    {
        return new Compliment($string);
    }
}