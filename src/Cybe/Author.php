<?php

namespace MemMemov\Cybe;

class Author
{
    private $clauses;

    public function __construct(
        Clauses $clauses
    ) {
        $this->clauses = $clauses;
    }

    public function write(string $text)
    {
        $clauses = $this->clauses->fromText($text);
    }
}
