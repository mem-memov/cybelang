<?php

namespace MemMemov\Cybelang\Cybe;

class Clauses implements Destructable
{
    private static $graphSpace = 'clause';

    /** @var Graph */
    private $graph;
    /** @var Subjects */
    private $subjects;
    /** @var Predicates */
    private $predicates;
    /** @var Arguments */
    private $arguments;
    /** @var Messages */
    private $messages;

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
    
    public function destruct()
    {
        $this->graph = null;
        
        if (!is_null($this->subjects)) {
            $subjects = $this->subjects;
            $this->subjects = null;
            $subjects->destruct();
        }
        
        if (!is_null($this->predicates)) {
            $predicates = $this->predicates;
            $this->predicates = null;
            $predicates->destruct();
        }
        
        if (!is_null($this->arguments)) {
            $arguments = $this->arguments;
            $this->arguments = null;
            $arguments->destruct();
        }
    }
    
    public function setMessages(Messages $messages)
    {
        if (!is_null($this->messages)) {
            throw new ForbidCollectionRedefinition();
        }
        
        $this->messages = $messages;
    }

    public function fromText(Parser\Clause $clauseText): Clause
    {
        $subject = $this->subjects->fromText($clauseText->subject());
        $predicate = $this->predicates->fromText($clauseText->predicate());

        $argumentIds = array_map(function(Parser\Argument $argumentText) {
            $argument = $this->arguments->fromText($argumentText);
            return $argument->id();
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
    
    public function ofMessage(Message $message): array
    {
        $closeNodes = $this->graph->filterNode(self::$graphSpace, $message->id());
        
        $clauses = [];
        foreach ($closeNodes as $clauseNode) {
            $clauses[] = new Clause(
                $clauseNode->id(),
                $this->subjects,
                $this->predicates,
                $this->arguments
            );
        }
        
        return $clauses;
    }
}