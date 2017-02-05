<?php

namespace MemMemov\Cybe\Parser;

class Clause
{
    private $predicates;
    private $subjects;
    private $arguments;
    private $string;

    public function __construct(
        Predicates $predicates,
        Subjects $subjects,
        Arguments $arguments,
        string $string
    ) {
        $this->predicates = $predicates;
        $this->subjects = $subjects;
        $this->arguments = $arguments;
        $this->string = $string;
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