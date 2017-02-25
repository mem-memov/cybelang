<?php

namespace MemMemov\Cybelang\Cybe\Parser\PlainText;

use MemMemov\Cybelang\Cybe\Parser\Subject;

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