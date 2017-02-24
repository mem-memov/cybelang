<?php

namespace MemMemov\Cybe;

class Predicate
{
    private $id;
    private $phrases;

    public function __construct(
        int $id,
        Phrases $phrases
    ) {
        $this->id = $id;
        $this->phrases = $phrases;
    }

    public function id(): int
    {
        return $this->id;
    }

    public function phrase(): Phrase
    {
        return $this->phrases->ofPredicate($this);
    }
}