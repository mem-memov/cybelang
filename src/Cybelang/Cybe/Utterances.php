<?php

namespace MemMemov\Cybelang\Cybe;

use Psr\Log\LoggerInterface;

class Utterances implements Destructable
{
    private static $graphSpace = 'utterance';
    
    /** @var Graph */
    private $graph;
    /** @var Messages */
    private $messages;
    /** @var Authors */
    private $authors;
    /** @var LoggerInterface */
    private $logger;
    
    public function __construct(
        Graph $graph,
        Messages $messages,
        LoggerInterface $logger
    ) {
        $this->graph = $graph;
        $this->messages = $messages;
        $this->authors = null;
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
    
    public function create(Message $message, Author $author)
    {
        $utteranceNode = $this->graph->createNode(self::$graphSpace, [$message->id()]);

        $this->graph->addNodeToRow($author->id(), $utteranceNode->id());
        
        $this->logger->info('utterance created', ['id' => $utteranceNode->id(), 'message' => $message->id(), 'author' => $author->id()]);
    }
    
    public function ofAuthor(Author $author, int $limit): array
    {
        $utteranceNodes = $this->graph->readRow(self::$graphSpace, $author->id(), $limit);

        $utterances = [];
        foreach ($utteranceNodes as $utteranceNode) {
            $utterances[] = new Utterance(
                $utteranceNode->id(),
                $this->authors,
                $this->messages
            );
        }
        
        return $utterances;
    }
}
