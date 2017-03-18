<?php

namespace MemMemov\Cybelang\Cybe\Parser\PlainText;

use MemMemov\Cybelang\Cybe\Parser\Message;

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
    
    public function text(): string
    {
        return $this->string;
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