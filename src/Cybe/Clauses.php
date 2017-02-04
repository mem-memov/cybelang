<?php

namespace MemMemov\Cybe;

class Clauses
{
    public function fromText(MessageText $messageText): array
    {
        $separator = ')';
        $strings = explode($separator, $text);
        array_pop($strings);
        $clauseStrings = array_map(
            function (string $string) use ($separator) {
                return $string . $separator;
            },
            $strings
        );

        $clauses = [];
        foreach ($clauseStrings as $clauseString) {
            $clauses[] = new Clause();
        }

        return $clauses;
    }
}