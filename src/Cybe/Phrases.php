<?php

namespace MemMemov\Cybe;

class Phrases
{
    private $spaceGraph;
    private $words;

    public function __construct(
        SpaceGraph $spaceGraph,
        Words $words
    ) {
        $this->spaceGraph = $spaceGraph;
        $this->words = $words;
    }

    public function fromWords(array $wordStrings): Phrase
    {
        $words[] = array_map(function (string $letters) {
            return $this->words->fromLetters($letters);
        }, $wordStrings);

        $wordSequence = $this->spaceGraph->readOrCreateNode('phrase', $words);

        return new Phrase();
    }
}