<?php

namespace MemMemov\Cybelang\Cybe\Parser\PlainText;

use MemMemov\Cybelang\Cybe\Parser\Subject;

class PlainTextSubjects
{
    public function create(string $string): Subject
    {
        return new PlainTextSubject($string);
    }
}