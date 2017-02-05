<?php

namespace MemMemov\Cybe;

class Message
{
    private $clauses;

    public function __construct(
        array $clauses
    ) {
        $this->clauses = $clauses;
    }
}