<?php

namespace MemMemov\Cybe;

class Predicate
{
    private $phrase;

    public function __construct(
        Phrase $phrase
    ) {
        $this->phrase = $phrase;
    }
}