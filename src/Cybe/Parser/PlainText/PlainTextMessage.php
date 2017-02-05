<?php

namespace MemMemov\Cybe\Parser\PlainText;

use MemMemov\Cybe\Parser\Message;

class PlainTextMessage implements Message
{
    private $clauses;
    private $string;

    public function __construct(
        PlainTextClauses $clauses,
        string $string
    ) {
        $this->clauses = $clauses;
        $this->string = $string;
    }

    public function clauses(): array
    {
        $separator = ')';
        $strings = explode($separator, $this->string);
        array_pop($strings);
        $clauseStrings = array_map(
            function (string $string) use ($separator) {
                return $string . $separator;
            },
            $strings
        );

        $clauses = [];

        foreach ($clauseStrings as $clauseString) {
            $clauses[] = $this->clauses->create($clauseString);
        }

        return $clauses;
    }
}