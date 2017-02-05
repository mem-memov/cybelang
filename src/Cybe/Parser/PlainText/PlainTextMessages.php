<?php

namespace MemMemov\Cybe\Parser\PlainText;

use MemMemov\Cybe\Parser\Messages;
use MemMemov\Cybe\Parser\Message;

class PlainTextMessages implements Messages
{
    private $clauses;

    public function __construct(
        PlainTextClauses $clauses
    ) {
        $this->clauses = $clauses;
    }

    public function create(string $string): Message
    {
        return new PlainTextMessage(
            $this->clauses,
            $string
        );
    }
}