<?php

namespace MemMemov\Cybe;

class Words
{
    private $spaceGraph;

    public function __construct(
        SpaceGraph $spaceGraph
    ) {
        $this->spaceGraph = $spaceGraph;
    }

    public function fromLetters(string $letters): Word
    {
        $graphValue = $this->spaceGraph->readOrCreateValue('word', $letters);

        return new Word($graphValue);
    }
}