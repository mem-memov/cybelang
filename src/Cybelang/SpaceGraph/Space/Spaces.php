<?php

namespace MemMemov\Cybelang\SpaceGraph\Space;

use MemMemov\Cybelang\SpaceGraph\Node;
use MemMemov\Cybelang\SpaceGraph\Nodes;
//use MemMemov\Cybelang\Cybe\SpaceGraph;

class Spaces // implements SpaceGraph
{
    private $nodes;
    private $spaceCache;
    private $spaceRoot;

    public function __construct(
        Nodes $nodes,
        SpaceCache $spaceCache,
        SpaceRoot $spaceRoot
    ) {
        $this->nodes = $nodes;
        $this->spaceCache = $spaceCache;
        $this->spaceRoot = $spaceRoot;
    }

    public function provideSpace(string $spaceName): Space
    {
        if (!$this->spaceCache->hasSpaceWithName($spaceName)) {

            $this->spaceRoot->loadSpacesIntoCache($this->spaceCache, $this->nodes);

            if (!$this->spaceCache->hasSpaceWithName($spaceName)) {
                $this->spaceRoot->addNewSpace($this->spaceCache, $this->nodes, $spaceName);
            }
        }

        return $this->spaceCache->getSpaceWithName($spaceName);
    }

    /**
     * @param Node $node
     * @return Space
     * @throws ForbidNodeInNoSpace
     * @throws ForbidOneNodeInManySpaces
     */
    public function spaceOfNode(Node $node): Space
    {
        if ($this->spaceCache->isEmpty()) {
            $this->spaceRoot->loadSpacesIntoCache($this->spaceCache, $this->nodes);
        }

        $nodeSpaces = array_filter(
            $this->spaceCache->getAll(),
            function(Space $space) use ($node) {
                return $space->has($node);
            }
        );

        $nodeSpaceCount = count($nodeSpaces);

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