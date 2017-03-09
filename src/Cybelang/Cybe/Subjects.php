<?php

namespace MemMemov\Cybelang\Cybe;

class Subjects implements Destructable
{
    private static $graphSpace = 'subject';

    /** @var Graph */
    private $graph;
    /** @var Phrases */
    private $phrases;
    /** @var Clauses */
    private $clauses;

    public function __construct(
        Graph $graph,
        Phrases $phrases
    ) {
        $this->graph = $graph;
        $this->phrases = $phrases;
    }
    
    public function destruct()
    {
        $this->graph = null;
        
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

    public function fromText(Parser\Subject $subjectText): Subject
    {
        $phrase = $this->phrases->fromWords($subjectText->getWords());
        $subjectNode = $this->graph->сreateNode(self::$graphSpace, [$phrase->id()]);

        return new Subject(
            $subjectNode->id(),
            $this->phrases
        );
    }

    public function ofClause(Clause $clause): Subject
    {
        $clauseNode = $this->graph->readNode($clause->id());
        $subjectNode = $clauseNode->one(self::$graphSpace);

        return new Subject(
            $subjectNode->id(),
            $this->phrases
        );
    }
}