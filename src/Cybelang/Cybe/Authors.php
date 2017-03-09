<?php

namespace MemMemov\Cybelang\Cybe;

class Authors implements Destructable
{
    /** @var Graph */
    private $graph;
    /** @var Utterances */
    private $utterances;
    
    public function __construct(
        Graph $graph,
        Utterances $utterances
    ) {
        $this->graph = $graph;
        $this->utterances = $utterances;
    }
    
    public function destruct()
    {
        $this->graph = null;
        
        if (!is_null($this->utterances)) {
            $utterances = $this->utterances;
            $this->utterances = null;
            $utterances->destruct();
        }
    }
}
