<?php

namespace MemMemov\Cybe\Parser\PlainText;

use MemMemov\Cybe\Parser\Clause;

class PlainTextClauses
{
    private $predicates;
    private $subjects;
    private $arguments;

    public function __construct(
        PlainTextPredicates $predicates,
        PlainTextSubjects $subjects,
        PlainTextArguments $arguments
    ) {
        $this->predicates = $predicates;
        $this->subjects = $subjects;
        $this->arguments = $arguments;
    }

    public function create(string $string): Clause
    {
        return new PlainTextClause(
            $this->predicates,
            $this->subjects,
            $this->arguments,
            $string
        );
    }
}