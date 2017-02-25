<?php

namespace MemMemov\Cybelang\SpaceGraph;

use MemMemov\Cybelang\Cybe\GraphNode;

class SpaceNode implements GraphNode
{
    private $id;
    private $spaceNodes;

    public function __construct(
        int $id,
        SpaceNodes $spaceNodes
    ) {
        $this->id = $id;
        $this->spaceNodes = $spaceNodes;
    }

    public function id(): int
    {
        return $this->id;
    }

    public function one(string $type): GraphNode
    {
        return $this->spaceNodes->getOneNode($type, $this->id);
    }

    /**
     * @param string $type
     * @return GraphNode[]
     */
    public function all(string $type): array
    {
        return $this->spaceNodes->findNodes($type, $this->id);
    }
}