<?php

namespace MemMemov\Cybe;

class Subject
{
    private $phrase;

    public function __construct(
        Phrase $phrase
    ) {
        $this->phrase = $phrase;
    }
}