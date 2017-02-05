<?php

namespace MemMemov\Cybe\Parser\Strings;

class Clauses
{
    private $predicates;
    private $subjects;
    private $arguments;

    public function __construct(
        Predicates $predicates,
        Subjects $subjects,
        Arguments $arguments
    ) {
        $this->predicates = $predicates;
        $this->subjects = $subjects;
        $this->arguments = $arguments;
    }

    public function create(string $string): Clause
    {
        return new Clause(
            $this->predicates,
            $this->subjects,
            $this->arguments,
            $string
        );
    }
}