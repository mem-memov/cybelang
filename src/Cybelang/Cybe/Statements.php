<?php

namespace MemMemov\Cybelang\Cybe;

class Statements implements Destructable
{
    /** @var Graph */
    private $graph;
    /** @var Messages */
    private $messages;
    /** @var Contexts */
    private $contexts;
    
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
        
        if (!is_null($this->contexts)) {
            $contexts = $this->contexts;
            $this->contexts = null;
            $contexts->destruct();
        }
    }
    
    public function setContexts(Contexts $contexts)
    {
        if (!is_null($this->contexts)) {
            throw new ForbidCollectionRedefinition();
        }
        
        $this->contexts = $clauses;
    }
}
