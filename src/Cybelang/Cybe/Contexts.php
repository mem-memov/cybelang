<?php

namespace MemMemov\Cybelang\Cybe;

class Contexts
{
    private $graph;
    private $statements;
    private $messages;
    
    public function __construct(
        Graph $graph,
        Statements $statements,
        Messages $messages
    ) {
        $this->graph = $graph;
        $this->statements = $statements;
        $this->messages = $messages;
    }

}
