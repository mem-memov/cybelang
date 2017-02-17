<?php

namespace MemMemov\Cybe;

class Phrases
{
    private $graph;
    private $words;

    public function __construct(
        Graph $graph,
        Words $words
    ) {
        $this->graph = $graph;
        $this->words = $words;
    }

    public function fromWords(array $wordStrings): Phrase
    {
        $wordIds = array_map(function (string $letters) {
            return $this->words->fromLetters($letters)->id();
        }, $wordStrings);

        $wordSequence = $this->graph->readOrCreateSequence('phrase', $words);

        return new Phrase($wordSequence);
    }
}