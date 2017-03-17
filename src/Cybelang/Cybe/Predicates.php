<?php

namespace MemMemov\Cybelang\Cybe;

class Predicates implements Destructable
{
    private static $graphSpace = 'predicate';

    /** @var Graph */
    private $graph;
    /** @var Arguments */
    private $arguments;
    /** @var Phrases */
    private $phrases;
    /** @var Clauses */
    private $clauses;

    public function __construct(
        Graph $graph,
        Arguments $arguments,
        Phrases $phrases
    ) {
        $this->graph = $graph;
        $this->arguments = $arguments;
        $this->phrases = $phrases;
    }
    
    public function destruct()
    {
        $this->graph = null;
        
        if (!is_null($this->arguments)) {
            $arguments = $this->arguments;
            $this->arguments = null;
            $arguments->destruct();
        }
        
        if (!is_null($this->phrases)) {
            $phrases = $this->phrases;
            $this->phrases = null;
            $phrases->destruct();
        }
        
        if (!is_null($this->clauses)) {
            $clauses = $this->clauses;
            $this->clauses = null;
            $clauses->destruct();
        }
    }
    
    public function setClauses(Clauses $clauses)
    {
        if (!is_null($this->clauses)) {
            throw new ForbidCollectionRedefinition();
        }
        
        $this->clauses = $clauses;
    }

    public function fromText(Parser\Predicate $predicateText): Predicate
    {
        $phrase = $this->phrases->fromWords($predicateText->words());
        $predicateNode = $this->graph->provideCommonNode(self::$graphSpace, [$phrase->id()]);

        return new Predicate(
            $predicateNode->id(),
            $this->phrases
        );
    }

    public function ofClause(Clause $clause): Predicate
    {
        $clauseNode = $this->graph->readNode($clause->id());
        $predicateNode = $clauseNode->one(self::$graphSpace);

        return new Predicate(
            $predicateNode->id(),
            $this->phrases
        );
    }
}