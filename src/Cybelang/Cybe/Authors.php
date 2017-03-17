<?php

namespace MemMemov\Cybelang\Cybe;

class Authors implements Destructable
{
    private static $graphSpace = 'author';

    /** @var Graph */
    private $graph;
    private $messages;
    /** @var Utterances */
    private $utterances;
    
    private $parser;
    
    public function __construct(
        Graph $graph,
        Messages $messages,
        Utterances $utterances,
        Parser\Messages $parser
    ) {
        $this->graph = $graph;
        $this->messages = $messages;
        $this->utterances = $utterances;
        $this->parser = $parser;
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
    
    public function createAuthor(): Author
    {
        $authorNode = $this->graph->createNode(self::$graphSpace, []);
        
        return new Author(
            $authorNode->id(),
            $this->messages,
            $this->utterances,
            $this->parser
        );
    }
}
