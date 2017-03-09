<?php

namespace MemMemov\Cybelang\Cybe;

class Utterances implements Destructable
{
    /** @var Graph */
    private $graph;
    /** @var Messages */
    private $messages;
    /** @var Authors */
    private $authors;
    
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

        if (!is_null($this->authors)) {
            $authors = $this->authors;
            $this->authors = null;
            $authors->destruct();
        }
    }
    
    public function setAuthors(Authors $authors)
    {
        if (!is_null($this->authors)) {
            throw new ForbidCollectionRedefinition();
        }
        
        $this->authors = $authors;
    }
}
