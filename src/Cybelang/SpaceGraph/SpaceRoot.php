<?php

namespace MemMemov\Cybelang\SpaceGraph;

class SpaceRoot
{
    private $rootName;

    public function __construct(
        string $rootName
    ) {
        $this->rootName = $rootName;
    }

    public function loadSpacesIntoCache(SpaceCache $spaceCache, Nodes $nodes): void
    {
        $rootNode = $nodes->nodeForValue($this->rootName);
        $spaceNodes = $rootNode->all();

        foreach ($spaceNodes as $spaceNode) {
            $spaceName = $nodes->valueForNode($spaceNode);
            $space = new Space($spaceName, $spaceNode, $nodes);
            $spaceCache->set($space);
        }
    }

    public function addNewSpace(SpaceCache $spaceCache, Nodes $nodes, string $spaceName): void
    {
        $spaceNode = $nodes->nodeForValue($spaceName);
        $rootNode = $nodes->nodeForValue($this->rootName);
        $rootNode->add($spaceNode);
        $space = new Space($spaceName, $spaceNode, $nodes);
        $spaceCache->set($space);
    }
}