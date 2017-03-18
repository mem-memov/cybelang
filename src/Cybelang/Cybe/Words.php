<?php

namespace MemMemov\Cybelang\Cybe;

use Psr\Log\LoggerInterface;

class Words implements Destructable
{
    private static $graphSpace = 'word';
    
    /** @var Graph */
    private $graph;
    /** @var Phrases */
    private $phrases;
    /** @var LoggerInterface */
    private $logger;

    public function __construct(
        Graph $graph,
        LoggerInterface $logger
    ) {
        $this->graph = $graph;
        $this->phrases = null;
        $this->logger = $logger;
    }
    
    public function destruct()
    {
        $this->graph = null;
        
        if (!is_null($this->phrases)) {
            $phrases = $this->phrases;
            $this->phrases = null;
            $phrases->destruct();
        }
    }
    
    public function setPhrases(Phrases $phrases)
    {
        if (!is_null($this->phrases)) {
            throw new ForbidCollectionRedefinition();
        }
        
        $this->phrases = $phrases;
    }

    public function fromLetters(string $letters): Word
    {
        $wordNode = $this->graph->provideValueNode(self::$graphSpace, $letters);
        
        $this->logger->info('word provided', [$wordNode->id() , $letters]);

        return new Word(
            $wordNode->id(),
            $letters
        );
    }

    public function ofPhrase(Phrase $phrase)
    {
        $phraseSequence = $this->graph->readSequenceNodes(self::$graphSpace, $phrase->id());

        $words = [];

        foreach ($phraseSequence as $node) {
            $nodeId = $node->id();
            $words[] = new Word(
                $nodeId,
                $this->graph->getNodeValue($nodeId)
            );
        }

        return $words;
    }
}