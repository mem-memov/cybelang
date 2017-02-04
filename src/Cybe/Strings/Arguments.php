<?php

namespace MemMemov\Cybe\Strings;

class Arguments
{
    public function create(string $string): Argument
    {
        return new Argument($string);
    }
}