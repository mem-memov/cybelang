<?php

namespace MemMemov\Cybelang\Cybe;

use Psr\Log\LoggerInterface;

class Authors implements Destructable
{
    private static $graphSpace = 'author';

    /** @var Graph */
    private $graph;
    /** @var Messages */
    private $messages;
    /** @var Utterances */
    private $utterances;
    /** @var LoggerInterface */
    private $logger;
    
    private $parser;
    
    public function __construct(
        Graph $graph,
        Messages $messages,
        Utterances $utterances,
        Parser\Messages $parser,
        LoggerInterface $logger
    ) {
        $this->graph = $graph;
        $this->messages = $messages;
        $this->utterances = $utterances;
        $this->parser = $parser;
        $this->logger = $logger;
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
        
        $this->logger->info('author(' . $authorNode->id() . ') created');
        
        return new Author(
            $authorNode->id(),
            $this->messages,
            $this->utterances,
            $this->parser
        );
    }
}
