<?php

namespace MemMemov\Cybelang\Cybe\Parser\PlainText;

use MemMemov\Cybelang\Cybe\Parser\Clause;
use MemMemov\Cybelang\Cybe\Parser\Predicate;
use MemMemov\Cybelang\Cybe\Parser\Subject;

class PlainTextClause implements Clause
{
    private $predicates;
    private $subjects;
    private $arguments;
    private $string;

    public function __construct(
        PlainTextPredicates $predicates,
        PlainTextSubjects $subjects,
        PlainTextArguments $arguments,
        string $string
    ) {
        $this->predicates = $predicates;
        $this->subjects = $subjects;
        $this->arguments = $arguments;
        $this->string = $string;
    }
    
    public function text(): string
    {
        return $this->string;
    }

    public function predicate(): Predicate
    {
        strtok($this->string, '.');
        $predicateString = strtok('(');

        $predicate = $this->predicates->create($predicateString);

        return $predicate;
    }

    public function subject(): Subject
    {
        $subjectString = strtok($this->string, '.');

        $subject = $this->subjects->create($subjectString);

        return $subject;
    }

    public function arguments(): array
    {
        strtok($this->string, '.');
        strtok('(');
        $argumentsString = strtok(')');
        $argumentStrings = explode(',', $argumentsString);

        $arguments = [];
        foreach ($argumentStrings as $argumentString) {
            $arguments[] = $this->arguments->create($argumentString);
        }

        return $arguments;
    }
}