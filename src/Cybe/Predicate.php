<?php

namespace MemMemov\Cybe;

class Predicate
{
    private $graphNode;
    private $phrases;

    public function __construct(
        GraphNode $graphNode,
        Phrases $phrases
    ) {
        $this->graphNode = $graphNode;
        $this->phrases = $phrases;
    }
}