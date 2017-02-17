<?php

namespace MemMemov\Cybe;

class Predicate
{
    private $id;
    private $phrases;
    private $arguments;

    public function __construct(
        int $id,
        Phrases $phrases,
        Arguments $arguments
    ) {
        $this->id = $id;
        $this->phrases = $phrases;
        $this->arguments = $arguments;
    }

    public function phrase(): Phrase
    {
        return $this->phrases->ofPredicate($this);
    }

    public function arguments(callable $use): void
    {
        $arguments = $this->arguments->ofPredicate($this);
    }
}