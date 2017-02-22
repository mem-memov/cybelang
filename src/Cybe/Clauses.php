<?php

namespace MemMemov\Cybe;



class Clauses
{
    private static $graphSpace = 'clause';

    private $graph;
    private $subjects;
    private $predicates;
    private $arguments;

    public function __construct(
        Graph $graph,
        Subjects $subjects,
        Predicates $predicates,
        Arguments $arguments
    ) {
        $this->graph = $graph;
        $this->subjects = $subjects;
        $this->predicates = $predicates;
        $this->arguments = $arguments;
    }

    public function fromText(Parser\Clause $clauseText): Clause
    {
        $subject = $this->subjects->fromText($clauseText->subject());
        $predicate = $this->predicates->fromText($clauseText->predicate());

        $argumentIds = array_map(function(Parser\Argument $argumentText) {
            return $this->arguments->fromText($argumentText)->id();
        }, $clauseText->arguments());

        $memberIds = array_merge([$subject->id(), $predicate->id()], $argumentIds);

        $clauseNode = $this->graph->provideCommonNode(self::$graphSpace, $memberIds);

        return new Clause(
            $clauseNode->id(),
            $this->subjects,
            $this->predicates,
            $this->arguments
        );
    }
}