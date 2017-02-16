<?php

namespace MemMemov\Cybe;

class Compliment
{
    private $phrase;

    public function __construct(
        Phrase $phrase
    ) {
        $this->phrase = $phrase;
    }
}