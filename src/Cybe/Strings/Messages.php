<?php

namespace MemMemov\Cybe\Strings;

class Messages
{
    private $clauses;

    public function __construct(Clauses $clauses)
    {
        $this->clauses = $clauses;
    }

    public function create(string $string): Message
    {
        return new Message(
            $this->clauses,
            $string
        );
    }
}