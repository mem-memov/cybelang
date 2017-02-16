<?php

namespace MemMemov\Cybe;

class Category
{
    private $phrase;

    public function __construct(
        Phrase $phrase
    ) {
        $this->phrase = $phrase;
    }
}