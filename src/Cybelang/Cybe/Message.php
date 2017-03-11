<?php

namespace MemMemov\Cybelang\Cybe;

class Message
{
    private $id;
    private $utterances;
    private $clauses;
    private $contexts;
    private $statements;

    public function __construct(
        int $id,
        Utterances $utterances,
        Clauses $clauses,
        Contexts $contexts,
        Statements $statements
    ) {
        $this->id = $id;
        $this->utterances = $utterances;
        $this->clauses = $clauses;
        $this->contexts = $contexts;
        $this->statements = $statements;
    }

    public function id(): int
    {
        return $this->id;
    }
}