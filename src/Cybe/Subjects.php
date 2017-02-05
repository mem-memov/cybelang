<?php

namespace MemMemov\Cybe;

class Subjects
{
    public function fromText(Parser\ISubject $subjectText): Subject
    {
        return new Subject();
    }
}