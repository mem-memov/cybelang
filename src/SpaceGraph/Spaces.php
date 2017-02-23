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
     * @return Space
     */
    public function spaceOfNode(Node $node): Space
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

        $nodeSpaces = array_filter(
            $this->spacesByName, 
            function(Space $space) use ($node) {
                return $space->has($node);
            }
        );

        $nodeSpaceCount = count();

        if (0 === $nodeSpaceCount) {
            throw new ForbidNodeInNoSpace(sprintf('Node %d has no space', $node->id()));
        }
        
        if (1 < $nodeSpaceCount) {
            throw new ForbidOneNodeInManySpaces(sprintf('Node %d more than one space', $node->id()));
        }

        return $nodeSpaces[0];
    }

    /**
     * @param Node[] $nodes
     * @return Space[]
     */
    public function uniqueSpacesOfNodes(array $nodes): array
    {
        $uniqueSpaces = [];

        foreach ($nodes as $node) {
            $space = $this->spaceOfNode($node);
            $uniqueSpaces[$space->id()] = $space;
        }

        return array_values($uniqueSpaces);
    }

    /**
     * @param Node[] $nodes
     * @return bool
     */
    public function inSameSpace(array $nodes): bool
    {
        $uniqueSpaces = $this->uniqueSpacesOfNodes($nodes);

        return 1 === count($uniqueSpaces);
    }
}