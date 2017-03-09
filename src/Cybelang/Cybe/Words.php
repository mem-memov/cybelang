<?php

namespace MemMemov\Cybelang\Cybe;

class Words implements Destructable
{
    private static $graphSpace = 'word';
    
    /** @var Graph */
    private $graph;
    /** @var Phrases */
    private $phrases;

    public function __construct(
        Graph $graph
    ) {
        $this->graph = $graph;
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