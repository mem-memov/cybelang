<?php

namespace MemMemov\Cybelang\SpaceGraph;

//use MemMemov\Cybelang\Cybe\SpaceGraph;

class Spaces // implements SpaceGraph
{
    private $nodes;
    private $cache;
    private $rootName;

    public function __construct(
        Nodes $nodes,
        SpaceCache $cache,
        string $rootName
    ) {
        $this->nodes = $nodes;
        $this->cache = $cache;
        $this->rootName = $rootName;
    }

    public function provideSpace(string $spaceName): Space
    {
        if (!$this->cache->hasSpaceWithName($spaceName)) {
            // load all spaces
            $rootNode = $this->nodes->nodeForValue($this->rootName);
            $spaceNodes = $rootNode->all();

            foreach ($spaceNodes as $spaceNode) {
                if (!$this->cache->hasSpaceWithId($spaceNode->id())) {
                    $space = new Space($spaceName, $spaceNode, $this->nodes);
                    $this->cache->set($space);
                }
            }

            if (!$this->cache->hasSpaceWithName($spaceName)) {
                // create new space
                $spaceNode = $this->nodes->nodeForValue($spaceName);
                $rootNode->add($spaceNode);
                $space = new Space($spaceName, $spaceNode, $this->nodes);
                $this->cache->set($space);
            }
        }

        return $this->cache->getSpaceWithName($spaceName);
    }

    /**
     * @param Node $node
     *
     * @return Space
     */
    public function spaceOfNode(Node $node): Space
    {
        if ($this->cache->isEmpty()) {
            // load all spaces
            $rootNode = $this->nodes->nodeForValue($this->rootName);
            $spaceNodes = $rootNode->all();

            foreach ($spaceNodes as $spaceNode) {
                $spaceName = $this->nodes->valueForNode($spaceNode);
                $space = new Space($spaceName, $spaceNode, $this->nodes);
                $this->cache->set($space);
            }
        }

        $nodeSpaces = array_filter(
            $this->cache->getAll(),
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