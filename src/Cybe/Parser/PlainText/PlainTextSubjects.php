<?php

namespace MemMemov\Cybe\Parser\PlainText;

use MemMemov\Cybe\Parser\Subject;

class PlainTextSubjects
{
    public function create(string $string): Subject
    {
        return new PlainTextSubject($string);
    }
}