<?php

namespace MemMemov\Cybelang\Cybe;

use Psr\Log\LoggerInterface;

class Contexts implements Destructable
{
    /** @var Graph */
    private $graph;
    /** @var Messages */
    private $messages;
    /** @var Statements */
    private $statements;
    /** @var LoggerInterface */
    private $logger;
    
    public function __construct(
        Graph $graph,
        Messages $messages,
        LoggerInterface $logger
    ) {
        $this->graph = $graph;
        $this->messages = $messages;
        $this->statements = null;
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
