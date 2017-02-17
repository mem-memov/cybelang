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
        $graphValue = $this->graph->createValue(self::$graphSpace, $letters);

        return new Word(
            $graphValue->id(),
            $letters
        );
    }

    public function ofPhrase(Phrase $phrase)
    {
        $phraseSequence = $this->graph->readSequence($phrase->id());

        $words = [];

        $phraseSequence->each(function (int $id) use ($words) {
            $wordValue = $this->graph->readValue(self::$graphSpace, $id);
            $words[] = new Word(
                $wordValue->id(),
                $wordValue->content()
            );
        });

        return $words;
    }
}