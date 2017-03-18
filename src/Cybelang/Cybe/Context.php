<?php

namespace MemMemov\Cybelang\Cybe;

class Context
{
    private $id;
    private $statements;
    private $messages;

    public function __construct(
        int $id,
        Statements $statements,
        Messages $messages
    ) {
        $this->id = $id;
        $this->statements = $statements;
        $this->messages = $messages;
    }

    public function id(): int
    {
        return $this->id;
    }
}
