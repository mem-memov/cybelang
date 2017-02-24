<?php

namespace MemMemov\Cybe\Parser\PlainText;

use MemMemov\Cybe\Parser\Subject;

class PlainTextSubject implements Subject
{
    private $string;

    public function __construct(
        string $string
    ) {
        $this->string = $string;
    }

    /**
     * @return string[]
     */
    public function words(): array
    {
        return explode(' ', $this->string);
    }
}