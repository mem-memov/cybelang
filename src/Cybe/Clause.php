<?php

namespace MemMemov\Cybe;

class Clause
{
    private $graphNode;
    private $subjects;
    private $predicates;
    private $arguments;

    public function __construct(
        GraphNode $graphNode,
        Subjects $subjects,
        Predicates $predicates,
        Arguments $arguments
    ) {
        $this->graphNode = $graphNode;
        $this->subjects = $subjects;
        $this->predicates = $predicates;
        $this->arguments = $arguments;
    }

    public function subject(): Subject
    {
        return $this->subjects->ofClause($this->graphNode);
    }

    public function predicate(): Predicate
    {
        return $this->predicates->ofClause($this->graphNode);
    }

    public function arguments(): ClauseArguments
    {
        return $this->arguments()->ofClause($this->graphNode);
    }
}