<?php

namespace MemMemov\Cybe;

class Predicates
{
    public function fromText(Parser\IPredicate $predicateText): Predicate
    {
        return new Predicate();
    }
}