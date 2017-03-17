<?php

namespace MemMemov\Cybelang\Cybe;

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

    public function words(): array
    {
        return $this->words->ofPhrase($this);
    }

    public function toText(): string
    {
        $wordTexts = [];
        foreach ($this->words() as $word) {
            $wordTexts[] = $word->content();
        }
        
        return implode(' ', $wordTexts);
    }
}