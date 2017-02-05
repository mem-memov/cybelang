<?php

namespace MemMemov\Cybe\Parser\Strings;

use MemMemov\Cybe\Parser\IMessages;
use MemMemov\Cybe\Parser\IMessage;

class Messages implements IMessages
{
    private $clauses;

    public function __construct(Clauses $clauses)
    {
        $this->clauses = $clauses;
    }

    public function create(string $string): IMessage
    {
        return new Message(
            $this->clauses,
            $string
        );
    }
}