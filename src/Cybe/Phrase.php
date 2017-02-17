<?php

namespace MemMemov\Cybe;

class Phrase
{
    private $words;

    public function __construct(
        GraphSequence $words
    ) {
        $this->words = $words;
    }


}