<?php

namespace MemMemov\Cybelang\Cybe;

class Statements
{
    private $graph;
    private $contexts;
    private $messages;
    
    public function __construct(
        Graph $graph,
        Contexts $contexts,
        Messages $messages
    ) {
        $this->graph = $graph;
        $this->contexts = $contexts;
        $this->messages = $messages;
    }

}
