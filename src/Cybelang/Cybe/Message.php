<?php

namespace MemMemov\Cybelang\Cybe;

class Message
{
    private $clauses;

    public function __construct(
        array $clauses
    ) {
        $this->clauses = $clauses;
    }
}