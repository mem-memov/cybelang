<?php

namespace MemMemov\SpaceGraph;

use MemMemov\Cybe\SpaceGraph;

class Spaces implements SpaceGraph
{
    private $nodes;
    private $rootName;
    private $spaceNodess;

    public function __construct(
        Nodes $nodes,
        string $rootName
    ) {
        $this->nodes = $nodes;
        $this->rootName = $rootName;
        $this->spaceNodes = [];
    }

    public function provideSpace(string $spaceName): Space
    {
        if (!array_key_exists($spaceName, $this->spaceNodes)) {
            $spaceNode = $this->nodes->provideForValue($spaceName);
            $rootNode = $this->nodes->provideForValue($this->rootName);
            $rootNode->add($spaceNode);
            $this->spaceNodes[$spaceName] = $spaceNode;
        }

        return new Space(
            $spaceName,
            $this->spaceNodes[$spaceName]
        );
    }
}