<?php

namespace MemMemov\Cybe;

class Phrase
{
    private $id;
    private $words;

    public function __construct(
        int $id,
        Words $words
    ) {
        $this->id = $id;
        $this->words = $words;
    }

    public function id(): int
    {
        return $this->id;
    }

    public function words(callable $use): array
    {
        $words = $this->words->ofPhrase($this);
        return array_map($use, $words);
    }
}