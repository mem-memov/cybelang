<?php

namespace MemMemov\Cybe;

class Predicates
{
    private $phrases;

    public function __construct(
        Phrases $phrases
    ) {
        $this->phrases = $phrases;
    }

    public function fromText(Parser\Predicate $predicateText): Predicate
    {
        $phrase = $this->phrases->fromWords($predicateText->getWords());

        return new Predicate($phrase);
    }
}