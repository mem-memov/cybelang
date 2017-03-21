<?php

namespace MemMemov\Cybelang\Cybe;

use Psr\Log\LoggerInterface;

class Authors implements Destructable, Spaced
{
    private static $graphSpace = 'author';

    /** @var Graph */
    private $graph;
    /** @var Messages */
    private $messages;
    /** @var Utterances */
    private $utterances;
    /** @var Parser\Messages */
    private $parser;
    /** @var LoggerInterface */
    private $logger;

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
    
    public function graphSpace(): string
    {
        return self::$graphSpace;
    }
    
    public function createAuthor(): Author
    {
        $authorNode = $this->graph->createNode(self::$graphSpace, [], []);
        
        $this->logger->info('author(' . $authorNode->id() . ') created');
        
        return new Author(
            $authorNode->id(),
            $this->messages,
            $this->utterances,
            $this->parser
        );
    }
    
    public function getAuthor(int $id): Author
    {
        $authorNode = $this->graph->readNode(self::$graphSpace, $id);
        
        return new Author(
            $authorNode->id(),
            $this->messages,
            $this->utterances,
            $this->parser
        );
    }
}
