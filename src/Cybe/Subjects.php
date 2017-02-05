<?php

namespace MemMemov\Cybe;

class Subjects
{
    public function fromText(Parser\Subject $subjectText): Subject
    {
        return new Subject();
    }
}