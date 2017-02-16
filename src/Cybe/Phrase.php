<?php

namespace MemMemov\Cybe;

class Phrase
{
    /** @var Word[] */
    private $words;

    public function __construct(
        array $words
    ) {
        $this->words = array_map(function(Word $word) {
            return $word;
        }, $words);
    }
}