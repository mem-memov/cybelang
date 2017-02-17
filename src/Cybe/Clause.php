<?php

namespace MemMemov\Cybe;

class Clause
{
    private $id;
    private $subjects;
    private $predicates;

    public function __construct(
        int $id,
        Subjects $subjects,
        Predicates $predicates
    ) {
        $this->id = $id;
        $this->subjects = $subjects;
        $this->predicates = $predicates;
    }

    public function subject(): Subject
    {
        return $this->subjects->ofClause($this);
    }

    public function predicate(): Predicate
    {
        return $this->predicates->ofClause($this);
    }
}