<?php

namespace MemMemov\Cybelang\Cybe;

class Contexts implements Destructable
{
    /** @var Graph */
    private $graph;
    /** @var Messages */
    private $messages;
    /** @var Statements */
    private $statements;
    
    public function __construct(
        Graph $graph,
        Messages $messages
    ) {
        $this->graph = $graph;
        $this->messages = $messages;
    }
    
    public function destruct()
    {
        $this->graph = null;
        
        if (!is_null($this->messages)) {
            $messages = $this->messages;
            $this->messages = null;
            $messages->destruct();
        }
        
        if (!is_null($this->statements)) {
            $statements = $this->statements;
            $this->statements = null;
            $statements->destruct();
        }
    }
    
    public function setStatements(Statements $statements)
    {
        if (!is_null($this->statements)) {
            throw new ForbidCollectionRedefinition();
        }
        
        $this->statements = $statements;
    }
}
