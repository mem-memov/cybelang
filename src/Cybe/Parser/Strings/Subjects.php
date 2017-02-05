<?php

namespace MemMemov\Cybe\Parser\Strings;

class Subjects
{
    public function create(string $string): Subject
    {
        return new Subject($string);
    }
}