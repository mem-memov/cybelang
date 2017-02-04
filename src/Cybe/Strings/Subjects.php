<?php

namespace MemMemov\Cybe\Strings;

class Subjects
{
    public function create(string $string): Subject
    {
        return new Subject($string);
    }
}