<?php

namespace MemMemov\Cybe\Parser\Strings;

use MemMemov\Cybe\Parser\ISubject;

class Subjects
{
    public function create(string $string): ISubject
    {
        return new Subject($string);
    }
}