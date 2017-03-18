<?php

namespace MemMemov\Cybelang\Cybe;

use Psr\Log\LoggerInterface;

class Statements implements Destructable
{
    /** @var Graph */
    private $graph;
    /** @var Messages */
    private $messages;
    /** @var Contexts */
    private $contexts;
    /** @var LoggerInterface */
    private $logger;
    
    public function __construct(
        Graph $graph,
        Messages $messages,
        LoggerInterface $logger
    ) {
        $this->graph = $graph;
        $this->messages = $messages;
        $this->contexts = null;
        $this->logger = $logger;
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
