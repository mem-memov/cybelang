<?php

namespace MemMemov\Cybelang\Cybe;

class Clause
{
    private $id;
    private $subjects;
    private $predicates;
    private $arguments;

    public function __construct(
        int $id,
        Subjects $subjects,
        Predicates $predicates,
        Arguments $arguments
    ) {
        $this->id = $id;
        $this->subjects = $subjects;
        $this->predicates = $predicates;
        $this->arguments = $arguments;
    }

    public function id(): int
    {
        return $this->id;
    }

    public function subject(): Subject
    {
        return $this->subjects->ofClause($this);
    }

    public function predicate(): Predicate
    {
        return $this->predicates->ofClause($this);
    }

    public function arguments(): array
    {
        return $this->arguments->ofClause($this);
    }
    
    public function toText(): string
    {
        $argumentTexts = [];
        foreach ($this->arguments() as $argument) {
            $argumentTexts[] = $argument->toText();
        }
        
        $text = $this->subject()->toText() . '.' . $this->predicate()->toText() . '(' . implode(',', $argumentTexts) . ')';
        
        return $text;
    }
}