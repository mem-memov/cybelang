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
        $phraseSequence = $this->graph->readSequence($phrase->id());

        $words = [];

        $phraseSequence->each(function (int $id) use ($words) {
            $wordValue = $this->graph->readValue($id);
            $words[] = new Word(
                $wordValue->id(),
                $wordValue->content()
            );
        });

        return $words;
    }
}