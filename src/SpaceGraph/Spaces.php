<?php

namespace MemMemov\SpaceGraph;

use MemMemov\Cybe\SpaceGraph;

class Spaces implements SpaceGraph
{
    private $nodes;
    private $rootName;
    private $spacesByName;
    private $spacesById;

    public function __construct(
        Nodes $nodes,
        string $rootName
    ) {
        $this->nodes = $nodes;
        $this->rootName = $rootName;
        $this->spacesByName = [];
        $this->spacesById = [];
    }

    public function provideSpace(string $spaceName): Space
    {
        if (!array_key_exists($spaceName, $this->spacesByName)) {
            // load all spaces
            $rootNode = $this->nodes->nodeForValue($this->rootName);
            $spaceNodes = $rootNode->all();

            foreach ($spaceNodes as $spaceNode) {
                if (!array_key_exists($spaceNode->id(), $this->spacesById)) {
                    $space = new Space($spaceName, $spaceNode);
                    $this->spacesByName[$spaceName] = $space;
                    $this->spacesById[$spaceNode->id()] = $space;
                }
            }

            if (!array_key_exists($spaceName, $this->spacesByName)) {
                // create new space
                $spaceNode = $this->nodes->nodeForValue($spaceName);
                $rootNode->add($spaceNode);
                $this->spacesByName[$spaceName] = $space;
                $this->spacesById[$spaceNode->id()] = $space;
            }
        }

        return $this->spacesByName[$spaceName];
    }

    /**
     * @param Node $node
     *
     * @return Space[]
     */
    public function ofNode(Node $node): array
    {
        if (empty($this->spacesByName) || empty($this->spacesById)) {
            // load all spaces
            $rootNode = $this->nodes->nodeForValue($this->rootName);
            $spaceNodes = $rootNode->all();

            foreach ($spaceNodes as $spaceNode) {
                $spaceName = $this->nodes->valueForNode($spaceNode);
                $space = new Space($spaceName, $spaceNode);
                $this->spacesByName[$spaceName] = $space;
                $this->spacesById[$spaceNode->id()] = $space;
            }
        }

        $nodeSpaces = array_filter($this->spacesByName, function(Space $space) use ($node) {
            return $space->has($node);
        });

        return $nodeSpaces;
    }
}