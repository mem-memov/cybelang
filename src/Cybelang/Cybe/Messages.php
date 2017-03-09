<?php

namespace MemMemov\Cybelang\Cybe;

class Messages implements Destructable
{
    /** @var Graph */
    private $graph;
    /** @var Clauses */
    private $clauses;
    /** @var Contexts */
    private $contexts;
    /** @var Statements */
    private $statements;
    /** @var Utterances */
    private $utterances;

    public function __construct(
        Graph $graph,
        Clauses $clauses
    ) {
        $this->graph = $graph;
        $this->clauses = $clauses;
    }
    
    public function destruct()
    {
        $this->graph = null;
        
        if (!is_null($this->clauses)) {
            $clauses = $this->clauses;
            $this->clauses = null;
            $clauses->destruct();
        }
        
        if (!is_null($this->contexts)) {
            $contexts = $this->contexts;
            $this->contexts = null;
            $contexts->destruct();
        }
        
        if (!is_null($this->statements)) {
            $statements = $this->statements;
            $this->statements = null;
            $statements->destruct();
        }
        
        if (!is_null($this->utterances)) {
            $utterances = $this->utterances;
            $this->utterances = null;
            $utterances->destruct();
        }
    }
    
    public function setContexts(Contexts $contexts)
    {
        if (!is_null($this->contexts)) {
            throw new ForbidCollectionRedefinition();
        }
        
        $this->contexts = $contexts;
    }
    
    public function setStatements(Statements $statements)
    {
        if (!is_null($this->statements)) {
            throw new ForbidCollectionRedefinition();
        }
        
        $this->statements = $statements;
    }
    
    public function setUtterances(Utterances $utterances)
    {
        if (!is_null($this->utterances)) {
            throw new ForbidCollectionRedefinition();
        }
        
        $this->utterances = $utterances;
    }

    public function fromText(Parser\Message $messageText): Message
    {
        $clauses = [];
        foreach ($messageText->clauses() as $clauseText) {
            $clauses[] = $this->clauses->fromText($clauseText);
        }

        return new Message($clauses);
    }
}