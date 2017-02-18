<?php

namespace MemMemov\SpaceGraph;

use MemMemov\Cybe\SpaceGraph;

class Spaces implements SpaceGraph
{
    private $graph;
    private $root;

    public function __construct(
        Graph $graph,
        string $rootKey
    ) {
        $this->graph = $graph;
        $this->root = $this->graph->readOrCreateValue($rootKey);
    }

    public function provideSpace(string $name): Space
    {
        $value = $this->graph->privideNodeForValue($name);
        $this->root->addNode($value);

        return new Space(
            $value,
            $this->graph
        );
    }
}