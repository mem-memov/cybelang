<?php

namespace MemMemov\Cybe\Parser;

class Subjects
{
    public function create(string $string): Subject
    {
        return new Subject($string);
    }
}