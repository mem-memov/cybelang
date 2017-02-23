<?php

namespace MemMemov\Cybe;

class Words
{
    private static $graphSpace = 'word';
    private $graph;

    public function __construct(
        Graph $graph
    ) {
        $this->graph = $graph;
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