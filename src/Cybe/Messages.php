<?php

namespace MemMemov\Cybe;

class Messages
{
    private $clauses;

    public function __construct(
        Clauses $clauses
    ) {
        $this->clauses = $clauses;
    }

    public function fromText(Parser\IMessage $messageText): Message
    {
        $clauses = [];
        foreach ($messageText->clauses() as $clauseText) {
            $clauses[] = $this->clauses->fromText($clauseText);
        }

        return new Message($clauses);
    }
}