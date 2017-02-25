<?php

namespace MemMemov\Cybelang\Cybe\Parser\PlainText;

use MemMemov\Cybelang\Cybe\Parser\Messages;
use MemMemov\Cybelang\Cybe\Parser\Message;

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