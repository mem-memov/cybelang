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

    public function words(callable $use): void
    {
        $words = $this->words->ofPhrase($this);
        foreach ($words as $word) {
            $use($word);
        }
    }
}